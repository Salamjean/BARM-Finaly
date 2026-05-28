<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\CreditCommittee;
use Illuminate\Http\Request;

class TenPercentController extends Controller
{
    public function index(){

        $candidatures = Candidature::with('user')
            ->where('credit_committee', true)
            ->where('ten_percent', false)
            ->whereHas('creditCommittee', function($query) {
                $query->where('status', 'finished');
            })
            ->get();

        return view('dashboard.monitored_evaluation.ten_percent.index',
            [
                'candidatures' => $candidatures,
                'title' => 'Autorisation de decaissement'
            ]
        );
    }

    public function store(Request $request){

        $request->validate([
            'adherent_id' => 'required|exists:candidatures,id',
            'amount' => 'required|numeric',
        ]);

        $candidature = Candidature::findOrFail($request->adherent_id);

        if($candidature->creditCommittee){

            $candidature->ten_percent = true;
            $candidature->disbursement = true;
            $candidature->save();

            $committee = CreditCommittee::where('candidature_id', $candidature->id)->first();

            $committee->amount_ten_percent = $request->amount_ten_percent;
            $committee->ten_percent_updated_by = auth()->user()->id;
            $committee->datetime_ten_percent = now();
            $committee->save();

        }

        

        return back()->with('success', '10% versé avec succès.');
    }
}
