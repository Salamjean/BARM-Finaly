<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partenaire;
use App\Models\Candidature;
use App\Models\CandidaturePartenaire;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sessioncollective;
use App\Models\ChoiceFinalAdherent;
use App\Models\Cohort;
use App\Models\Profilage;
use App\Repositories\SmsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class SessioncollectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Liste des sessions collectives - BARM';

        $sessioncollectives = Sessioncollective::orderByDESC('created_at')->get();

        return view('dashboard.sessioncollectives.index', compact('sessioncollectives', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $candidats = Candidature::orderByDESC('created_at')->whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->where('session_collective', '0')->whereNotNull('cohort_id')->get();

        $technicale_partenaires = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-technical%');
        })->get();

        $financial_partenaires = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-financial%');
        })->get();

        $cohortes = Cohort::orderByDESC('created_at')->where('status', '0')->get();


        $title = 'Créer session collective - BARM';

        return view('dashboard.sessioncollectives.create', compact(
            'candidats',
            'technicale_partenaires',
            'financial_partenaires',
            'title',
            'cohortes',
            'candidats'
        ));
    }

    public function getCandidats(Request $request)
    {
        $cohortId = $request->input('cohortId');

        $cohorte = Cohort::find($cohortId);
        if (!$cohorte) {
            return response()->json(['error' => 'Cohorte introuvable'], 404);
        }

        $candidats = $cohorte->candidats->where('orientation', 'auto-emploi');

        $formattedCandidates = [];
        foreach ($candidats as $candidat) {
            $partner = count($candidat->partenaires) > 0 ? $candidat->partenaires->last()->user->username . ' | ' : '';
            $formattedCandidates[] = [
                'id' => $candidat->id,
                'name' => $partner . $candidat->user->mecano . ' | ' . $candidat->user->fullName(),
            ];
        }

        return response()->json($formattedCandidates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'lieu' => 'required|string',
            'date' => 'required|date',
            'heure' => 'required|string',
            'methode_prise_contact' => 'nullable|string',
            'commentaire' => 'nullable|longtext',
            'technicale_partenaires' => 'required|exists:partenaires,id',
            'financial_partenaires' => 'required|exists:partenaires,id',
            'candidatures' => 'required|exists:candidatures,id',
            'cohort_id' => 'required|exists:cohorts,id',
        ]);

        $candidatures = explode(",", $request->candidatures);

        $candidatures = Candidature::whereIn('id', $candidatures)->select('id', 'cohort_id')->get();

        foreach ($candidatures as $candidature) {
            if ($candidature->cohort_id != $request->cohort_id)
                throw ValidationException::withMessages([
                    'candidatures' => 'Les candidatures ne sont pas dans la cohorte choisie',
                ]);
        }

        $sessioncollective = Sessioncollective::create([
            'cohort_id' => $request->cohort_id,
            'lieu' => $request->lieu,
            'date' => $request->date,
            'heure' => $request->heure,
        ]);

        $technicale_partenaires = $request->technicale_partenaires;
        $sessioncollective->partenaires()->attach($technicale_partenaires, [
            'type' => 'partner_technique',
        ]);

        $financial_partenaires = $request->financial_partenaires;
        $sessioncollective->partenaires()->attach($financial_partenaires, [
            'type' => 'partner_financial',
        ]);

        $sessioncollective->candidatures()->attach($candidatures);

        //SMS candidat
        // foreach ($candidatures as $candidature) {
        //     $message = "Vous êtes convié à une session d'information collective qui se tiendrat à $sessioncollective->lieu le $sessioncollective->date à $sessioncollective->heure";
        //     (new SmsRepository($candidature->user()->phone_number, $message))->send();
        // }

        //SMS partenaire financier
        // foreach ($financial_partenaires as $financial_partenaire) {
        //     $message = "Vous êtes convié à une session d'information collective qui se tiendrat à $sessioncollective->lieu le $sessioncollective->date à $sessioncollective->heure";
        //     (new SmsRepository($financial_partenaire->user()->phone_number, $message))->send();
        // }

        //SMS partenaire technique
        // foreach ($technicale_partenaires as $technicale_partenaire) {
        //     $message = "Vous êtes convié à une session d'information collective qui se tiendrat à $sessioncollective->lieu le $sessioncollective->date à $sessioncollective->heure";
        //     (new SmsRepository($technicale_partenaire->user()->phone_number, $message))->send();
        // }

        return redirect()->route('sessioncollectives.index')->with("success", 'Données enregistrées');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sessioncollective = Sessioncollective::findOrFail($id);


        $candidatures = $sessioncollective->candidatures()->orderByPivot('updated_at', 'ASC')->get();

        $title = 'Afficher participants à la session collective - BARM';

        return view('dashboard.sessioncollectives.show', compact('sessioncollective', 'candidatures', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sessioncollective = Sessioncollective::findOrFail($id);

        $candidats = Candidature::orderByDESC('created_at')->whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->where('session_collective', '0')->whereNotNull('cohort_id')->get();

        $technicale_partenaires = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-technical%');
        })->get();

        $financial_partenaires = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-financial%');
        })->get();

        $title = 'Modifier la session collective - BARM';

        return view('dashboard.sessioncollectives.edit', compact(
            'sessioncollective',
            'candidats',
            'technicale_partenaires',
            'financial_partenaires',
            'title'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $sessioncollective = Sessioncollective::findOrFail($id);


        $this->validate($request, [
            'lieu' => 'required|string',
            'date' => 'required|date',
            'heure' => 'required|string',
            'methode_prise_contact' => 'nullable|string',
            'commentaire' => 'nullable|longtext',
            'technicale_partenaires' => 'required|exists:partenaires,id',
            'financial_partenaires' => 'required|exists:partenaires,id',
            'candidatures' => 'required|exists:candidatures,id',
        ]);

        $sessioncollective->update([
            'cohorte_id' => $request->cohorte_id,
            'lieu' => $request->lieu,
            'date' => $request->date,
            'heure' => $request->heure,
        ]);

        $technicale_partenaires = $request->technicale_partenaires;
        $sessioncollective->partenaires()->sync($technicale_partenaires, [
            'type' => 'partner_technique',
        ]);

        $financial_partenaires = $request->financial_partenaires;
        $sessioncollective->partenaires()->sync($financial_partenaires, [
            'type' => 'partner_financial',
        ]);

        $candidatures = $request->candidatures;
        $sessioncollective->candidatures()->sync($candidatures);

        // foreach ($technicale_partenaires as $technicale_partenaire) {

        //     $candidatures = Candidature::whereHas('partenaires', function ($query) use ($technicale_partenaire){
        //         $query->where('partenaire_id', $technicale_partenaire);
        //     })->where('session_collective','0')->get();

        //     foreach ($candidatures as $candidature) {
        //         $sessioncollective->candidatures()->sync($candidature);
        //     }

        // }

        return redirect()->route('sessioncollectives.index')->with("success", 'Donnée modifiées');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sessioncollective = Sessioncollective::findOrFail($id);

        try {
            $sessioncollective->partenaires()->detach();
            $sessioncollective->candidatures()->detach();
            $sessioncollective->delete();

            return redirect()->route('sessioncollectives.index')->with("success", 'Donnée supprimées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    // liste des sessions collectives par partenaires
    public function listepartenersession()
    {
        $user_id = Auth::user()->id;
        $partenaire_id = Partenaire::where('user_id', $user_id)->value('id');

        $sessioncollectives = Sessioncollective::whereHas('partenaires', function ($query) use ($partenaire_id) {
            $query->where('partenaire_id', $partenaire_id);
        })->orderByDesc('created_at')->get();



        $title = 'Liste des sessions collectives - BARM';

        return view('dashboard.sessioncollectives.listepartenersession', compact('sessioncollectives', 'title'));
    }

    // liste des candidats par sessions collectives et par partenaires
    public function listepartenershow(string $id)
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();
        $sessioncollective = Sessioncollective::findOrFail($id);

        $candidatures = $sessioncollective->candidatures;

        // $candidatures = $candidature_session->filter(function ($candidature) use ($partenaire) {
        //     return $candidature->partenaires()->where('partenaire_id', $partenaire->id)->get();
        // });

        $title = 'Afficher participants à la session collective - BARM';

        return view('dashboard.sessioncollectives.listepartenershow', compact('candidatures', 'title', 'partenaire', 'sessioncollective'));
    }

    // validation ou non du candidat par le partenaire / validation ou non du partenaire par le candidat
    public function updatestatuspartnercandidat(Request $request, Candidature $candidature)
    {
        try {

            $user_id = Auth::user()->id;
            $partenaire = Partenaire::where('user_id', $user_id)->first();

            // $profilage = Profilage::find($request->profilage_id);
            $pivotData = $candidature->partenaires->find($partenaire->id)->pivot;

            // $candidature->partenaires()->attach($partenaire, [
            //     'status' => $request->status,
            // ]);


            // $pivotData->update(['status' => $request->status]);

            if ($request->status == 'accepted') {
                $pivotData->update([
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);
                $candidature->update(['partner_technical_id' => $partenaire->id]);

                // $pivotData->update(['profile' => '1']);
            }

            if ($request->status == 'refused') {
                $pivotData->update([
                    'status' => $request->status,
                    'reason_rejet' => $request->motif_refus,
                    'updated_at' => now(),
                ]);
            }


            return back()->with("success", 'Candidature acceptée');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    // liste des candidats présent à une ou plusieurs session collectives
    public function candidaturepresent()
    {
        if (Auth::user()->roles->first()->name == 'POINTS FOCAUX') {
            $candidatures = Candidature::whereHas('createdBy.personnel', function ($query) {
                $query->where('ville_barm', '=', Auth::user()->personnel->ville_barm);
            })->where('resignation', '0')->where('death', '0')
                ->where('orientation', 'auto-emploi')
                ->whereNotNull('session_id')
                ->where('session_collective', '1')
                ->where('status', 'pending')
                ->with('sessioncollectives')
                ->get();
        } else {
            $candidatures = Candidature::where('death', '0')
                ->whereNotNull('session_id')
                ->where('orientation', 'auto-emploi')
                ->where('session_collective', '1')
                ->where('status', 'pending')
                ->with('sessioncollectives')
                ->get();
        }

        $title = 'Liste des candidats présents - BARM';

        return view('dashboard.sessioncollectives.candidaturepresent', compact('candidatures', 'title'));
    }


    // liste des candidats présent à une ou plusieurs session collectives
    public function candidaturepartnerpresent()
    {
        $candidats_present = Candidature::whereHas('sessioncollectives', function ($query) {
            $query->where('presence', '=', 1);
        })->where('session_collective', '1')->where('status', 'pending')->get();

        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        // $candidatures = $candidats_present->filter(function ($candidature) use ($partenaire) {
        //     return $candidature->partenaires()->where('partenaire_id', $partenaire->id)->exists();
        // });

        $candidatures = $candidats_present->filter(function ($candidature) use ($partenaire) {
            return $candidature->partenaires()->where('partenaire_id', $partenaire->id)->exists()
                && !$candidature->rdvpartenaires()->where('partenaire_id', $partenaire->id)->exists();
        });

        $title = 'Liste des candidats présents - BARM';

        return view('dashboard.sessioncollectives.candidaturepartnerpresent', compact('candidatures', 'title'));
    }

    // liste des candidats provisoire
    public function listecandidatureprovisoire()
    {
        $candidats_present = Candidature::whereHas('sessioncollectives', function ($query) {
            $query->where('presence', '=', 1);
        })->where('session_collective', '1')->where('status', 'pending')->get();

        $candidatures = $candidats_present->filter(function ($candidature) {
            return $candidature->partenaires()->where('status', 'accepted')->exists()
                && $candidature->rdvpartenaires()->where('presence', '1')->exists();
        });

        $title = 'Liste provisoire des candidats - BARM';


        return view('dashboard.sessioncollectives.listecandidatureprovisoire', compact('candidatures', 'title'));
    }

    // liste des candidats provisoire par partenaire
    public function candidaturepartnerprovisoire()
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();


        $candidatures = ChoiceFinalAdherent::where('partner_id', $partenaire->id)->get();

        $title = 'Liste provisoire des candidats - BARM';

        return view('dashboard.sessioncollectives.candidaturepartnerprovisoire', compact('candidatures', 'title'));
    }

    // liste des candidatures validées par le chef barm
    public function candidaturevalidated()
    {
        $candidatures = Candidature::whereHas('sessioncollectives', function ($query) {
            $query->where('presence', '=', 1);
        })->where('session_collective', '1')->where('status', 'accepted')->get();

        $title = 'Liste définitives des candidats retenus - BARM';

        return view('dashboard.sessioncollectives.candidaturevalidated', compact('candidatures', 'title'));
    }

    // liste des candidatures validées par le chef barm
    public function partnercandidaturevalidated()
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        $candidatures = Candidature::where('death', '0')->where('orientation', 'auto-emploi')->where(
            'partner_technical_id',
            $partenaire->id
        )->get();


        $title = 'Liste définitives des candidats retenus - BARM';

        return view('dashboard.sessioncollectives.partnercandidaturevalidated', compact('candidatures', 'title'));
    }

    // marquer un candidat present à une session collective
    public function updatecandidatsession(Request $request, Sessioncollective $sessioncollective, Candidature $candidature)
    {

        try {

            $request->validate([
                'presence' => 'required',
                'presence_status' => 'required',
            ]);

            $pivotData = $sessioncollective->candidatures()->where('candidature_id', $candidature->id)->first()->pivot;

            $pivotData->update([
                'presence' => $request->presence,
                'presence_status' => $request->presence_status,
                'updated_at' => now(),
            ]);

            $candidature->update([
                'session_collective' => $request->session_collective,
                'session_id' => $request->session_id
            ]);

            $sessioncollective_id = $sessioncollective->id;

            return redirect()->route('sessioncollectives.show', $sessioncollective_id)->with(
                "success",
                'Candidature refusée'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    // page de modification du partenaire par le conseiller et le candidat apres validation du partenaire
    public function candidatpartner(Candidature $candidature)
    {
        $partenaires = Partenaire::whereHas('candidatures', function ($query) use ($candidature) {
            $query->where('candidature_id', $candidature->id)
                ->where('candidaturepartenaires.status', 'accepted');
        })->get();


        return view('dashboard.sessioncollectives.updatecandidatpartner', compact('candidature', 'partenaires'));
    }

    // fonction de modification du partenaire par le conseiller et le candidat apres validation du partenaire
    public function updatecandidatpartner(Request $request, Candidature $candidature)
    {
        try {
            $newpartenaire = Partenaire::where('id', $request->partenaire_id)->first();

            foreach ($candidature->partenaires as $key => $partenaire) {
                if ($partenaire->id == $newpartenaire->id) {
                    $pivotData = $candidature->partenaires()->where('partenaire_id', $partenaire->id)->first()->pivot;
                    $pivotData->update(['status' => 'accepted']);
                } else {
                    $pivotData = $candidature->partenaires()->where('partenaire_id', $partenaire->id)->first()->pivot;
                    $pivotData->update(['status' => 'refused']);
                }
            }
            return redirect()->route('listecandidatureprovisoire')->with(
                "success",
                'Données modifiées'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    // fonction de changer du partenaire par le conseiller
    public function changecandidatpartner(Request $request)
    {
        try {
            //dd($request);

            $candidature = Candidature::find($request->candidature_id);

            $candidature->partenaires()->sync($request->partenaire_id);

            return redirect()->route('profilage.candidat_profilage', $request->cohort_id)->with(
                "success",
                'Données modifiées'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    // liste des candidats profilés
    public function listecandidature()
    {

        if (Auth::user()->roles->first()->name == 'POINTS FOCAUX') {
            $candidatures = Candidature::whereHas('createdBy.personnel', function ($query) {
                $query->where('ville_barm', '=', Auth::user()->personnel->ville_barm);
            })->orderByDESC('created_at')->whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->whereNotNull('partner_technical_id')->whereNotNull('cohort_id')->get();
        } else {
            $candidatures = Candidature::orderByDESC('created_at')->whereNotNull('partner_technical_id')->whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->whereNotNull('cohort_id')->get();
        }

        $title = 'Liste des candidats profilés - BARM';

        return view('dashboard.sessioncollectives.listecandidature', compact('candidatures', 'title'));
    }

    public function listecandidaturerefuser()
    {

        $allCandidatures = Candidature::with(['partenaires' => function ($query) {
            $query->orderBy('candidaturepartenaires.id', 'desc');
        }])
            ->where('resignation', '0')->where('death', '0')
            ->whereNotNull('cohort_id')
            ->orderByDESC('created_at')
            ->get();

        $candidatures = $allCandidatures->filter(function ($candidature) {
            $dernierPartenaire = $candidature->partenaires->first();
            return $dernierPartenaire && $dernierPartenaire->pivot->status === 'refused';
        });

        $candidaturepartenaires = CandidaturePartenaire::with([
            'candidature.user',
            'partenaire.user'
        ])
            ->whereHas('partenaire')
            ->where('status', 'refused')
            ->whereIn('candidature_id', $allCandidatures->pluck('id'))
            ->orderByDesc('updated_at')
            ->get();

        $partners = Partenaire::all();
        $partenaires = [];
        foreach ($partners as $key => $partner)
            if (in_array('partner-technical', userPermissions($partner->user)))
                (array)$partenaires[] = $partner;

        $title = 'Liste des candidats non profilés - BARM';

        return view('dashboard.sessioncollectives.listecandidaturerefuser', compact('candidatures', 'candidaturepartenaires', 'partenaires', 'title'));
    }

    public function assignPartner(Request $request)
    {
        try {
            $request->validate([
                'candidature_id' => 'required|exists:candidatures,id',
                'partenaire_id' => 'required|exists:partenaires,id',
            ]);


            CandidaturePartenaire::create([
                'candidature_id' => $request->candidature_id,
                'partenaire_id' => $request->partenaire_id,
                // 'status' => 'pending', 
            ]);

            return redirect()->back()->with(
                "success",
                'Le nouveau partenaire technique a été assigné avec succès'
            );
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation des données');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de l\'assignation du partenaire: ' . $e->getMessage());
        }
    }

    public function validatecandidature(Request $request, Candidature $candidature)
    {
        try {
            $candidature->update(['status' => 'accepted']);

            return redirect()->route('candidaturevalidated')->with(
                "success",
                'Données modifiées'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    // fichier pdf d'autorisation d'ouverture de compte
    public function ouverture_compte(Candidature $candidature)
    {

        $title = 'Liste des candidats profilés - BARM';

        $date = date('Y-m-d');

        $pdf = Pdf::loadView('dashboard.sessioncollectives.pdf.ouverture_compte', ['candidature' => $candidature, 'title' => $title]);
        $pdf->setPaper('A4', 'portrait')->render();

        $response = new Response();
        $response->setContent($pdf->output())->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', "inline; filename=$candidature->id-" . date('dmY') .
            ".pdf");

        return $response;
    }

    //Affiche les cohorte
    public function profilage()
    {


        $cohorts = Cohort::orderByDESC('created_at')->where('status', '0')->get();

        $title = 'Organiser un profilage - BARM';

        return view('dashboard.profilages.profilage', compact('cohorts', 'title'));
    }

    //Affiche les profilages par cohorte
    public function index_profilage(Cohort $cohort)
    {

        $profilages = Profilage::where('cohort_id', $cohort->id)->get();

        $title = 'Organiser un profilage - BARM';

        return view('dashboard.profilages.index', compact('profilages', 'title', 'cohort'));
    }

    //Creer un profilage
    public function create_profilage(Cohort $cohort)
    {
        $partenairesNonProfilés = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-technical%');
        })->whereDoesntHave('partenaire.profilage')->with('partenaire')->get()->pluck('partenaire');

        $title = 'Organiser un profilage - BARM';

        return view('dashboard.profilages.create', compact('title', 'cohort', 'partenairesNonProfilés'));
    }

    public function store_profilage(Request $request)
    {
        try {
            $this->validate($request, [
                'start_date' => 'required|date',
                'cohort_id' => 'required|exists:cohorts,id',
                'partenaire_id' => 'required|exists:partenaires,id',
            ]);

            $candidatures = Candidature::whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->whereNotNull('session_id')->where('cohort_id', $request->cohort_id)->whereNull('partner_technical_id')->get();

            $profilage = Profilage::create([
                'cohort_id' => $request->cohort_id,
                'partenaire_id' => $request->partenaire_id,
                'start_date' => $request->start_date,
                'heure' => $request->heure,
            ]);

            $profilage->candidatures()->attach($candidatures);

            return redirect()->route('profilage.index_profilage', $request->cohort_id)->with(
                "success",
                'Données enregistrées'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    //Affiche liste des candidats par profilage organisé
    public function candidat_profilage(String $id)
    {
        $title = 'Liste des candidats à profiler - BARM';
        $candidatures = Candidature::whereStep('completed')
            ->where('resignation', '0')
            ->where('death', '0')
            ->where('absent', '0')
            ->where('orientation', 'auto-emploi')
            ->whereNotNull('session_id')
            ->where('cohort_id', $id)
            ->whereNull('partner_technical_id')
            ->get();

        $partners = Partenaire::all();
        $partner_technicials = [];
        foreach ($partners as $key => $partner)
            if (in_array('partner-technical', userPermissions($partner->user)))
                (array)$partner_technicials[] = $partner;

        return view('dashboard.profilages.candidat_profilage', compact('title', 'candidatures', 'partner_technicials', 'id'));
    }

    //Affiche liste des candidats profiler
    public function end_candidat_profile(String $id)
    {

        $title = 'Liste des candidats profilés - BARM';


        $candidatures = Candidature::whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->whereNotNull('session_id')->where('cohort_id', $id)->whereNotNull('partner_technical_id')->get();


        return view('dashboard.profilages.end_candidat_profile', compact('candidatures', 'title'));
    }

    // liste des COHORTES par partenaires
    public function partenaire_cohort()
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        $cohorts = Cohort::orderByDESC('created_at')->where('status', '0')->get();

        // $candidatures = $candidature_session->filter(function ($candidature) use ($partenaire) {
        //     return $candidature->partenaires()->where('partenaire_id', $partenaire->id)->get();
        // });

        $title = 'Afficher les cohortes - BARM';

        return view('dashboard.profilages.partenaire_cohort', compact(
            'cohorts',
            'title',
            'partenaire'
        ));
    }

    // liste des candidats à profilés par sessions collectives et par partenaires
    public function partenaire_candidat_profilage()
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        $profilage = Profilage::where('partenaire_id', $partenaire->id)->first();
        $candidature_sessions = Candidature::whereStep('completed')
            // ->whereDoesntHave('candidaturePartenaires')
            // ->whereDoesntHave('candidaturePartenaires', function ($query) {
            //     $query->where('status', 'refused');
            // })
            ->whereHas('candidaturePartenaires', function ($query) use ($partenaire) {
                $query->whereNull('status')->where('partenaire_id', $partenaire->id);
            })
            ->whereNull('partner_technical_id')
            ->where('resignation', '0')
            ->where('death', '0')
            ->where('absent', '0')
            ->where('orientation', 'auto-emploi')
            ->whereNotNull('session_id')
            ->get();

        $candidatures = $candidature_sessions->filter(function ($candidature) use ($partenaire) {
            return $candidature->partenaires()->where('partenaire_id', $partenaire->id)->exists();
        });

        $title = 'Liste des candidats à profilés - BARM';

        return view('dashboard.profilages.partenaire_candidat_profilage', compact(
            'profilage',
            'title',
            'partenaire',
            'candidatures'
        ));
    }

    public function histories_profilage()
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        $profilage = Profilage::where('partenaire_id', $partenaire->id)->first();
        $histories = CandidaturePartenaire::whereNotNull('status')
            ->where('partenaire_id', $partenaire->id)
            ->get();

        
        $title = 'Historique des candidats profilés - BARM';

        return view('dashboard.profilages.historique', compact(
            'profilage',
            'title',
            'partenaire',
            'histories'
        ));
    }

    public function partenaire_candidat_profile(Cohort $cohort)
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        $candidatures = Candidature::whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->whereNotNull('session_id')->where('cohort_id', $cohort->id)->where('partner_technical_id', $partenaire->id)->get();


        $title = 'Liste des candidats profilés - BARM';

        return view('dashboard.profilages.partenaire_candidat_profile', compact('title', 'partenaire', 'candidatures'));
    }

    public function end_profilage(Request $request)
    {
        try {
            $this->validate($request, [
                'end_date' => 'required|date',
                'profilage_id' => 'required|exists:profilages,id',
                'end' => 'required|boolean',
            ]);

            $profilage = Profilage::find($request->profilage_id);

            $profilage->update([
                'end_date' => $request->end_date,
                'end' => $request->end,
            ]);

            return redirect()->route('profilage.index_profilage', $profilage->cohort_id)->with(
                "success",
                'Données enregistrées'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    /**
     * Marquer un candidat comme absent lors du profilage
     */
    public function markCandidateAbsent(Request $request)
    {
        try {
            $this->validate($request, [
                'candidature_id' => 'required|exists:candidatures,id',
                'absent_justification' => 'nullable|string|max:500',
            ]);

            $candidature = Candidature::find($request->candidature_id);

            $candidature->update([
                'absent' => '1',
                'absent_date' => now()->toDateString(),
                'absent_justification' => $request->absent_justification,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Le candidat a été marqué comme absent avec succès.'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Affiche la liste des candidats marqués comme absents
     */
    
    public function candidatsAbsents()
    {
        $title = 'Liste des candidats profilés (absents) - BARM';
        $candidatures = Candidature::whereStep('completed')
            ->where('absent', '1')
            ->where('resignation', '0')
            ->where('death', '0')
            ->where('orientation', 'auto-emploi')
            ->whereNotNull('session_id')
            ->with(['user', 'cohort', 'partnerTechnical'])
            ->orderBy('absent_date', 'desc')
            ->get();

        return view('dashboard.profilages.candidats_absents', compact('title', 'candidatures'));
    }

    /**
     * Affiche la liste des candidats refusés (réservé au BARM)
     */
    public function candidatsRefuses()
    {
        $title = 'Liste des candidats profilés réservé au BARM (refusés) - BARM';
        $candidatures = Candidature::whereStep('completed')
            ->where('resignation', '0')
            ->where('death', '0')
            ->where('absent', '0')
            ->where('orientation', 'auto-emploi')
            ->whereNotNull('session_id')
            ->whereHas('candidaturePartenaires', function ($query) {
                $query->where('status', 'refused');
            })
            ->with(['user', 'cohort', 'candidaturePartenaires.partenaire.user'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('dashboard.profilages.candidats_refuses', compact('title', 'candidatures'));
    }
}
