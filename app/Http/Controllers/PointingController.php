<?php

namespace App\Http\Controllers;

use App\Models\Pointing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PointingController extends Controller
{

    /**
     * @param string $ip
     * @return bool
     */
    public function ipIsCorrect(string $ip) : bool
    {

        $data = DB::table('ip_configs')->select('ip')->pluck('ip');
        foreach($data as $value)
            $ips[] = $value;

        if(in_array($ip, $ips, true))
            return true;
        return false;

    }
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        if(in_array('responsable-gestionnaire-des-ressources-humaines', userPermissions()) || in_array('assistant-gestionnaire-des-ressources-humaines', userPermissions()) || in_array('chef-barm', userPermissions()))
            $pontings = Pointing::orderByDESC('created_at')->get();
        else
            $pontings = Pointing::orderByDESC('created_at')->wherePersonalId(auth()->user()->id)->get();

        $start_from = setting('app_pointing_start_from');
        $end_to = setting('app_pointing_end_to');

        return view('dashboard.pointing.index', [
            'title' => 'Historique de pointage',
            'pointings' => $pontings,
            'data' => [
                "start_from" => $start_from,
                "end_to" => $end_to,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $ip = $this->ipIsCorrect((string)$request->ip());
        if(!$ip)
            return back()->with('error', 'Veuillez vous rendre sur le site.');

        $date_current = date('Y-m-d');
        $hour_current = date('H:i');
        $moment = ($hour_current < '12:00') ? 'Arrivé' : 'Départ';

        if (!Pointing::where('date', $date_current)->wherePersonalId(auth()->id())->exists())
            return view('dashboard.pointing.create', [
                'title' => 'Pointage',
                'moment' => $moment,
            ]);

        $pointing = Pointing::where('date',$date_current)->wherePersonalId(auth()->id())->first();

        if ($pointing->status == 'finished' || $pointing->end_to)
            return back()->with('error', 'Vous avez déjà pointé.');

        return view('dashboard.pointing.create', [
            'title' => 'Pointage',
            'moment' => $moment,
        ]);

    }

    /**
     * storeOrUpdate a newly created resource in storage.
     */
    public function storeOrUpdate(Request $request)
    {
        $request->validate(['id' => 'nullable|exists:pointings,id']);

        $ip = $this->ipIsCorrect((string)$request->ip());
        if(!$ip)
            return back()->with('error', 'Veuillez vous rendre sur le site.');

        $date_current = date('Y-m-d');
        $hour_current = date('H:i');
        $moment = ($hour_current < '12:00') ? 'Arrivé' : 'Départ';

        if ($moment == 'Arrivé')
            $message = 'Vous avez pointé votre heure d’arrivé.';
        else
            $message = 'Vous avez pointé votre heure de départ.';

        if (!Pointing::where('date',$date_current)->wherePersonalId(auth()->id())->exists()){
            $pointing = new Pointing();
            $pointing -> personal_id = auth()->id();
            $pointing -> date = date('Y-m-d');
            if ($moment == 'Arrivé')
                $pointing -> start_from = $hour_current;
            else
                $pointing -> end_to = $hour_current;
            if($pointing->start_from && $pointing->end_to)
                $pointing -> status = 'finished';

            $pointing->save();

            return to_route('dashboard')->with('success', $message);

        }

        $pointing = Pointing::where('date',$date_current)->wherePersonalId(auth()->id())->first();

        if($pointing->start_from && $pointing->end_to)
            return back()->with('error', 'Vous avez déjà pointé.');

        $pointing -> end_to = $hour_current;
        if($pointing->start_from && $pointing->end_to)
            $pointing -> status = 'finished';
        $pointing->save();

        return to_route('dashboard')->with('success', $message);

    }

    /**
     * Display the specified resource.
     */
    public function show(Pointing $pointing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pointing $pointing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        authPermission('responsable-gestionnaire-des-ressources-humaines');
        $attrs = $request->validate([
            '_id' => 'required|exists:pointings,id',
            'start_from' => 'required',
            'end_to' => 'required',
        ],[
            'start_from.required' => 'La date d\'arrivée est obligatoire',
            'end_to.required' => 'La date de départ est obligatoire',
        ]);

        if($attrs['start_from'] > $attrs['end_to'])
            return back()->with('error', 'La date de départ doit être supérieur à la date arrivé.');

        $pointing = Pointing::findOrFail($attrs['_id']);
        $pointing -> start_from = $attrs['start_from'];
        $pointing -> end_to = $attrs['end_to'];
        $pointing -> status = 'finished';
        $pointing -> save();

        return back()->with('success', 'Données de pointage modifier avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pointing $pointing)
    {
        authPermission('admin');

    }
}
