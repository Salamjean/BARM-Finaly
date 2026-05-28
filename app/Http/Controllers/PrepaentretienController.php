<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Prepaentretien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\PrepaentretienStoreRequest;
use App\Http\Requests\PrepaentretienUpdateRequest;
use App\Models\CandidatureControl;

class PrepaentretienController extends Controller
{

    public function candidats()
    {

        $candidats = Candidature::orderByDESC('created_at')->where('death','0')->where('resignation','0')->where('orientation','entreprise-privee')->get();

        $title = 'Les candidats';

        return view('dashboard.prepaentretien.candidats', compact('candidats','title'));
    }

    public function index(Candidature $candidat)
    {
        $prepaentretiens = Prepaentretien::orderByDESC('created_at')->where('candidature_id',$candidat->id)->get();

        $title = 'Liste des rendez-vous';

        return view('dashboard.prepaentretien.index', compact('prepaentretiens','title','candidat'));
    }

    public function create(Candidature $candidat)
    {
        $title = 'Editer un rendez-vous';

        return view('dashboard.prepaentretien.create', compact('title', 'candidat'));
    }

    public function store(PrepaentretienStoreRequest $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'date' => 'required|date',
                'candidature_id' => 'required|exists:candidatures,id',
                'commentaire' => 'nullable|string',
            ]);

            $prepaentretien = Prepaentretien::create([
                'date' => $request->date,
                'candidature_id' => $request->candidature_id,
                'commentaire' => $request->commentaire,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('prepaentretiens.index',$request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function show(Request $request, Prepaentretien $prepaentretien)
    {
        return view('dashboard.prepaentretien.show', compact('prepaentretien'));
    }

    public function edit(Request $request, Prepaentretien $prepaentretien)
    {
        return view('dashboard.prepaentretien.edit', compact('prepaentretien'));
    }

    public function update(PrepaentretienUpdateRequest $request, Prepaentretien $prepaentretien)
    {
        $prepaentretien->update($request->validated());

        $request->session()->flash('prepaentretien.id', $prepaentretien->id);

        return redirect()->route('prepaentretiens.index');
    }

    public function destroy(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');

        $prepaentretien = Prepaentretien::findOrFail($id);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $prepaentretien->candidature_id,
            'type' => 'deleted',
            'table' => 'prepaentretiens',
            'data' => json_encode($prepaentretien),
        ]);

        $prepaentretien->delete();

        return response()->json(['success' => true]);
    }

    public function updateComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'commentaire' => 'nullable|string',
            ]);

            $prepaentretien = Prepaentretien::findOrFail($id);

            $prepaentretien->update([
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
