<?php

namespace App\Http\Controllers;

use App\Models\Cvlm;
use Illuminate\View\View;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CvlmStoreRequest;
use App\Http\Requests\CvlmUpdateRequest;
use App\Models\CandidatureControl;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CvlmController extends Controller
{

    public function candidats()
    {

        $candidats = Candidature::orderByDESC('created_at')->where('death','0')->where('resignation','0')->where('orientation','entreprise-privee')->get();

        $title = 'Les candidats';

        return view('dashboard.cvlm.candidats', compact('candidats','title'));
    }

    public function index(Candidature $candidat)
    {
        $cvlms = Cvlm::orderByDESC('created_at')->where('candidature_id',$candidat->id)->get();

        $title = 'Liste des CV et lettres de motivation';

        return view('dashboard.cvlm.index', compact('cvlms','title','candidat'));
    }

    public function create(Candidature $candidat)
    {
        $title = 'Editer un rendez-vous';

        return view('dashboard.cvlm.create', compact('title', 'candidat'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);

            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'candidature_id' => 'required|exists:candidatures,id',
                'commentaire' => 'nullable|string',
                'poste' => 'required|string',
                'cv' => 'nullable|file',
                'lm' => 'nullable|file',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $filePathCv = null;
            $filePathLm = null;

            if ($request->hasFile('cv')) {
                $fileName = uniqid('cv_') . '.' . $request->file('cv')->getClientOriginalExtension();
                $request->cv->move(saveByEnv() .'data/docs/cvlm', $fileName);
                $filePathCv = 'data/docs/cvlm/' . $fileName;
            }

            if ($request->hasFile('lm')) {
                $fileName = uniqid('lm_') . '.' . $request->file('lm')->getClientOriginalExtension();
                $request->lm->move(saveByEnv() .'data/docs/cvlm', $fileName);
                $filePathLm = 'data/docs/cvlm/' . $fileName;
            }

            $cvlm = Cvlm::create([
                'date' => $request->date,
                'candidature_id' => $request->candidature_id,
                'commentaire' => $request->commentaire,
                'poste' => $request->poste,
                'cv' => $filePathCv,
                'lm' => $filePathLm,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('cvlms.index',$request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function show(Request $request, Cvlm $cvlm)
    {
        return view('dashboard.cvlm.show', compact('cvlm'));
    }

    public function edit(Request $request, Cvlm $cvlm)
    {
        return view('dashboard.cvlm.edit', compact('cvlm'));
    }

    public function update(Request $request, Cvlm $cvlm)
    {
        $cvlm->update($request->validated());

        $request->session()->flash('cvlm.id', $cvlm->id);

        return redirect()->route('cvlms.index');
    }

    public function destroy(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');

        $cvlm = Cvlm::findOrFail($id);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $cvlm->candidature_id,
            'type' => 'deleted',
            'table' => 'cvlms',
            'data' => json_encode($cvlm),
        ]);

        $cvlm->delete();

        return response()->json(['success' => true]);
    }

    public function updateComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'commentaire' => 'nullable|string',
            ]);

            $cvlm = Cvlm::findOrFail($id);

            $cvlm->update([
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
