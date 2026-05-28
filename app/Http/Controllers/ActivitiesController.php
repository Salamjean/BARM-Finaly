<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ActivitiesStoreRequest;
use App\Http\Requests\ActivitiesUpdateRequest;
use App\Models\Activities;


class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Liste des activité de communication';
        $activities = Activities::orderBy('created_at', 'asc')->get();

        return view('dashboard.com.activities.list', compact('title', 'activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createActivities()
    {
        $title = 'Activité de communication';

        return view('dashboard.com.activities.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivitiesStoreRequest $request)
    {

        $cible = $request->input('cible');
        $canaux = $request->input('canal');

        $activities = Activities::create([
            'title' => $request->title,
            'objectifs' => $request->objectifs,
            'cible' => implode(', ', $cible),
            'canal' => implode(', ', $canaux),
            'periode' => $request->periode,
            'budget' => $request->budget,
            'source' => $request->source,
            'observations' => $request->observations,
        ]);

        return redirect()->route('activities.list')->with('success', 'La formation du bénéficiaire a bien été enregistrée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $title = 'Activité de communication';
        $activities = Activities::find($id);

        return view('dashboard.com.activities.edit', compact('title','activities'));
    }

    public function view($id)
    {
        $title = 'Activité de communication';
        $activities = Activities::find($id);

        return view('dashboard.com.activities.show', compact('title','activities'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ActivitiesUpdateRequest  $request, $id)
    {

        $activities = Activities::findOrFail($id);

        $activities->update([
            'title' => $request->title,
            'objectifs' => $request->objectifs,
            'cible' => implode(', ', $request->input('cible')),
            'canal' => implode(', ', $request->input('canal')),
            'periode' => $request->periode,
            'budget' => $request->budget,
            'source' => $request->source,
            'observations' => $request->observations,

        ]);
        return redirect()->route('activities.list')->with('success', 'Information modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activities = Activities::where('id', $id)->firstOrFail();
        $activities->delete();

        return redirect()->route('activities.list')->with('success', trans("Cette activité a bien été supprimée !"));
    }

    public function status($id)
    {
        $activities = Activities::findOrFail($id);
        $newStatus = $activities->status === 'En cours'? 'Terminée' : ($activities->status === 'En attente'? 'En cours' : 'En attente');

        $activities->update(['status' => $newStatus]);

        return back()->with('success', "Statut de cette activité à été changé avec succès!.");
    }


}
