<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\CandidaturePartnerTechnicial;
use App\Models\Cohort;
use App\Models\Partenaire;
use App\Models\Training;
use Illuminate\Http\Request;

class CohortController extends Controller
{
    public function p($partner = 'conseiller-auto-emploi|chef-cellule-formation-et-insertion')
    {
        return auth()->user()->partenaire;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.cohort.index', ['cohorts' => Cohort::orderByDesc('created_at')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->p();

        return view('dashboard.cohort.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->p();

        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'number_adherent' => 'required|numeric',
        ]);

        $attrs['reference'] = 'CO-' . date('Y') . '-' . Cohort::whereYear('created_at', date('Y-m-d'))->count() + 1;

        Cohort::create($attrs);

        return to_route('cohort.index')->with('success', MESSAGES['cohort']['store']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $cohort = Cohort::findOrFail($id);

        $partners = Partenaire::all();
        $partner_technicials = [];
        foreach ($partners as $key => $partner)
            if (in_array('partner-technical', userPermissions($partner->user)))
                (array)$partner_technicials[] = $partner;

        return view('dashboard.cohort.show', compact('cohort', 'partner_technicials'));
    }

    /**
     * Get adherents data for DataTable (server-side processing)
     */
    public function getAdherentsData(Request $request, int $cohortId, string $type)
    {
        $query = Candidature::select('id', 'user_id', 'specialisation_1c', 'locality_1c', 'phone_number', 'no_card', 'orientation', 'cgrae_no', 'domaine_1c', 'domaine_2c')
            ->where('cohort_id', $cohortId)
            ->where('resignation', '0')->where('death', '0')
            ->with(['user:id,firstname,lastname,mecano,matricule', 'partenaires.user:id,username', 'diplomes:diplome', 'jobs:fonction']);

        if ($type === 'session_collective') {
            $query->whereHas('candidatureSessioncollective');
        } else {
            $query->where('session_collective', '0')
                ->whereDoesntHave('candidatureSessioncollective');
        }

        if (can('partner-technical')) {
            $query->whereHas('candidaturePartenaires', function ($q) {
                $q->where('partenaire_id', auth()->user()->partenaire->id);
            });
        } elseif (can('partner-financial')) {
            $query->where('partner_financial_id', auth()->user()->partenaire->id);
        }

        $search = $request->input('search.value');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('firstname', 'like', '%' . $search . '%')
                        ->orWhere('lastname', 'like', '%' . $search . '%')
                        ->orWhere('mecano', 'like', '%' . $search . '%')
                        ->orWhere('matricule', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('candidaturePartenaires', function ($q2) use ($search) {
                        $q2->whereHas('partenaire', function ($q3) use ($search) {
                            $q3->whereHas('user', function ($q4) use ($search) {
                                $q4->where('username', 'like', '%' . $search . '%');
                            });
                        });
                    })
                    ->orWhere(function ($q2) use ($search) {
                        $q2->where('no_card', 'like', '%' . $search . '%')
                            ->orWhere('orientation', 'like', '%' . $search . '%')
                            ->orWhere('cgrae_no', 'like', '%' . $search . '%')
                            ->orWhere('phone_number', 'like', '%' . $search . '%')
                            ->orWhere('domaine_1c', 'like', '%' . $search . '%')
                            ->orWhere('domaine_2c', 'like', '%' . $search . '%')
                            ->orWhere('specialisation_1c', 'like', '%' . $search . '%')
                            ->orWhere('locality_1c', 'like', '%' . $search . '%');
                    });
            });
        }

        $total = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $adherents = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($adherents as $index => $adherent) {
            $data[] = [
                'id' => $adherent->id,
                'index' => $start + $index + 1,
                'fullname' => $adherent->user->fullName(),
                'mecano' => $adherent->user->mecano,
                'phone' => $adherent->phone_number,
                'specialisation' => $adherent->specialisation_1c,
                'locality' => $adherent->locality_1c,
                'partner' => $adherent->partenaires->last() ? $adherent->partenaires->last()->user->username : 'N/A',
                'user_id' => $adherent->user->id
            ];
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $this->p();

        $cohort = Cohort::findOrFail($id);
        return view('dashboard.cohort.edit', compact('cohort'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $this->p();

        $cohort = Cohort::findOrFail($id);
        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'number_adherent' => 'required|numeric',
        ]);

        if ($attrs['number_adherent'] < count($cohort->adhrents))
            return back()->with('warning', "Nombre d’adherent enregistrer pour la cohorte supperieur au nombre de participant saisir.");

        $cohort->update($attrs);

        return to_route('cohort.index')->with('success', MESSAGES['cohort']['update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cohort $cohort)
    {
        //
    }

    public function add_adherent(int $id)
    {
        $this->p();

        $cohort = Cohort::findOrFail($id);

        $partners = Partenaire::all();
        $partner_technicials = [];
        foreach ($partners as $key => $partner)
            if (in_array('partner-technical', userPermissions($partner->user)))
                (array)$partner_technicials[] = $partner;

        return view('dashboard.cohort.add_adherent', compact('cohort', 'partner_technicials'));
    }

    /**
     * Get available adherents data for DataTable (server-side processing)
     */
    public function getAvailableAdherentsData(Request $request, int $cohortId)
    {
        $cohort = Cohort::findOrFail($cohortId);
        $stay = $cohort->number_adherent - $cohort->adhrents->count();

        $query = Candidature::select('id', 'user_id', 'specialisation_1c', 'locality_1c', 'phone_number')
            ->where('cohort_id', null)
            ->where('orientation', 'auto-emploi')
            ->where('resignation', '0')->where('death', '0')
            ->where('step', 'completed')
            ->with(['user:id,firstname,lastname,mecano']);

        // Search functionality
        $search = $request->input('search.value');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('firstname', 'like', '%' . $search . '%')
                        ->orWhere('lastname', 'like', '%' . $search . '%')
                        ->orWhere('mecano', 'like', '%' . $search . '%');
                })
                ->orWhere('phone_number', 'like', '%' . $search . '%')
                ->orWhere('specialisation_1c', 'like', '%' . $search . '%')
                ->orWhere('locality_1c', 'like', '%' . $search . '%');
            });
        }

        $total = $query->count();

        // Limit to available spots
        $recordsFiltered = min($total, $stay);

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $adherents = $query->skip($start)->take(min($length, $stay))->get();

        $data = [];
        foreach ($adherents as $index => $adherent) {
            $data[] = [
                'id' => $adherent->id,
                'index' => $start + $index + 1,
                'fullname' => $adherent->user->fullName(),
                'mecano' => $adherent->user->mecano,
                'phone' => $adherent->phone_number,
                'specialisation' => $adherent->specialisation_1c,
                'locality' => $adherent->locality_1c,
                'user_id' => $adherent->user->id
            ];
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $recordsFiltered,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function update_adherent(Request $request, int $id)
    {
        authPermission('conseiller-auto-emploi|chef-cellule-formation-et-insertion');

        $attrs = $request->validate([
            'cohort_id' => 'required|exists:cohorts,id',
            'partner_id' => 'required|exists:partenaires,id'
        ]);

        $can = Candidature::findOrFail($id);
        $cohort = Cohort::findOrFail($attrs['cohort_id']);

        if ($can->orientation === 'auto-emploi')
            if (!isset($attrs['partner_id']))
                return  back()->with('error', 'Veuillez choisir un partenaire technique');

        $can->cohort_id = $cohort->id;
        $can->save();

        if ($can->orientation === 'auto-emploi') {
            $can->partenaires()->detach();
            $can->partenaires()->attach($request->partner_id);
        }

        return to_route('cohort.show', $cohort->id)->with('success', 'Adhérent ajouté dans la cohorte.');
    }


    //partner technicial
    public function cohortPartner()
    {

        authPermission('partner-technical');

        $partner = auth()->user()->partenaire;
        $cohorts = Cohort::whereHas('adhrents', function ($query) use ($partner) {
            $query->where('partner_technical_id', $partner->id);
        })->get();

        return view('dashboard.cohort.cohort_partner', ['cohorts' => $cohorts]);
    }

    public function cohortPartnerShow(int $id)
    {
        authPermission('partner-technical');

        $partner = auth()->user()->partenaire;
        $cohort = Cohort::where('id', $id)->whereHas('adhrents', function ($query) use ($partner) {
            $query->where('partner_technical_id', $partner->id)
                ->where('resignation', '0');
        })->first();

        $adherents = [];
        foreach ($cohort->adhrents as $value) {
            if ($value->partner_technical_id == auth()->user()->partenaire->id && ($value->partner_financial_id !==  null || $value->other_partner_financial !==  null)) {
                $adherents[] = $value;
            }
        }


        return view('dashboard.cohort.partner.show_cohort', ['cohort' => $cohort, 'adherents' => $adherents]);
    }
}
