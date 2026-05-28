<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PA;
use App\Models\SelfEmploymentMonitoredPayment;

class FavorableOpinionController extends Controller
{
    public function cohorts()
    {
        $cohorts = Cohort::orderByDESC('created_at')->get();

        foreach ($cohorts as $cohort) {
            $cohort->adherents_favorable_opinion_pending = Candidature::where('cohort_id', $cohort->id)
                ->where('pa_decision', true)
                ->where('favorable_opinion', false)
                ->count();
        }

        return view('dashboard.monitored_evaluation.favorable_opinion.cohorts', ['cohorts' => $cohorts]);
    }

    public function cohort(int $id)
    {
        $cohort = Cohort::findOrFail($id);

        $adherents_pending = [];
        $adherents_approved = [];

        if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation')) {

            $adherents_pending = Candidature::where('cohort_id', $cohort->id)
                ->where('pa_decision', true)
                ->where('favorable_opinion', false)
                ->get();

            $adherents_approved = Candidature::where('cohort_id', $cohort->id)
                ->where('pa_decision', true)
                ->where('favorable_opinion', true)
                ->get();
        }

        return view('dashboard.monitored_evaluation.favorable_opinion.cohort', [
            'cohort' => $cohort,
            'adherents_pending' => $adherents_pending,
            'adherents_approuved' => $adherents_approved,
        ]);
    }

    public function approved(Request $request, int $id)
    {

        $request->validate([
            'file' => 'nullable|mimes:pdf',
            'amount' => 'required|numeric',
        ]);


        $file_path = null;
        if($request->file){
            $file = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move(saveByEnv() . "data/docs/file_authorization/", $file);
            $file_path = "data/docs/file_authorization/" . $file;
        }

        $adherent = Candidature::findOrFail($id);

        if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation')) {

            $attrs = [
                'favorable_opinion' => true,
                'docs_favorable_opinion' => $file_path,
                'disbursement' => $adherent->partner_financial_id ? false : true,
                'post_monitored' => $adherent->partner_financial_id ? false : true,
            ];

            if ($adherent->pa_decision && !$adherent->favorable_opinion && $adherent->partner_financial_id)
                SelfEmploymentMonitoredPayment::create(['candidature_id' => $adherent->id, 'created_by' => auth()->id()]);

            if ($adherent->pa_decision && !$adherent->favorable_opinion){
                $adherent->update($attrs);

                $pa = PA::find($adherent->paAccepted->id);
                $pa->update(['credit' => $request->amount]);
            }

            
        }

        return back()->with('success', 'Traitement effectué avec succès');
    }
}
