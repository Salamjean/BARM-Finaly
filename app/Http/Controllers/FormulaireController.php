<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormulaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.formulaire_reconversion.etat_civil.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.formulaire_reconversion.situation_famille.index');
    }

    public function coordonne()
    {
        return view('dashboard.formulaire_reconversion.coordonnees.index');
    }
    public function professionnelle()
    {
        return view('dashboard.formulaire_reconversion.situation_professionnelle.index');
    }
    public function projet_professionnel()
    {
        return view('dashboard.formulaire_reconversion.projet_professionnel.index');
    }
    public function accident()
    {
        return view('dashboard.formulaire_reconversion.accident_maladie.index');
    }
    public function condition()
    {
        return view('dashboard.formulaire_reconversion.conditions_depart.index');
    }
    /**
     * 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
