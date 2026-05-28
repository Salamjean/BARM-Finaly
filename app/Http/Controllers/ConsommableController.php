<?php

namespace App\Http\Controllers;

use App\Models\Consommable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConsommableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consommables = Consommable::all();

        return view('dashboard.consommable.index', compact('consommables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.consommable.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'designation' => 'required|string',
                'description' => 'nullable',
                'qte_disponible' => 'required|integer',
            ]);

            $consommable = Consommable::create([
                'designation' => $request->designation,
                'description' => $request->description,
                'qte_disponible' => $request->qte_disponible,
                'is_visible' => '1',
            ]);

            return redirect()->route('consommables.index')->with("success", 'Données enregistré');
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
        $consommable = Consommable::findOrFail($id);

        return view('dashboard.consommable.show', compact('consommable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $consommable = Consommable::findOrFail($id);

        return view('dashboard.consommable.edit', compact('consommable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        try {
            $this->validate($request, [
                'designation' => 'required|string',
                'description' => 'nullable',
                'qte_disponible' => 'required|integer',
            ]);
            $consommable = Consommable::findOrFail($id);
            $consommable->update([
                'designation' => $request->designation,
                'description' => $request->description,
                'qte_disponible' => $request->qte_disponible,
            ]);

            if ($request->is_visible && $request->is_visible == 'on')
                $consommable->is_visible = '1';
            else
                $consommable->is_visible = '0';
            $consommable->save();

            return redirect()->route('consommables.index')->with("success", 'Données modifiées');
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
        $consommable = Consommable::findOrFail($id);

        $consommable->delete();

        return redirect()->route('consommables.index')->with("success", 'Donnée supprimée');
    }
}
