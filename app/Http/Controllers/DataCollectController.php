<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Cohort;
use App\Models\DataCollect;
use Illuminate\Http\Request;

class DataCollectController extends Controller
{
    public function partner()
    {
        authPermission('partner-technical');
        return auth()->user()->partenaire;
    }
    public function index(int $id)
    {

        $partner = $this->partner();
        $cohort = Cohort::findOrFail($id);
        $adherents = Candidature::where('cohort_id', $cohort->id)
            ->where('partner_technical_id', $partner->id)
            ->where('resignation', '0')
            ->where('training', true)
            ->with(['participations' => function ($query) {
                $query->whereHas('training');
            }])
            ->get()
            ->filter(function ($candidature) {
                return $candidature->participations->count() == $candidature->participations->where('training.status', 'finished')->count();
            });

        return view('dashboard.cohort.partner.data_collect.index', [
            'cohort' => $cohort,
            'adherents' => $adherents,
        ]);
    }



    public function store(Request $request, int $id)
    {
        $this->partner();
        $adherent = Candidature::findOrFail($id);
        if (!$adherent->cohort || $adherent->dataCollect)
            abort(403);

        $attrs = $request->validate([
            "beging_date" => 'required|date',
            "end_date" => 'nullable|date|after_or_equal:beging_date',
        ], [
            'end_date.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.'
        ]);

        $attrs['candidature_id'] = $adherent->id;

        DataCollect::create($attrs);

        return back()->with('success', 'Plannification de la collecte de données ajoutée.');
    }

    public function list()
    {
        $partner = $this->partner();
        $adherents = Candidature::where('partner_technical_id', $partner->id)->where('data_collect', false)->whereHas('dataCollect')->get();
        return view('dashboard.cohort.partner.data_collect.list_pending', [
            'adherents' => $adherents,
        ]);
    }

    public function validateDC(Request $request)
    {
        $this->partner();

        $attrs = $request->validate([
            "adherent_id" => 'required|exists:candidatures,id',
            "end_date" => 'required|date',
        ]);

        $adherent = Candidature::findOrFail($attrs['adherent_id']);
        if (!$adherent->cohort || $adherent->data_collect)
            abort(403);

        $dataCollect = $adherent->dataCollect;
        if (!$dataCollect)
            abort(404, 'Aucune collecte de données trouvée pour cet adhérent.');

        $beginDate = \Carbon\Carbon::parse($dataCollect->beging_date);
        $endDate = \Carbon\Carbon::parse($attrs['end_date']);

        if ($endDate->lt($beginDate))
            return back()->withErrors([
                'end_date' => 'La date de fin ne peut pas être antérieure à la date de début (' . $beginDate->format('d/m/Y') . ').'
            ])->withInput();

        $adherent->dataCollect()->update([
            'end_date' => $attrs['end_date'],
        ]);

        $adherent->data_collect = true;
        $adherent->save();

        return back()->with('success', 'Statut de la collecte de données changé avec succès.');
    }
}
