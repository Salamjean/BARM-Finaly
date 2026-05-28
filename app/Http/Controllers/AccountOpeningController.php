<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\CandidatureControl;
use App\Models\Cohort;
use App\Models\SelfEmploymentMonitoredPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AccountOpeningController extends Controller
{
    public function cohorts()
    {
        $cohorts = Cohort::orderByDESC('created_at')->get();

        if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi') ) {
            foreach ($cohorts as $cohort) {
                $cohort->adherents_account_opening_pending = Candidature::where('cohort_id', $cohort->id)
                    ->where('favorable_opinion', true)
                    ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                        $query->where('account_opening', false);
                    })
                    ->count();

                $cohort->adherents_account_opening_approved = Candidature::where('cohort_id', $cohort->id)
                    ->where('favorable_opinion', true)
                    ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                        $query->where('account_opening', true);
                    })
                    ->count();
            }
        }

        return view('dashboard.monitored_evaluation.account_opening.cohorts', ['cohorts' => $cohorts]);
    }


    public function cohorts_authorization()
    {
        $cohorts = Cohort::orderByDESC('created_at')->get();

        if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation') || can('partner-financial')) {
            foreach ($cohorts as $cohort) {
                $cohort->adherents_authorization_approved_pending = Candidature::where('cohort_id', $cohort->id)
                    ->where('favorable_opinion', true)
                    ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                        $query->where('account_opening', true)->where('authorization_approved', false);
                    })
                    ->count();

                $cohort->adherents_authorization_approved = Candidature::where('cohort_id', $cohort->id)
                    ->where('favorable_opinion', true)
                    ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                        $query->where('account_opening', true)->where('authorization_approved', true);
                    })
                    ->count();
            }
        }

        return view('dashboard.monitored_evaluation.account_opening.authorization', ['cohorts' => $cohorts]);
    }

    public function imputation(Request $request){
        if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi')) {

            $adherent = Candidature::findOrFail($request->adherent_id);

            $adherent->imputation = $request->imputation;
            $adherent->pensionnaire_cgrae = $request->pensionnaire_cgrae;
            $adherent->save();
            
        }

        return back()->with('success', 'Imputation renseigné avec succès.');
    }

    public function plug_removal(int $id)
    {
        $cohort = Cohort::findOrFail($id);
        $adherents_pending = [];
        $adherents_approved = [];

        if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi')) {

            $adherents_pending = Candidature::where('cohort_id', $cohort->id)
                ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                    $query->where('account_opening', false);
                })
                ->get();

            $adherents_approved = Candidature::where('cohort_id', $cohort->id)
                ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                    $query->where('account_opening', true);
                })
                ->get();
        }

        return view('dashboard.monitored_evaluation.account_opening.plug_removal', [
            'cohort' => $cohort,
            'adherents_pending' => $adherents_pending,
            'adherents_approuved' => $adherents_approved,
        ]);
    }


    public function approved_account_opening(Request $request, int $id)
    {
        $selfEmploymentMonitoredPayment = SelfEmploymentMonitoredPayment::findOrFail($id);

        $attrs = $request->validate([
            'date' => 'required',
            'file' => 'required|file|mimes:pdf'
        ]);

        if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi')) {

            if ($selfEmploymentMonitoredPayment->account_opening)
                return back()->with('warning', 'Action non autorisé');

            $attrss['account_opening_updated_by'] = auth()->id();
            $attrss['account_opening'] = true;
            $attrss['datetime_plug_removal'] = $attrs['date'];

            $file = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move(saveByEnv() . "data/docs/file_account_opening/", $file);
            $attrss['file'] = 'data/docs/file_account_opening/' . $file;

            $selfEmploymentMonitoredPayment->update($attrss);

        }

        return back()->with('success', 'Traitement effectué avec succès');
    }

    public function authorization(int $id)
    {
        $cohort = Cohort::findOrFail($id);
        $adherents_pending = [];
        $adherents_approved = [];

        if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation') || can('partner-financial')) {

            $adherents_pending = Candidature::where('cohort_id', $cohort->id)
                ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                    $query->where('account_opening', true)->where('authorization_approved', false);
                })
                ->get();

            $adherents_approved = Candidature::where('cohort_id', $cohort->id)
                ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                    $query->where('account_opening', true)->where('authorization_approved', true);
                })
                ->get();
        }

        return view('dashboard.monitored_evaluation.account_opening.show_authrorization', [
            'cohort' => $cohort,
            'adherents_pending' => $adherents_pending,
            'adherents_approuved' => $adherents_approved,
        ]);
    }

    public function authorization_approved(Request $request, int $id)
    {
        $selfEmploymentMonitoredPayment = SelfEmploymentMonitoredPayment::findOrFail($id);
        $adherent = Candidature::findOrFail($selfEmploymentMonitoredPayment->candidature_id);

        $attrs = $request->validate([
            'date' => 'required',
        ]);

        if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation') || can('partner-financial')) {

            if ($selfEmploymentMonitoredPayment->authorization_approved)
                return back()->with('warning', 'Action non autorisé');

            $attrss['authorization_approved_updated_by'] = auth()->id();
            $attrss['authorization_approved'] = true;
            $attrss['datetime_authorization_approved'] = $attrs['date'];

            $selfEmploymentMonitoredPayment->update($attrss);

            $adherent->update(['credit_committee' => true]);

            //control
            // CandidatureControl::create([
            //     'user_id' => auth()->id(),
            //     'adherent_id' => $adherent->id,
            //     'type' => 'updated',
            //     'table' => 'candidatures',
            //     'reason' => 'disbursement actived'
            // ]);

            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $adherent->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'credit committeee actived'
            ]);
        }

        return back()->with('success', 'Traitement effectué avec succès');
    }

    public function file($id)
    {

        $title = 'Fiche d"autorisation';
        $adherent = Candidature::findOrFail($id);

        $pdf = PDF::loadView('pdf.file_account_opening', compact('title', 'adherent'));
        $pdfname = 'fiche_autorisation_' . str_replace(' ', '_', $adherent->user->fullName()) . '.pdf';

        return $pdf->stream($pdfname);
    }
}
