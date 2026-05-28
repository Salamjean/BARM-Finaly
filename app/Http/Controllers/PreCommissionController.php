<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\PA;
use App\Models\Personnel;
use Illuminate\Http\Request;

class PreCommissionController extends Controller
{
    public function pending()
    {

        $personals = Personnel::all();

        $focal_points = array();

        foreach ($personals as $key => $personal) {
            if ($personal->user->roles && $personal->user->roles->first()->slug === 'points-focaux')
                $focal_points[] = $personal;
        }

        $candidats = Candidature::with(['user', 'partnerTechnical.user'])
            ->orderByDESC('created_at')
            ->where('resignation', '0')->where('death', '0')
            ->where('orientation', 'auto-emploi')
            ->where('pa', '1')
            ->where('pa_decision', '0')
            ->whereNotNull('partner_financial_id')
            ->whereNull('focal_point_area')
            ->get();

        return view('dashboard.pre_commission.pending', [
            'title' => 'Plan d\'affaire en attente',
            'personals' => $focal_points,
            'candidats' => $candidats,
        ]);
    }

    public function in_progress()
    {

        $personals = Personnel::all();

        $focal_points = array();

        foreach ($personals as $key => $personal) {
            if ($personal->user->roles->first()->slug === 'points-focaux')
                $focal_points[] = $personal;
        }

        $candidats = Candidature::with(['user', 'partnerTechnical.user'])
            ->orderByDESC('created_at')
            ->where('resignation', '0')->where('death', '0')
            ->where('orientation', 'auto-emploi')
            ->where('pa', '1')
            ->where('pa_decision', '0')
            ->whereNotNull('partner_financial_id')
            ->whereNotNull('focal_point_area')
            ->get();

        return view('dashboard.pre_commission.in_progress', [
            'title' => 'Plan d\'affaire en attente pour commission',
            'personals' => $focal_points,
            'candidats' => $candidats,
        ]);
    }

    public function validated()
    {

        $candidats = Candidature::with(['user', 'partnerTechnical.user'])
            ->orderByDESC('created_at')
            ->where('resignation', '0')->where('death', '0')
            ->where('orientation', 'auto-emploi')
            ->where('pa', '1')
            ->where('pa_decision', '1')
            ->whereNotNull('partner_financial_id')
            ->whereNotNull('focal_point_area')
            ->get();

        return view('dashboard.pre_commission.validated', [
            'title' => 'Plan d\'affaire validés',
            'candidats' => $candidats,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'focal_point_area' => 'required|string',
            'adherent_id' => 'required|exists:candidatures,id',
        ]);

        $candidature = Candidature::where([
            ['id', $request->adherent_id],
            ['death', '0'],
            ['orientation', 'auto-emploi'],
            ['pa', '1'],
            ['pa_decision', '0'],
        ])
            ->whereNotNull('partner_financial_id')
            ->first();
        $candidature->focal_point_area = $request->focal_point_area;
        $candidature->save();

        return back()->with('success', 'Candidat affecté au point focal avec succès');
    }

    public function refuse(Request $request)
    {
        $request->validate([
            'refuse_reason' => 'required|string|min:10',
            'adherent_id' => 'required|exists:candidatures,id',
        ]);
        
        $candidature = Candidature::where([
            ['id', $request->adherent_id],
            ['death', '0'],
            ['orientation', 'auto-emploi'],
            ['pa', '1'],
            ['pa_decision', '0'],
        ])
            ->whereNotNull('partner_financial_id')
            ->first();

        if (!$candidature) 
            return back()->with('error', 'Candidature non trouvée ou non éligible');

        if(!$candidature->paPending)
            return back()->with('error', 'Candidature non trouvée ou non éligible');

        $pa = PA::find($candidature->paPending->id);

        $pa->status = 'rejected';
        $pa->sentence_reason = $request->refuse_reason;
        $pa->sentence_at = now();
        $pa->sentence_by = auth()->user()->id;
        $pa->save();

        $candidature->pa = '0';
        $candidature->save();

        return back()->with('success', 'Plan d\'affaire refusé avec succès');
    }
}
