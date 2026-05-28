<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Bilancompetence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\BilancompetenceStoreRequest;
use App\Http\Requests\BilancompetenceUpdateRequest;
use App\Models\CandidatureControl;

class BilancompetenceController extends Controller
{
    public function candidats()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death','0')->where('resignation','0')->where('orientation','entreprise-privee')->get();

        $title = 'Les candidats';

        return view('dashboard.bilancompetence.candidats', compact('candidats','title'));
    }

    public function candidatsfp()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death','0')->where('resignation','0')->where('orientation','fonction-publique')->get();

        $title = 'Les candidats';

        return view('dashboard.bilancompetence.candidats', compact('candidats','title'));
    }

    public function index(Candidature $candidat)
    {
        $bilancompetences = Bilancompetence::orderByDESC('created_at')->where('candidature_id',$candidat->id)->get();

        $title = 'Liste des bilan de compétences';

        return view('dashboard.bilancompetence.index', compact('bilancompetences', 'title', 'candidat'));
    }

    public function create(Candidature $candidat)
    {
        $title = 'Faire un bilan de compétences';

        return view('dashboard.bilancompetence.create', compact('title', 'candidat'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'date' => 'required|date',
                'candidature_id' => 'required|exists:candidatures,id',
            ]);


            Bilancompetence::create([
                'date' => $request->date,
                'candidature_id' => $request->candidature_id,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('bilancompetences.index',$request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function presence(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'presence' => 'required|int',
                'comment' => 'nullable|string',
                'rapport' => 'nullable|file',
            ]);

            $filePath = null;

            if ($request->hasFile('rapport')) {
                $fileName = uniqid('rapport_') . '.' . $request->file('rapport')->getClientOriginalExtension();
                $request->rapport->move(saveByEnv() . 'data/docs/bilancompetence', $fileName);
                $filePath = 'data/docs/bilancompetence/' . $fileName;
            }

            $bilancompetence = Bilancompetence::findOrFail($request->bilancompetence_id);

            $bilancompetence->update([
                'presence' => $request->presence,
                'comment' => $request->comment,
                'rapport' => $filePath,
            ]);


            return redirect()->route('bilancompetences.index', $request->candidat_id)->with("success", 'Donnée modifiées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }

    }

    public function show(Request $request, Bilancompetence $bilancompetence)
    {
        return view('dashboard.bilancompetence.show', compact('bilancompetence'));
    }

    public function edit(Request $request, Bilancompetence $bilancompetence)
    {
        return view('dashboard.bilancompetence.edit', compact('bilancompetence'));
    }

    public function update(Request $request, Bilancompetence $bilancompetence)
    {
        $bilancompetence->update($request->validated());

        $request->session()->flash('bilancompetence.id', $bilancompetence->id);

        return redirect()->route('bilancompetences.index');
    }

    public function destroy(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');
        $bilancompetence = Bilancompetence::findOrFail($id);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $bilancompetence->candidature_id,
            'type' => 'deleted',
            'table' => 'bilancompetences',
            'data' => json_encode($bilancompetence),
        ]);

        $bilancompetence->delete();

        return response()->json(['success' => true]);
    }

    public function updateComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'comment' => 'nullable|string',
            ]);

            $bilancompetence = Bilancompetence::findOrFail($id);

            $bilancompetence->update([
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
