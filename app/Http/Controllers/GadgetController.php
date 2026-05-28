<?php

namespace App\Http\Controllers;

use App\Models\Gadget;
use Illuminate\Http\Request;

class GadgetController extends Controller
{

    public function user($personal = 'responsable-communication')
    {
        authPermission($personal);
        return auth()->user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->user();
        $gadgets = Gadget::orderByDESC('created_at')->get();

        return view('dashboard.gadget.index', [
            'title' => 'Liste des gadgets',
            'gadgets' => $gadgets,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string|unique:gadgets,name',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric',
        ]);

        // $attrs['quantity_total'] = $attrs['quantity'];
        Gadget::create($attrs);

        return back()->with('success', 'Gadget ajouté avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Gadget $gadget)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gadget $gadget)
    {
        $attrs = $request->validate([
            'name' => 'required|string|unique:gadgets,name,'. $gadget->id,
            'description' => 'nullable|string',
            'quantity' => 'required|numeric',
        ]);

        $gadget->update($attrs);

        return back()->with('success', 'Données de gadget modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gadget $gadget)
    {
        //
    }
}
