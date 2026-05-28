<?php

namespace App\Http\Controllers;

use App\Models\Offreemploi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OffreemploiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offreemplois = Offreemploi::orderByDESC('created_at')->get();

        $title = "Liste des offres d'emploi";

        return view('dashboard.offreemplois.index', compact('offreemplois','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Créer une offre d'emploi";

        return view('dashboard.offreemplois.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //dd($request);

            $this->validate($request, [
                'libelle' => 'required|string',
                'localisation' => 'required|string',
                'description' => 'nullable',
                'datefin' => 'nullable|date',
            ]);

            $offreemploi = Offreemploi::create([
                'libelle' => $request->libelle,
                'localisation' => $request->localisation,
                'description' => $request->description,
                'datefin' => $request->datefin,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('offreemplois.index')->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Offreemploi $offreemploi)
    {
        $title = "Afficher une offre d'emploi";
        return view('dashboard.offreemplois.show', compact('offreemploi','title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Offreemploi $offreemploi)
    {
        $title = "Modifier une offre d'emploi";
        return view('dashboard.offreemplois.edit', compact('offreemploi','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offreemploi $offreemploi)
    {
        try {
            //dd($request);

            $this->validate($request, [
                'libelle' => 'required|string',
                'localisation' => 'required|string',
                'description' => 'nullable|string',
                'datefin' => 'nullable|date',
            ]);

            $offreemploi->update([
                'libelle' => $request->libelle,
                'localisation' => $request->localisation,
                'description' => $request->description,
                'datefin' => $request->datefin,
                'autor_id' => Auth::user()->id,
            ]);


            return redirect()->route('offreemplois.index')->with("success", 'Donnée modifiées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Offreemploi $offreemploi)
    {
        $offreemploi->delete();

        return redirect()->route('offreemplois.index')->with("success", 'Donnée supprimées');
    }
}
