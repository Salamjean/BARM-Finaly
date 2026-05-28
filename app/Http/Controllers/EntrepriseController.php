<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EntrepriseStoreRequest;
use App\Http\Requests\EntrepriseUpdateRequest;
use Illuminate\Validation\ValidationException;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::orderByDESC('created_at')->get();

        $title = 'Liste des entreprises';

        return view('dashboard.entreprise.index', compact('entreprises','title'));
    }

    public function create()
    {
        $title = 'Créer une entreprise';

        return view('dashboard.entreprise.create', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'nom' => 'required|string',
                'localisation' => 'required|string',
                'specialisation' => 'required|string',
                'num_decharge' => 'nullable|string',
                'nom_point_focal' => 'required|string',
                'num_point_focal' => 'required|string',
                'email_point_focal' => 'nullable|string',
            ]);

            $entreprise = Entreprise::create([
                'nom' => $request->nom,
                'localisation' => $request->localisation,
                'specialisation' => $request->specialisation,
                'num_decharge' => $request->num_decharge,
                'nom_point_focal' => $request->nom_point_focal,
                'num_point_focal' => $request->num_point_focal,
                'email_point_focal' => $request->email_point_focal,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('entreprises.index',$request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function show(Request $request, Entreprise $entreprise)
    {
        $title = 'Afficher une entreprise';
        return view('dashboard.entreprise.show', compact('entreprise','title'));
    }

    public function edit(Request $request, Entreprise $entreprise)
    {
        $title = 'Modifier une entreprise';
        return view('dashboard.entreprise.edit', compact('entreprise','title'));
    }

    public function update(Request $request, Entreprise $entreprise)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'nom' => 'required|string',
                'localisation' => 'required|string',
                'specialisation' => 'required|string',
                'num_decharge' => 'nullable|string',
                'nom_point_focal' => 'required|string',
                'num_point_focal' => 'required|string',
                'email_point_focal' => 'nullable|string',
            ]);

            $entreprise->update([
                'nom' => $request->nom,
                'localisation' => $request->localisation,
                'specialisation' => $request->specialisation,
                'num_decharge' => $request->num_decharge,
                'nom_point_focal' => $request->nom_point_focal,
                'num_point_focal' => $request->num_point_focal,
                'email_point_focal' => $request->email_point_focal,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('entreprises.index',$request->candidature_id)->with("success", 'Donnée modifiées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function destroy(Request $request, Entreprise $entreprise)
    {
        $entreprise->delete();

        return redirect()->route('entreprises.index')->with("success", 'Donnée supprimées');
    }
}
