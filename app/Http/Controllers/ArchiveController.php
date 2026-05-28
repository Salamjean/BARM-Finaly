<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Dossier;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function liste()
     {
         $dossiers = Dossier::all();
         $archives = Archive::all();
         return view('dashboard.archive.liste',compact('archives','dossiers',));
     }

        public function index($dossierId)
    {
        $archives = Archive::where('dossier_id', $dossierId)->get();

        return view('dashboard.archive.index', compact('archives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dossiers = Dossier::all();
        return view('dashboard.archive.create',compact('dossiers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dossier_id' => 'required',
            'titre' => 'required',
            'description' => 'required',
            'date_publication' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $archive = new Archive();

        $archive->dossier_id = $request->dossier_id;
        $archive->titre = $request->titre;
        $archive->description = $request->description;
        $archive->date_publication = $request->date_publication;

        // telecharger l'image
        $pdfName = $request->file('image')->getClientOriginalName();
             $path = $request->file('image')->move(public_path('assets/images'), $pdfName);
             $archive->image = $pdfName;


        $archive->save();
        
        return redirect()->route('archive.liste')->with('success', 'Cet élément a été enregistré avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $archive = Archive::findOrFail($id);
        return view('dashboard.archive.show',compact('archive'));
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dossiers = Dossier::all();
        $archive = Archive::find($id);
        return view('dashboard.archive.edit',compact('archive','dossiers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'dossier_id' => 'required',
            'titre' => 'required',
            'description' => 'required',
            'date_publication' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $archive = Archive::find($id);

        $archive->dossier_id = $request->dossier_id;
        $archive->titre = $request->titre;
        $archive->description = $request->description;
        $archive->date_publication = $request->date_publication;

        // telecharger l'image
        $pdfName = $request->file('image')->getClientOriginalName();
             $path = $request->file('image')->move(public_path('assets/images'), $pdfName);
             $archive->image = $pdfName;


        $archive->save();

        return redirect()->route('archive.index')->with('success', 'Archive modifié avec succès');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $archive = Archive::find($id);
        $archive->delete();
        
        return redirect()->route('archive.liste')->with('success', 'Cet élément a été supprimé avec succès');

    }

    public function downloadImage($id)
{
    $archive = Archive::findOrFail($id);
    $pathToFile = storage_path('app/public/'. $archive->image); 

    return response()->download($pathToFile);
}

}
