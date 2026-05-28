<?php

namespace App\Http\Controllers;

use App\Models\Candidatentretien;
use App\Models\Candidature;
use App\Models\CandidatureControl;
use App\Models\Cohort;
use App\Models\Entretien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class EntretienController extends Controller
{

    public function candidats(Entretien $entretien)
    {
        $candidats = Candidatentretien::orderByDESC('created_at')->where('entretien_id', $entretien->id)->get();

        $title = 'Liste des candidats - BARM';

        return view('dashboard.entretien.candidats', compact('candidats', 'title','entretien'));
    }

    public function index(Request $request, String $type)
    {

        $entretiens = Entretien::orderByDESC('created_at')->where('parcours','entreprise_privee')->where('type',$type)->get();

        $title = 'Liste des pré-entretien - BARM';

        return view('dashboard.entretien.index', compact('entretiens','title', 'type'));
    }

    public function indexfp(Request $request, String $type)
    {
        $entretiens = Entretien::orderByDESC('created_at')->where('parcours','fonction_public')->where('type',$type)->get();

        $title = 'Liste des pré-entretien - BARM';

        return view('dashboard.entretien.indexfp', compact('entretiens','title', 'type'));
    }

    public function create(Request $request, String $type)
    {
        $title = 'Programmer un pré-entretien - BARM';

        $candidats = Candidature::where('death','0')->where('resignation','0')->where('orientation','entreprise-privee')->get();

        return view('dashboard.entretien.create', compact('title','candidats', 'type'));
    }

    // create entretien fonction public
    public function createfp(Request $request, String $type)
    {

        $title = 'Programmer un pré-entretien - BARM';

        $candidats = Candidature::where('death','0')->where('resignation','0')->where('orientation','fonction-publique')->get();

        return view('dashboard.entretien.createfp', compact('title','candidats', 'type'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'date' => 'required|date',
                'candidatures' => 'required|exists:candidatures,id',
                'parcours' => 'required|string',
                'type' => 'required|string',
            ]);

            $entretien = Entretien::create([
                'date' => $request->date,
                'autor_id' => Auth::user()->id,
                'parcours' => $request->parcours,
                'type' => $request->type,
            ]);

            foreach ($request->candidatures as $key => $candidature) {
                $candidatentretien = Candidatentretien::create([
                    'entretien_id' => $entretien->id,
                    'candidature_id' => $candidature,
                ]);
            }

            return redirect()->route('entretiens.index',$request->type)->with("success", 'Donnée enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }

    }

    public function storefp(Request $request)
    {
        try {

            $this->validate($request, [
                'date' => 'required|date',
                'candidatures' => 'required|exists:candidatures,id',
                'parcours' => 'required|string',
                'type' => 'required|string',
            ]);

            $entretien = Entretien::create([
                'date' => $request->date,
                'autor_id' => Auth::user()->id,
                'parcours' => $request->parcours,
                'type' => $request->type,
            ]);

            foreach ($request->candidatures as $key => $candidature) {
                $candidatentretien = Candidatentretien::create([
                    'entretien_id' => $entretien->id,
                    'candidature_id' => $candidature,
                ]);
            }

            return  redirect()->route('entretiens.indexfp',$request->type)->with("success", 'Donnée enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }

    }

    public function destroy(Request $request, string $id)
    {
        $entretien = Entretien::findOrFail($id);
        $entretien->candidatentretiens()->delete();
        $entretien->delete();

        return response()->json(['success' => true]);
    }

    public function destroy_candidatentretiens(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');

        $candidatentretien = Candidatentretien::findOrFail($id);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $candidatentretien->candidature_id,
            'type' => 'deleted',
            'table' => 'candidatentretiens',
            'data' => json_encode($candidatentretien),
        ]);

        $candidatentretien->delete();

        return response()->json(['success' => true]);
    }

    public function presence(Request $request)
    {
        try {
            //dd($request);

            $this->validate($request, [
                'presence' => 'required|int',
                'comment' => 'nullable|string',
            ]);

            // $candidatentretien = Candidatentretien::where('candidature_id', $request->candidat_id)->where('entretien_id', $request->entretien_id)->first();
            $candidatentretien = Candidatentretien::findOrFail($request->candidatentretien_id);

            $candidatentretien->update([
                'presence' => $request->presence,
                'comment' => $request->comment,
            ]);


            return back()->with("success", 'Donnée modifiées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }

    }

    public function show(Request $request, Entretien $entretien)
    {
        return view('dashboard.entretien.show', compact('entretien'));
    }

    public function edit(Request $request, Entretien $entretien)
    {
        return view('dashboard.entretien.edit', compact('entretien'));
    }

    public function update(Request $request, Entretien $entretien)
    {
        $entretien->update($request->validated());

        $request->session()->flash('entretien.id', $entretien->id);

        return redirect()->route('entretiens.index');
    }

    public function updateCandidatentretienComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'comment' => 'nullable|string',
            ]);

            $candidatentretien = Candidatentretien::findOrFail($id);

            $candidatentretien->update([
                'comment' => $request->comment,
            ]);

            return back()->with("success", 'Commentaire modifié avec succès');
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la mise à jour');
        }
    }
}
