<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Candidatsadmi;
use App\Models\Inscriptionconcour;
use App\Models\Inscriptionconcours;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\InscriptionconcoursStoreRequest;
use App\Http\Requests\InscriptionconcoursUpdateRequest;
use App\Models\CandidatureControl;

class InscriptionconcoursController extends Controller
{

    public function candidats()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death', '0')->where('resignation', '0')->where('orientation', 'fonction-publique')->get();

        $title = 'Liste des candidats';

        return view('dashboard.inscriptionconcour.candidats', compact('candidats', 'title'));
    }

    public function candidatsadmis()
    {
        $candidats = Candidatsadmi::orderByDESC('created_at')->get();

        $title = 'Liste des admis';

        return view('dashboard.inscriptionconcour.candidatsadmis', compact('candidats', 'title'));
    }

    public function candidatsajournes()
    {
        $inscriptionconcours = Inscriptionconcour::orderByDESC('created_at')->where('status', '0')->get();

        $title = 'Liste des ajournés';

        return view('dashboard.inscriptionconcour.candidatsajournes', compact('inscriptionconcours', 'title'));
    }

    public function index(Candidature $candidat)
    {
        $inscriptionconcours = Inscriptionconcour::orderByDESC('created_at')->where('candidature_id', $candidat->id)->get();

        $title = 'Liste des dossiers soumis';

        return view('dashboard.inscriptionconcour.index', compact('inscriptionconcours', 'title', 'candidat'));
    }

    public function create(Candidature $candidat)
    {
        $title = 'Faire une inscription';

        return view('dashboard.inscriptionconcour.create', compact('title', 'candidat'));
    }

    public function store(Request $request)
    {

        try {
            // dd($request);

            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'candidature_id' => 'required|exists:candidatures,id',
                'intitule_concours' => 'required|string',
                'type_concours' => 'required|string',
                'recu' => 'nullable|file',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $filePath = null;

            if ($request->hasFile('recu')) {
                $fileName = uniqid('recu_') . '.' . $request->file('recu')->getClientOriginalExtension();
                $request->recu->move(saveByEnv() . 'data/docs/recu_payement', $fileName);
                $filePath = 'data/docs/recu_payement/' . $fileName;
            }

            Inscriptionconcour::create([
                'date' => $request->date,
                'candidature_id' => $request->candidature_id,
                'intitule_concours' => $request->intitule_concours,
                'type_concours' => $request->type_concours,
                // 'status' => $request->status,
                'recu' => $filePath,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('inscriptionconcours.index', $request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function decision(Request $request)
    {
        try {

            $this->validate($request, [
                'candidature_id' => 'required|exists:candidatures,id',
                'status' => 'required|string',
                'inscriptionconcour_id' => 'required|exists:inscriptionconcours,id',
                'attestation' => 'nullable|file',
            ]);

            $inscriptionconcour = Inscriptionconcour::findOrFail($request->inscriptionconcour_id);
            $candidature = Candidature::findOrFail($request->candidature_id);

            $filePath = null;

            if ($request->hasFile('attestation')) {
                $fileName = uniqid('attestation_admission_') . '.' . $request->file('attestation')->getClientOriginalExtension();
                $request->attestation->move(saveByEnv() . 'data/docs/attestation_admission_', $fileName);
                $filePath = 'data/docs/attestation_admission_/' . $fileName;
            }

            $inscriptionconcour->update([
                'status' => $request->status,
            ]);

            if ($request->status == 1) {
                $decision = Candidatsadmi::create([
                    'inscriptionconcour_id' => $inscriptionconcour->id,
                    'candidature_id' => $request->candidature_id,
                    'intitule_concours' => $inscriptionconcour->intitule_concours,
                    'type_concours' => $inscriptionconcour->type_concours,
                    'autor_id' => Auth::user()->id,
                    'attestation' => $filePath,
                ]);

                $candidature->update([
                    'admissionconcours' => '1',
                    'post_monitored' => true,
                    'concour_id' => $decision->id,
                ]);
            }


            return back()->with("success", $request->status == 1 ? "Candidat admins aux concours" : "Candidat non admis aux concours");
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function affectation(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'candidature_id' => 'required|exists:candidatures,id',
                'affectation' => 'required|string',
                'candidatsadmi_id' => 'required|exists:candidatsadmis,id',
            ]);

            $candidatsadmi = Candidatsadmi::findOrFail($request->candidatsadmi_id);
            $candidature = Candidature::findOrFail($request->candidature_id);

            $candidatsadmi->update([
                'affectation' => $request->affectation,
            ]);

            $candidature->update([
                'affectation' => $request->affectation,
            ]);

            return back()->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function show(Request $request, Inscriptionconcour $inscriptionconcour)
    {
        return view('dashboard.inscriptionconcour.show', compact('inscriptionconcour'));
    }

    public function edit(Request $request, Inscriptionconcour $inscriptionconcour)
    {
        return view('dashboard.inscriptionconcour.edit', compact('inscriptionconcour'));
    }

    public function update(Request $request, Inscriptionconcour $inscriptionconcour)
    {
        $inscriptionconcour->update($request->validated());

        $request->session()->flash('inscriptionconcour.id', $inscriptionconcour->id);

        return redirect()->route('inscriptionconcours.index');
    }

    public function destroy(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');

        $inscriptionconcour = Inscriptionconcour::findOrFail($id);
        if ($inscriptionconcour->status == 1)
            return response()->json(['success' => false, 'message' => 'Le concours est admis, vous ne pouvez pas le supprimer']);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $inscriptionconcour->candidature_id,
            'type' => 'deleted',
            'table' => 'inscriptionconcours',
            'data' => json_encode($inscriptionconcour),
        ]);

        $inscriptionconcour->delete();

        return response()->json(['success' => true]);
    }
}
