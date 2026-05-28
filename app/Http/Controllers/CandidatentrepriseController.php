<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Entreprise;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Candidatentreprise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CandidatentrepriseStoreRequest;
use App\Http\Requests\CandidatentrepriseUpdateRequest;
use App\Models\CandidatureControl;

class CandidatentrepriseController extends Controller
{

    public function candidats()
    {
        $candidats = Candidature::orderByDESC('created_at')
            ->where('death', false)
            ->where('disbursement', false)
            ->where('resignation', false)
            ->where('en_poste', '0')
            ->where('admissionconcours', '0')
            ->get();

        $title = 'Les candidats';

        return view('dashboard.candidatentreprise.candidats', compact('candidats', 'title'));
    }

    public function index()
    {
        $candidatentreprises = Candidatentreprise::orderByDesc('created_at')->get();

        $datas = $candidatentreprises->map(function ($item) {
            return [
                'entreprise' => $item->entreprise,
                'date_mise_disposition' => $item->date_mise_disposition,
            ];
        })->unique(function ($item) {
            return $item['entreprise'] . $item['date_mise_disposition'];
        })->values();

        $title = 'Les mises à disposition';

        return view('dashboard.candidatentreprise.index', compact('candidatentreprises', 'title', 'datas'));
    }

    public function mise_a_disposition()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death', '0')->where('resignation', '0')->where('orientation', 'entreprise-privee')->where('en_poste', '0')->get();

        $entreprises = Entreprise::orderByDESC('created_at')->get();

        $title = 'Mise à dispositions des candidats';

        return view('dashboard.candidatentreprise.mise_a_disposition', compact('entreprises', 'title', 'candidats'));
    }

    public function store_mise_a_disposition(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'entreprise' => 'required|string',
                'candidatures' => 'required|exists:candidatures,id',
                'date_mise_disposition' => 'required|date',
                'poste' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->entreprise == 'other') {
                $data = Entreprise::create([
                    'nom' => $request->nom,
                    'autor_id' => Auth::user()->id,
                ]);

                $entreprise = $data->nom;
            } else {
                $entreprise = $request->entreprise;
            }

            foreach ($request->candidatures as $candidat) {

                $candidatentreprise = Candidatentreprise::create([
                    'entreprise' => $entreprise,
                    'date_mise_disposition' => $request->date_mise_disposition,
                    'poste' => $request->poste,
                    'candidature_id' => $candidat,
                    'autor_id' => Auth::user()->id,
                ]);
            }

            // $candidatures = $request->candidatures;
            // $candidatentreprise->candidatures()->attach($candidatures);

            return  redirect()->route('candidatentreprises.index', $request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function store_candidature_spontannee(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'entreprise' => 'required|string',
                'candidature_id' => 'required|exists:candidatures,id',
                'date_mise_disposition' => 'required|date',
                'poste' => 'required|string',
                'lettre_recommandation' => 'nullable|file',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->entreprise == 'other') {
                $data = Entreprise::create([
                    'nom' => $request->nom,
                    'autor_id' => Auth::user()->id,
                ]);

                $entreprise = $data->nom;
            } else {
                $entreprise = $request->entreprise;
            }

            $filePath = null;
            if ($request->hasFile('lettre_recommandation')) {
                $fileName = uniqid('lettre_recommandation_') . '.' . $request->file('lettre_recommandation')->getClientOriginalExtension();
                $request->lettre_recommandation->move(saveByEnv() . 'data/docs/lettre_recommandation', $fileName);
                $filePath = 'data/docs/lettre_recommandation/' . $fileName;
            }


            $candidatentreprise = Candidatentreprise::create([
                'entreprise' => $entreprise,
                'date_mise_disposition' => $request->date_mise_disposition,
                'candidature_id' => $request->candidature_id,
                'poste' => $request->poste,
                'lettre_recommandation' => $filePath,
                'autor_id' => Auth::user()->id,
            ]);


            // $candidatures = $request->candidatures;
            // $candidatentreprise->candidatures()->attach($candidatures);

            return  redirect()->route('candidatentreprises.show_candidatentreprise', $request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function changestatut(Request $request)
    {
        try {

            $this->validate($request, [
                'statut' => 'required|string',
                'type_contrat' => 'nullable|string',
                'contrat' => 'nullable|file',
                'service' => 'nullable|string',
                'date_db' => 'nullable|date',
                'date_fin' => 'nullable|date',
                'localisation' => 'nullable|string',
                'commentaire' => 'nullable',
            ]);

            $candidatentreprise = Candidatentreprise::findOrFail($request->candidatentreprise_id);
            $candidat = Candidature::findOrFail($candidatentreprise->candidature_id);

            $filePath = null;
            if ($request->hasFile('contrat')) {
                $fileName = uniqid('contrat_') . '.' . $request->file('contrat')->getClientOriginalExtension();
                $request->contrat->move(saveByEnv() . 'data/docs/contrat', $fileName);
                $filePath = 'data/docs/contrat/' . $fileName;
            }

            if ($request->statut == 'accepted') {

                $candidatentreprise->update([
                    'statut' => $request->statut,
                    'type_contrat' => $request->type_contrat,
                    'contrat' => $filePath,
                    'service' => $request->service,
                    'date_db' => $request->date_db,
                    'date_fin' => $request->date_fin,
                    'localisation' => $request->localisation,
                    'commentaire' => $request->commentaire,
                ]);

                $candidat->update([
                    'en_poste' => '1',
                    'post_monitored' => true,
                    'poste_id' => $candidatentreprise->id,
                    'affectation' => $request->localisation,
                ]);
            } elseif ($request->statut == 'refused') {
                $candidatentreprise->update([
                    'statut' => $request->statut,
                ]);
            }

            return back()->with("success", 'Donnéeenregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function end_poste(Request $request)
    {
        try {
            $this->validate($request, [
                'statut' => 'required|string',
            ]);

            $candidatentreprise = Candidatentreprise::findOrFail($request->candidatentreprise_id);
            $candidat = Candidature::findOrFail($candidatentreprise->candidature_id);

            $candidatentreprise->update([
                'statut' => 'finished',
            ]);

            $candidat->update([
                'en_poste' => '0',
                'post_monitored' => false,
                'poste_id' => null,
                'affectation' => null,
            ]);

            return back()->with("success", 'Donnéeenregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function create_candidatentreprise(Candidature $candidat)
    {
        $entreprises = Entreprise::orderByDESC('created_at')->get();

        $title = 'Candidature spontanée';

        return view('dashboard.candidatentreprise.create_candidatentreprise', compact('entreprises', 'title', 'candidat'));
    }

    public function show_candidatentreprise(Candidature $candidat)
    {

        $candidatentreprises = Candidatentreprise::where('candidature_id', $candidat->id)->orderByDesc('created_at')->get();

        $title = 'Liste des candidatures spontanées';

        return view('dashboard.candidatentreprise.show_candidatentreprise', compact('candidatentreprises', 'title'));
    }

    public function store(Request $request)
    {
        $candidatentreprise = Candidatentreprise::create($request->validated());

        $request->session()->flash('candidatentreprise.id', $candidatentreprise->id);

        return redirect()->route('candidatentreprises.index');
    }

    public function show($entreprise, $date)
    {

        $candidatentreprises = Candidatentreprise::where('entreprise', $entreprise)->where('date_mise_disposition', $date)->orderByDesc('created_at')->get();


        return view('dashboard.candidatentreprise.show', compact('candidatentreprises', 'entreprise', 'date'));
    }

    public function edit(Candidatentreprise $candidatentreprise)
    {
        return view('dashboard.candidatentreprise.edit', compact('candidatentreprise'));
    }

    public function update(Request $request, Candidatentreprise $candidatentreprise)
    {
        $candidatentreprise->update($request->validated());

        $request->session()->flash('candidatentreprise.id', $candidatentreprise->id);

        return redirect()->route('candidatentreprises.index');
    }


    public function suivie_ep_candidats()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death', '0')->where('resignation', '0')->where('orientation', 'entreprise-privee')->get();

        $title = 'Les candidats';

        return view('dashboard.candidatentreprise.suivie_ep_candidats', compact('candidats', 'title'));
    }

    public function suivie_fp_candidats()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death', '0')->where('resignation', '0')->where('orientation', 'fonction-publique')->get();

        $title = 'Les candidats';

        return view('dashboard.candidatentreprise.suivie_fp_candidats', compact('candidats', 'title'));
    }

    public function destroy(Request $request, string $id)
    {
        authPermission('chef-cellule-formation-et-insertion');

        $candidatentreprise = Candidatentreprise::findOrFail($id);
        if ($candidatentreprise->statut == 'accepted')
            return response()->json(['success' => false, 'message' => 'La candidature est acceptée, vous ne pouvez pas la supprimer']);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $candidatentreprise->candidature_id,
            'type' => 'deleted',
            'table' => 'candidatentreprises',
            'data' => json_encode($candidatentreprise),
        ]);

        $candidatentreprise->delete();

        return response()->json(['success' => true]);
    }

    public function updateComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'commentaire' => 'nullable|string',
            ]);

            $candidatentreprise = Candidatentreprise::findOrFail($id);

            $candidatentreprise->update([
                'commentaire' => $request->commentaire,
            ]);

            return back()->with("success", 'Commentaire modifié avec succès');
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la mise à jour');
        }
    }
}
