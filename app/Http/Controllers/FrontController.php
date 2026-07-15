<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\JobOffer;
use App\Models\NewsCast;
use App\Models\Partner;
use App\Models\Retired;
use App\Models\RetiredPreregistration;
use App\Models\Setting;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    public function acceuil()
    {
        $partners = Partner::all();
        $news = Ad::all();
        $jobs = JobOffer::all();
        $sliders = NewsCast::all();

        return view('front.pages.acceuil', compact('partners', 'news', 'jobs', 'sliders'));
    }

    public function about()
    {
        $partners = Partner::all();
        $news = Ad::all();
        $teams = Team::orderBy('personal')->get();
        $dg = Team::where('personal','dg')->first();

        return view('front.pages.about', compact('partners', 'news', 'teams', 'dg'));
    }

    public function offres()
    {
        $jobs = JobOffer::all();

        return view('front.pages.offres', compact('jobs'));
    }

    public function single_offre($id)
    {
        $job = JobOffer::findOrFail($id);
        $skills = json_decode($job->skills, true);

        return view('front.pages.single_offre', compact('job', 'skills'));
    }

    public function contact()
    {

        return view('front.pages.contact');
    }

//     public function search(Request $request)
// {
//     $jobs = JobOffer::all();
//     $location = $request->location;
//     $title = $request->title;
//     $sortBy = $request->sortBy; // Critère de tri envoyé par l'utilisateur

//     $jobs = JobOffer::query();

//     // Filtrer par client_id si celui-ci est renseigné
//     if ($location) {
//         $jobs->where('location', $location);
//     }

//     // Filtrer par numéro de proforma si celui-ci est renseigné
//     if ($title) {
//         $jobs->where('title', $title);
//     }

//     // Tri des résultats si un critère de tri est spécifié
//     if ($sortBy) {
//         // Utilisation de orderByRaw pour le tri
//         $jobs->orderByRaw("FIELD(title, '$sortBy')");
//     }

//     // Récupérer les résultats
//     $jobs = $jobs->get();

//     return view('front.pages.offres', compact('jobs','location'));
// }

public function search(Request $request)
{
    $jobs = JobOffer::query();

    // Filtrer par titre si celui-ci est renseigné
    if ($request->title) {
        $jobs->where('title', 'like', '%'. $request->title. '%');
    }

    // Filtrer par localisation 
    if ($request->location) {
        $jobs->where('location', $request->location);
    }
    
    $jobs = $jobs->get();

    // Vérifier si les résultats sont vides
    if ($jobs->isEmpty()) {
        
        $message = "Aucun résultat trouvé pour votre recherche.";
    } else {
        // Sinon, passer les résultats à la vue
        $message = null;
    }

    return view('front.pages.offres', compact('jobs'));
}

public function getTitles($title)
{
    $titles = JobOffer::where('title',$title)->get(); 

    return view('front.pages.titre_offres', compact('titles'));
}

/**
 * Afficher la page de formulaire de préinscription
 */
public function preregistrationForm()
{
    return view('front.pages.preregistration');
}

    /**
     * Vérifier les informations du retraité
     */
    public function verifyRetired(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'mecano' => 'required|string|max:50',
            ], [
                'firstname.required' => 'Le prénom est obligatoire',
                'lastname.required' => 'Le nom est obligatoire',
                'mecano.required' => 'Le mécano est obligatoire',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Erreurs de validation : ' . $validator->errors()->first()
                ], 422);
            }

            $mecanoInput = trim($request->mecano);
            $mecanoSuffix = substr($mecanoInput, -4);
            $firstname = strtolower(trim($request->firstname));
            $lastname = strtolower(trim($request->lastname));

            // On cherche par la fin (4 derniers chiffres) du mecano ou matricule
            $retireds = Retired::where(function($q) use ($mecanoSuffix) {
                $q->where('mecano', 'LIKE', '%' . $mecanoSuffix)
                  ->orWhere('matricule', 'LIKE', '%' . $mecanoSuffix);
            })->get();

            // On filtre en vérifiant que le nom et prénom fournis se retrouvent dans le nom complet
            $retired = $retireds->filter(function($ret) use ($firstname, $lastname) {
                $fullName = strtolower($ret->firstname . ' ' . $ret->lastname);
                return str_contains($fullName, $firstname) && str_contains($fullName, $lastname);
            })->first();

            if (!$retired) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Aucun retraité trouvé avec ce mécano et ces informations.'
                ]);
            }

            // Vérification si une demande n'existe pas déjà
            $existingRequest = RetiredPreregistration::where('mecano', $request->mecano)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Une demande de préinscription est déjà en cours de traitement pour ce mécano.'
                ]);
            }

            // Vérifier si le retraité n'est pas déjà utilisé
            if ($retired->used == 1 || $retired->used === 'yes' || $retired->used === true || $retired->used === '1') {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Vous êtes déjà adhérent au système.'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Informations vérifiées avec succès. Vous pouvez continuer.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur technique est survenue.'
            ], 500);
        }
    }

    /**
     * Traiter la demande de préinscription des retraités
     */
    public function submitPreregistration(Request $request)
    {
        try {
            // Validation des données
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'mecano' => 'required|string|max:50',
                'phone' => 'required|string|max:20',
                'phone2' => 'nullable|string|max:20',
                'residence' => 'required|string|max:255',
            ], [
                'firstname.required' => 'Le prénom est obligatoire',
                'lastname.required' => 'Le nom est obligatoire',
                'mecano.required' => 'Le mécano est obligatoire',
                'phone.required' => 'Le numéro de téléphone est obligatoire',
                'residence.required' => 'Le lieu de résidence est obligatoire',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Erreurs de validation : ' . $validator->errors()->first()
                ], 422);
            }

            $mecanoInput = trim($request->mecano);
            $mecanoSuffix = substr($mecanoInput, -4);
            $firstname = strtolower(trim($request->firstname));
            $lastname = strtolower(trim($request->lastname));

            // On cherche par la fin (4 derniers chiffres) du mecano ou matricule
            $retireds = Retired::where(function($q) use ($mecanoSuffix) {
                $q->where('mecano', 'LIKE', '%' . $mecanoSuffix)
                  ->orWhere('matricule', 'LIKE', '%' . $mecanoSuffix);
            })->get();

            // On filtre en vérifiant que le nom et prénom fournis se retrouvent dans le nom complet
            $retired = $retireds->filter(function($ret) use ($firstname, $lastname) {
                $fullName = strtolower($ret->firstname . ' ' . $ret->lastname);
                return str_contains($fullName, $firstname) && str_contains($fullName, $lastname);
            })->first();

            if (!$retired) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Aucun retraité trouvé avec ce mécano et ces informations.'
                ]);
            }

            // Vérification si une demande n'existe pas déjà
            $existingRequest = RetiredPreregistration::where('mecano', $request->mecano)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Une demande de préinscription est déjà en cours de traitement pour ce mécano.'
                ]);
            }

            // Vérifier si le retraité n'est pas déjà utilisé
            if ($retired->used === 'yes') {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Ce retraité est déjà adhérent au système.'
                ]);
            }

            // Création de la demande de préinscription
            $preregistration = RetiredPreregistration::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'mecano' => $request->mecano,
                'phone' => $request->phone,
                'phone2' => $request->phone2,
                'residence' => $request->residence,
                'verified' => true, // Vérifié car le retraité existe
                'retired_id' => $retired->id,
                'retired_date' => $retired->retired_date,
                'status' => 'pending'
            ]);

            // Log pour le suivi
            Log::info('Nouvelle demande de préinscription retraité', [
                'preregistration_id' => $preregistration->id,
                'mecano' => $request->mecano,
                'fullname' => $request->firstname . ' ' . $request->lastname
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Votre demande de préinscription a été soumise avec succès ! Vous serez contacté dans les plus brefs délais par notre équipe.'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la soumission de préinscription retraité', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur technique est survenue. Veuillez réessayer plus tard.'
            ], 500);
        }
    }
}
