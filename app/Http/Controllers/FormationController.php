<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\View\View;
use App\Models\Entreprise;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Candidatentretien;
use App\Models\Candidatformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FormationStoreRequest;
use App\Http\Requests\FormationUpdateRequest;
use App\Models\CandidatureControl;
use Illuminate\Validation\ValidationException;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::orderByDESC('created_at')->get();

        $title = 'Liste des entreprises';

        return view('dashboard.formation.index', compact('formations','title'));
    }

    public function create()
    {
        $entreprises = Entreprise::orderByDESC('created_at')->get();

        $candidats = Candidature::where('death','0')->where('resignation','0')->where('orientation','entreprise-privee')->get();

        $title = 'Créer une formation';

        return view('dashboard.formation.create', compact('entreprises','candidats','title'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'intitule' => 'required|string',
                'entreprise' => 'required|string',
                'date_fin' => 'nullable|string',
                'date_db' => 'nullable|string',
                'lieu' => 'nullable|string',
                'candidatures' => 'required|array',
            ], [
                'candidatures.required'=> 'Veuillez choisir au moins un candidat',
            ]);

            if ($request->entreprise == 'other') {
                $data = Entreprise::create([
                    'nom' => $request->nom,
                    'autor_id' => Auth::user()->id,
                ]);

                $entreprise = $data->nom;
            } else {
                $entreprise = $request->entreprise;
            }

            $formation = Formation::create([
                'intitule' => $request->intitule,
                'entreprise' => $entreprise,
                'date_fin' => $request->date_fin,
                'date_db' => $request->date_db,
                'lieu' => $request->lieu,
                'autor_id' => Auth::user()->id,
            ]);

            $candidatures = $request->candidatures;
            $formation->candidatures()->attach($candidatures);

            return redirect()->route('formations.index',$request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", $e->getMessage()); 
        }
    }

    public function show(Request $request, Formation $formation)
    {

        $title = 'liste des candidats de la formation';


        return view('dashboard.formation.show', compact('formation','title'));
    }

    public function presence(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'presence' => 'required|int',
                'attestation' => 'nullable|file',
                'commentaire' => 'nullable|string',
            ]);

            $formation = Formation::findOrFail($request->formation_id);

            $pivotData = $formation->candidatures()->where('candidature_id' , $request->candidature_id)->first()->pivot;

            $filePath = null;


            if ($request->hasFile('attestation')) {
                $fileName = uniqid('attestation_') . '.' . $request->file('attestation')->getClientOriginalExtension();
                $request->attestation->move(saveByEnv() . 'data/docs/formation', $fileName);
                $filePath = 'data/docs/formation/' . $fileName;
            }

            $pivotData->update([
                'presence' => $request->presence,
                'attestation' => $filePath,
                'commentaire' => $request->commentaire,
            ]);


            return redirect()->route('formations.show', $formation->id)->with("success", 'Donnée enregistrée');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }

    }

    public function edit(Request $request, Formation $formation)
    {
        return view('dashboard.formation.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $formation->update($request->validated());

        $request->session()->flash('formation.id', $formation->id);

        return redirect()->route('formations.index');
    }

    public function destroy(Request $request, string $id)
    {
        $formation = Formation::findOrFail($id);
        $formation->candidatures()->detach();
        $formation->delete();

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $formation->id,
            'type' => 'deleted',
            'table' => 'formations',
            'data' => json_encode($formation),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy_formations_candidatures(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');

        $formation = Candidatformation::findOrFail($id);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $formation->candidature_id,
            'type' => 'deleted',
            'table' => 'candidatformations',
            'data' => json_encode($formation),
        ]);

        $formation->delete();

        return response()->json(['success' => true]);
    }

    public function updateCandidatformationComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'commentaire' => 'nullable|string',
            ]);

            $candidatformation = Candidatformation::findOrFail($id);

            $candidatformation->update([
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
