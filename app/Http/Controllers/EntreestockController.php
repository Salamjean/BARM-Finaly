<?php

namespace App\Http\Controllers;

use App\Models\Consommable;
use App\Models\Entreestock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EntreestockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entreestocks = Entreestock::all();

        return view('dashboard.entreestock.index', compact('entreestocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $consommables = Consommable::all();

        return view('dashboard.entreestock.create', compact('consommables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try {
            $this->validate($request, [
                'consommable_id'=> 'required|exists:consommables,id',
                'qte_entree' => 'required|integer',
                'date_entree' => 'required|date',
                'fournisseur'=> 'required|string',
                'temoin1' => 'required|string',
                'temoin2' => 'required|string',
                'temoin3' => 'required|string',
                'crator_id' => 'required|exists:users,id',
            ]);

            $entreestock = Entreestock::create([
                'consommable_id' => $request->consommable_id,
                'qte_entree' => $request->qte_entree,
                'date_entree' => $request->date_entree,
                'fournisseur' => $request->fournisseur,
                'temoin1' => $request->temoin1,
                'temoin2' => $request->temoin2,
                'temoin3' => $request->temoin3,
                'crator_id' => Auth::user()->id,
            ]);

            $consommable = Consommable::findOrFail($request->consommable_id);

            $consommable->update([
                'qte_disponible' => $consommable->qte_disponible+$request->qte_entree,
            ]);

            return redirect()->route('entreestock.index')->with("success", 'Données enregistré');
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
    public function show(string $id)
    {
        $entreestock = Entreestock::findOrFail($id);
        return view('dashboard.entreestock.show', compact('entreestock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entreestock = Entreestock::findOrFail($id);
        $consommables = Consommable::all();

        return view('dashboard.entreestock.edit', compact('entreestock','consommables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        try {
            $this->validate($request, [
                'consommable_id'=> 'required|exists:consommables,id',
                'qte_entree' => 'required|integer',
                'date_entree' => 'required|date',
                'fournisseur'=> 'required|string',
                'temoin1' => 'required|string',
                'temoin2' => 'required|string',
                'temoin3' => 'required|string',
                'crator_id' => 'required|exists:users,id',
            ]);

            $entreestock = Entreestock::findOrFail($id);
            $consommableold = Consommable::findOrFail($entreestock->consommable_id);

            $consommableold->update([
                'qte_disponible' => $consommableold->qte_disponible-$entreestock->qte_entree,
            ]);

            $entreestock->update([
                'consommable_id' => $request->consommable_id,
                'qte_entree' => $request->qte_entree,
                'date_entree' => $request->date_entree,
                'fournisseur' => $request->fournisseur,
                'temoin1' => $request->temoin1,
                'temoin2' => $request->temoin2,
                'temoin3' => $request->temoin3,
                'crator_id' => Auth::user()->id,
            ]);

            $consommablenew = Consommable::findOrFail($request->consommable_id);

            $consommablenew->update([
                'qte_disponible' => $consommablenew->qte_disponible+$request->qte_entree,
            ]);

            return redirect()->route('entreestock.index')->with("success", 'Données modifiées');
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
    public function destroy(string $id)
    {
        //
    }
}
