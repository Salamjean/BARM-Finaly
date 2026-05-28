<?php

namespace App\Http\Controllers;

use App\Models\PA;
use App\Models\Cohort;
use App\Models\Partenaire;
use App\Models\Candidature;
use App\Models\CandidatureControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PAController extends Controller
{

    public function partner($partner = 'partner-technical')
    {
        authPermission($partner);
        return auth()->user()->partenaire;
    }

    public function list_pending()
    {
        $partner = $this->partner('partner-technical');

        $adherents = Candidature::where('pa', false)->where('data_collect', true)->where('partner_technical_id', $partner->id)->whereDoesntHave('pas')->get();

        $partners = Partenaire::all();
        $partner_financials = [];
        foreach ($partners as $key => $partner_fin) {
            if (in_array('partner-financial', userPermissions($partner_fin->user)))
                (array)$partner_financials[] = $partner_fin;
        }

        return view('dashboard.cohort.partner.pa.list_pending', [
            'adherents' => $adherents,
            'partner_financials' => $partner_financials,
        ]);
    }

    public function store(Request $request, int $id)
    {
        $partner = $this->partner();
        $adherent = Candidature::findOrFail($id);

        $attrs = $request->validate([
            'url' => 'required|file|mimes:pdf',
            'observation' => 'nullable|string',
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'credit' => 'required|numeric',
            'location' => 'required|string',
            'partner_financial' => 'required|string',
            'other_partner_financial' => 'required_if:partner_financial,other',
        ]);

        $attrs['candidature_id'] = $adherent->id;
        $attrs['partner_id'] = $partner->id;
        $attrs['status'] = 'in_progress';

        if (isset($attrs['url'])) {
            $image = $adherent->user->username .'_'. $request->title . '.' . $attrs['url']->getClientOriginalExtension();
            $attrs['url']->move(saveByEnv() . "data/docs/pa/", $image);
            $attrs['url'] =  'data/docs/pa/' . $image;
        }


        if ($request->partner_financial === 'other') {

            $attrs['other_partner_financial'] = $request->other_partner_financial;
            $attrs['status'] = 'accepted';

            $adherent->update([
                'focal_point_area' => null,
                'pa_decision' => true,
                'favorable_opinion' => true,
                'disbursement' => true,
                'post_monitored' => true,
                'partner_financial_id' => null,
                'other_partner_financial' => $request->other_partner_financial,
            ]);
        } else {

            Partenaire::findOrFail($request->partner_financial);

            $attrs['partner_financial_id'] = $request->partner_financial;

            $adherent->update([
                'partner_financial_id' => $request->partner_financial,
                'other_partner_financial' => null,
            ]);
        }

        PA::create($attrs);

        //control
        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $adherent->id,
            'type' => 'updated',
            'table' => 'candidatures',
            'reason' => 'commission approbation'
        ]);

        $adherent->pa = true;
        $adherent->save();

        return back()->with('success', 'Plan ajouté avec succès');
    }

    public function cohorts()
    {
        $partner = $this->partner();

        $partner = auth()->user()->partenaire;
        $cohorts = Cohort::whereHas('adhrents', function ($query) use ($partner) {
            $query->where('partner_technical_id', $partner->id)->where('pa', true);
        })->get();

        return view('dashboard.cohort.partner.pa.cohorts', ['cohorts' => $cohorts]);
    }

    public function cohort(int $id)
    {
        $partner = $this->partner();
        $cohort = Cohort::findOrFail($id);
        $adherents = Candidature::where('partner_technical_id', $partner->id)->where('cohort_id', $cohort->id)->where('pa', true)->get();

        foreach ($adherents as $adherent) {
            $adherent->pa_status = in_array('in_progress', $adherent->pas->pluck('status')->toArray())  ? 'en cours' : 'approuvé';
            $pa = PA::where('candidature_id', $adherent->id)->where('status', 'in_progress')->first();
            if (!$pa)
                $pa = PA::where('candidature_id', $adherent->id)->where('status', 'accepted')->first();
            $adherent->pa_file = $pa->url;
        }

        return view('dashboard.cohort.partner.pa.cohort', ['cohort' => $cohort, 'adherents' => $adherents, 'pa' => $pa]);
    }

    public function refused()
    {
        $partner = $this->partner();
        $adherents = Candidature::where('partner_technical_id', $partner->id)
            ->where('data_collect', true)
            ->where('pa', false)
            ->where('pa_decision', false)
            ->whereHas('pas', function ($query) {
                $query->whereIn('status', ['refused', 'deferred', 'rejected']);
            })
            ->get();

        $partners = Partenaire::all();
        $partner_financials = [];
        foreach ($partners as $key => $partner_fin) {
            if (in_array('partner-financial', userPermissions($partner_fin->user)))
                (array)$partner_financials[] = $partner_fin;
        }

        return view('dashboard.cohort.partner.pa.rejected', ['adherents' => $adherents, 'partner_financials' =>
        $partner_financials,]);
    }
}
