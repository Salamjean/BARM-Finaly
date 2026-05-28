<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Soumissiondossier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\SoumissiondossierStoreRequest;
use App\Http\Requests\SoumissiondossierUpdateRequest;
use App\Models\CandidatureControl;
use App\Models\Choixconcour;
use App\Models\Intituleconcour;
use App\Models\Typeconcour;

class SoumissiondossierController extends Controller
{

    public function candidats()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death','0')->where('resignation','0')->where('orientation','fonction-publique')->get();

        $title = 'Les candidats';

        return view('dashboard.soumissiondossier.candidats', compact('candidats','title'));
    }

    public function choixconcours()
    {
        $candidats = Choixconcour::orderByDESC('created_at')->get();

        $title = 'Les candidats';

        return view('dashboard.soumissiondossier.choixconcours', compact('candidats','title'));
    }

    public function index(Candidature $candidat)
    {
        $soumissiondossiers = Soumissiondossier::orderByDESC('created_at')->where('candidature_id',$candidat->id)->get();

        $title = 'Liste des dossiers soumis';

        $intituleconcours = Intituleconcour::all();

        $typeconcours = Typeconcour::all();

        return view('dashboard.soumissiondossier.index', compact('soumissiondossiers','candidat','title', 'intituleconcours', 'typeconcours'));
    }

    public function create(Candidature $candidat)
    {
        $title = 'Faire une somission de dossier';

        $intituleconcours = Intituleconcour::all();

        $typeconcours = Typeconcour::all();

        return view('dashboard.soumissiondossier.create', compact('title', 'candidat', 'intituleconcours', 'typeconcours'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'date1' => 'required|date',
                'candidature_id' => 'required|exists:candidatures,id',
                'intitule_concours1' => 'required|string',
                'type_concours1' => 'nullable|string',
                'date2' => 'required|date',
                'intitule_concours2' => 'required|string',
                'type_concours2' => 'nullable|string',
            ]);

            if ($request->intitule_concours1 == 'otherintitulechoix1') {

                $intitule_concours1 = $request->other_intitule_concours1;

                if (Intituleconcour::where('libelle', $request->other_intitule_concours1)->doesntExist()) {
                    $intitule = Intituleconcour::create([
                        'libelle' => $request->other_intitule_concours1,
                    ]);
                }

            } else{

                $intitule_concours1 = $request->intitule_concours1;

            }

            if ($request->intitule_concours2 == 'otherintitulechoix2') {

                $intitule_concours2 = $request->other_intitule_concours2;

                if ($request->other_intitule_concours2 != $request->other_intitule_concours1) {
                    $intitule = Intituleconcour::create([
                        'libelle' => $request->other_intitule_concours2,
                    ]);
                }

            } else{

                $intitule_concours2 = $request->intitule_concours2;

            }

            if ($request->type_concours1 == 'othertypechoix1') {

                $type_concours1 = $request->other_type_concours1;

                if (Typeconcour::where('libelle', $request->other_type_concours1)->doesntExist()) {
                    $type = Typeconcour::create([
                        'libelle' => $request->other_intitule_concours1,
                    ]);
                }

            } else{

                $type_concours1 = $request->type_concours1;

            }

            if ($request->type_concours2 == 'othertypechoix2') {

                $type_concours2 = $request->other_type_concours2;

                if ($request->other_type_concours2 != $request->other_type_concours1) {
                    $type = Typeconcour::create([
                        'libelle' => $request->other_intitule_concours2,
                    ]);
                }

            } else{

                $type_concours2 = $request->type_concours2;

            }

            $soumissiondossier = Soumissiondossier::create([
                'date1' => $request->date1,
                'candidature_id' => $request->candidature_id,
                'intitule_concours1' => $intitule_concours1,
                'type_concours1' => $type_concours1,
                'date2' => $request->date2,
                'intitule_concours2' => $intitule_concours2,
                'type_concours2' => $type_concours2,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('soumissiondossiers.index',$request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function choixfinal(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'candidature_id' => 'required|exists:candidatures,id',
                'intitule_concours' => 'required|string',
            ]);

            $soumissiondossier = Soumissiondossier::findOrFail($request->soumissiondossier_id);

            if ($request->intitule_concours == 'other') {
                $intitule = Intituleconcour::create([
                    'libelle' => $request->libelle,
                ]);

                $type = Typeconcour::create([
                    'libelle' => $request->libelle,
                ]);

                $intitule_concours = $intitule->libelle;
                $type_concours = $type->libelle;

            } elseif ($request->intitule_concours == 'choix1') {

                $intitule_concours = $soumissiondossier->intitule_concours1;
                $type_concours = $soumissiondossier->type_concours1;

            } elseif ($request->intitule_concours == 'choix2') {

                $intitule_concours = $soumissiondossier->intitule_concours2;
                $type_concours = $soumissiondossier->type_concours2;

            }

            $choixfinal = Choixconcour::create([
                'candidature_id' => $request->candidature_id,
                'intitule_concours' => $intitule_concours,
                'type_concours' => $type_concours,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('soumissiondossiers.choixconcours')->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function show(Request $request, Soumissiondossier $soumissiondossier)
    {
        return view('dashboard.soumissiondossier.show', compact('soumissiondossier'));
    }

    public function edit(Request $request, Soumissiondossier $soumissiondossier)
    {
        return view('dashboard.soumissiondossier.edit', compact('soumissiondossier'));
    }

    public function update(SoumissiondossierUpdateRequest $request, Soumissiondossier $soumissiondossier)
    {
        $soumissiondossier->update($request->validated());

        $request->session()->flash('soumissiondossier.id', $soumissiondossier->id);

        return redirect()->route('soumissiondossiers.index');
    }

    public function destroy(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');

        $soumissiondossier = Soumissiondossier::findOrFail($id);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $soumissiondossier->candidature_id,
            'type' => 'deleted',
            'table' => 'soumissiondossiers',
            'data' => json_encode($soumissiondossier),
        ]);

        $soumissiondossier->delete();

        return response()->json(['success' => true]);
    }
}
