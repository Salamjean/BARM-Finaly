<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Partenaire;
use App\Models\Rdvpartner;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Repositories\SmsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RdvpartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rdvpartners = Rdvpartner::all();

        return view('dashboard.rdvpartner.index', compact('rdvpartners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        $candidats_present = Candidature::whereHas('sessioncollectives', function ($query) {
        $query->where('presence', '=', 1);
        })->where('session_collective', '1')->where('status', 'pending')->get();

        $candidatures = $candidats_present->filter(function ($candidature) use ($partenaire) {
        return $candidature->partenaires()->where('partenaire_id', $partenaire->id)->exists();
        });

        return view('dashboard.rdvpartner.create', compact($candidatures));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try {
            $this->validate($request, [
                'lieu' => 'required|string',
                'date' => 'required|date',
                'heure' => 'required|string',
                'candidature_id' => 'required|exists:candidatures,id',
            ]);
            
            $partenaire = Partenaire::where('user_id', $request->user_id)->first();
            $rdvpartner = Rdvpartner::create([
                'lieu' => $request->lieu,
                'date' => $request->date,
                'heure' => $request->heure,
                'partenaire_id' => $partenaire->id,
                'candidature_id' => $request->candidature_id,
            ]);

            //SMS candidat
            $message = "Vous êtes convié à une session d'information individuelle avec " .$partenaire->user->username. " qui
            se tiendrat à $rdvpartner->lieu le $rdvpartner->date à $rdvpartner->heure";
            // (new SmsRepository($rdvpartner->candidature->user->phone_number, $message))->send();

            return redirect()->route('candidaturepartnerpresent')->with("success", 'Données enregistrées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
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
        
        try {
            $this->validate($request, [
                'presence' => 'required|boolean',
                'rapport' => 'required',
                'status' => 'required|boolean'
            ]);

            $rdvpartner = Rdvpartner::where('id',$id)->first();
            
            $rdvpartner->update([
                'presence' => $request->presence,
                'rapport' => $request->rapport,
            ]);

            $candidature = Candidature::where('id',$rdvpartner->candidature_id)->first();
            $pivotData = $candidature->partenaires()->where('partenaire_id',$rdvpartner->partenaire_id)->first()->pivot;
            $pivotData->update(['status' => $request->status]);

            return redirect()->route('listepartner')->with("success", 'Données enregistrées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listepartner()
    {
        $user_id = Auth::user()->id;

        $partner = Partenaire::where('user_id', $user_id)->first();

        $rdvpartners = Rdvpartner::where('partenaire_id', $partner->id)->get();

        $title = 'Liste provisoire des cadidats - BARM';

        return view('dashboard.rdvpartner.listepartner', compact('rdvpartners', 'title'));
    }
}
