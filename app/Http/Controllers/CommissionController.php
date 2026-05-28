<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cohort;

use App\Models\Commission;
use App\Models\Partenaire;
use App\Models\Candidature;
use App\Models\CommissionJury;
use App\Models\PA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cohort $cohort)
    {
        $commissions = Commission::orderByDESC('created_at')->where('cohort_id', $cohort->id)->get();

        $title = 'Liste des commissions - BARM';

        return view('dashboard.commission.index', compact('commissions', 'title', 'cohort'));
    }

    public function candidat_commission(Commission $commission)
    {

        $title = 'Liste des candidats - BARM';

        $commission_partenaires = $commission->partenaires()->get();

        $partners = Partenaire::all();
        $partner_financials = [];
        foreach ($partners as $key => $partner_fin) {
            if (in_array('partner-financial', userPermissions($partner_fin->user)))
                (array)$partner_financials[] = $partner_fin;
        }

        if (Auth::user()->roles->first()->name == 'PARTNER') {
            foreach ($commission_partenaires as $commission_partenaire) {
                if ($commission_partenaire->pivot->type == 'partner_technique') {
                    $candidatures = $commission->candidatures()->where('partner_technical_id', Auth::user()->partenaire->id)->get();
                } elseif ($commission_partenaire->pivot->type == 'partner_financial') {
                    $candidatures = $candidatures = $commission->candidatures()->get();
                }
            }
        } elseif (can('point-focal')) {
            $candidatures = $commission->candidatures()->where('focal_point_area', Auth::user()->personnel->ville_barm)->get();
        } else {
            $candidatures = $commission->candidatures()->get();
        }

        return view('dashboard.commission.candidat_commission', compact('commission', 'title', 'candidatures', 'partner_financials'));
    }

    // liste des candidats ayant leur PA validé à une commission et approuvés par consiller
    public function candidat_commission_favorable(Cohort $cohort)
    {
        $title = 'Liste des candidats - BARM';

        if (Auth::user()->roles->first()->name == 'POINTS FOCAUX') {
            $candidatures = Candidature::whereHas('createdBy.personnel', function ($query) {
                $query->where('ville_barm', '=', Auth::user()->personnel->ville_barm);
            })->whereNotNull('partner_financial_id')->where('cohort_id', $cohort->id)->where('pa_decision', '1')->where('favorable_opinion', '1')->get();
        } elseif (Auth::user()->roles->first()->name == 'PARTNER') {

            $all_candidatures =
                Candidature::where('cohort_id', $cohort->id)->whereNotNull('partner_financial_id')->where('pa_decision', '1')->where('favorable_opinion', '1')->get();
            $candidatures = [];

            foreach ($all_candidatures as $all_candidature) {
                if (Auth::user()->partenaire->id == $all_candidature->partner_technical_id) {
                    $candidatures[] = $all_candidature;
                } elseif (Auth::user()->partenaire->id == $all_candidature->partner_financial_id) {
                    $candidatures[] = $all_candidature;
                }
            }
        } else {
            $candidatures = Candidature::where('cohort_id', $cohort->id)->whereNotNull('partner_financial_id')->where('pa_decision', '1')->get();
        }

        return view('dashboard.commission.candidat_commission_favorable', compact('cohort', 'title', 'candidatures'));
    }

    // avis du conseiller sur un candidat ayant leur PA validé à une commission
    public function candidat_opinion(Request $request, Candidature $candidature)
    {

        try {

            $candidature->update([
                'favorable_opinion' => $request->favorable_opinion,
            ]);

            return redirect()->route('commissions.candidat_commission_favorable', $request->cohort_id)->with(
                "success",
                'Donnée mis à jour'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function cohorte()
    {

        $cohorts = Cohort::orderByDESC('created_at')
            // ->whereHas('commissions')
            ->get();

        $title = 'Liste des cohortes - BARM';

        return view('dashboard.commission.cohorte', compact('cohorts', 'title'));
    }

    public function avis_cohorte()
    {

        $cohorts = Cohort::orderByDESC('created_at')->get();

        $title = 'Liste des cohortes - BARM';

        return view('dashboard.commission.avis_cohorte', compact('cohorts', 'title'));
    }

    public function jury_members()
    {
        authPermission('partner-technical|partner-financial');
        $title = 'Commissions d\'approbation - BARM';


        if (can('partner-technical'))
            $commissions = Commission::whereHas('juries', function ($query) {
                $query->where('partner_id', Auth::user()->partenaire->id);
            })->get();
        elseif (can('partner-financial'))
            $commissions = Commission::all();
        else
            $commissions = [];
        return view('dashboard.commission.jury_members', compact('title', 'commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Cohort $cohort)
    {
        $candidats =
            Candidature::with(['user', 'partnerTechnical.user'])
            ->orderByDESC('created_at')
            ->where('resignation', '0')->where('death', '0')
            ->where('orientation', 'auto-emploi')
            ->where('cohort_id', $cohort->id)
            ->where('pa', '1')
            ->where('pa_decision', '0')
            ->where('commission_step', '0')
            ->whereNotNull('partner_financial_id')
            ->whereNotNull('focal_point_area')
            ->get();

        $technicale_partenaires = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-technical%');
        })->get();

        $financial_partenaires = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-financial%');
        })->get();


        $title = "Créer une commission d'approbation - BARM";

        return view('dashboard.commission.create', compact('candidats', 'technicale_partenaires', 'financial_partenaires', 'title', 'cohort'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $this->validate($request, [
                'number' => 'required',
                'date' => 'required|date',
                'cohort_id' => 'required|exists:cohorts,id',
                'technicale_partenaires' => 'required|array',
                'jury_members' => 'required|array',
                'candidatures' => 'required',
            ]);

            $candidatures_array = explode(",", $request->candidatures);

            $cohort = Cohort::findOrFail($request->cohort_id);
            $partner = Partenaire::findOrFail($request->technicale_partenaires[0]);
            $candidatures_count = Candidature::whereIn('id', $candidatures_array)
                ->where('cohort_id', $cohort->id)
                ->where('partner_technical_id', $partner->id)
                ->count();

            if ($candidatures_count != count($candidatures_array))
                return back()->with('error', 'Veuillez choisir des candidatures de la cohorte');

            $commission = Commission::create([
                'cohort_id' => $request->cohort_id,
                'date' => $request->date,
                'lieu' => $request->lieu,
                'number' => $request->number,
            ]);

            $technicale_partenaires = $request->technicale_partenaires;
            $commission->partenaires()->attach($technicale_partenaires, [
                'type' => 'partner_technique',
            ]);

            $financial_users = User::whereHas('permissions', function (Builder $query) {
                $query->where('slug', 'like', 'partner-financial%');
            })->get();

            $financial_partenaires = [];
            foreach ($financial_users as $financial_user) {
                $financial_partenaires[] = $financial_user->partenaire->id;
            }

            $commission->partenaires()->attach($financial_partenaires, [
                'type' => 'partner_financial',
            ]);

            $commission->candidatures()->attach($candidatures_array);

            foreach ($request->jury_members as $jury_member)
                CommissionJury::create([
                    'commission_id' => $commission->id,
                    'partner_id' => $jury_member,
                ]);

            Candidature::whereIn('id', $candidatures_array)
                ->where('cohort_id', $cohort->id)
                ->where('partner_technical_id', $partner->id)
                ->update([
                    'commission_step' => true,
                ]);

            return redirect()->route('commissions.index', $request->cohort_id)->with(
                "success",
                'Données enregistrées'
            );
        } catch (\Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    // decision commission candidature
    public function decision(Request $request)
    {
        try {
            $this->validate($request, [
                'decision' => 'required',
                'amount' => 'required|numeric',
                'commission_id' => 'required|exists:commissions,id',
                'candidature_id' => 'required|exists:candidatures,id',
                'partner_financial' => 'required|string',
                'other_partner_financial' => 'required_if:partner_financial,other',
            ]);

            $commission = Commission::findOrFail($request->commission_id);
            $pivotData = $commission->candidatures->find($request->candidature_id)->pivot;
            $candidature = Candidature::findOrFail($request->candidature_id);
            $pas = PA::where('candidature_id', $request->candidature_id)->get();
            $lastPA = $pas->last();

            $pivotData->update([
                'decision' => $request->decision,
                'comment' => $request->comment,
            ]);


            if ($request->partner_financial !== 'other') {

                Partenaire::findOrFail($request->partner_financial);

                $pivotData->update([
                    'partner_financial_id' => $request->partner_financial,
                    'other_partner_financial' => null,
                ]);

                $candidature->update([
                    'partner_financial_id' => $request->partner_financial,
                ]);
            } else {

                $pivotData->update([
                    'partner_financial_id' => null,
                    'other_partner_financial' => $request->other_partner_financial,
                ]);

                $candidature->update([
                    'partner_financial_id' => null,
                    'other_partner_financial' => $request->other_partner_financial,
                ]);
            }

            if ($request->decision == 'accepted') {

                $candidature->update([
                    'pa_decision' => true,
                    'favorable_opinion' => $request->partner_financial === 'other' ? true : false,
                    'disbursement' => $request->partner_financial === 'other' ?  true : false,
                    'post_monitored' =>  $request->partner_financial === 'other' ? true : false,
                ]);

                $lastPA->update([
                    'status' => 'accepted',
                    'commission_id' => $request->commission_id,
                    'credit' => $request->amount,
                    'sentence_reason' => $request->comment ?? 'Acceptation du candidat pendant la commission',
                    'sentence_at' => now(),
                    'sentence_by' => auth()->user()->id,
                ]);
            } elseif ($request->decision == 'resignation') {

                $lastPA->update([
                    'status' => 'resignation',
                    'commission_id' => $request->commission_id,
                    'sentence_reason' => $request->comment ?? 'Resignation du candidat pendant la commission',
                    'sentence_at' => now(),
                    'sentence_by' => auth()->user()->id,
                ]);

                $candidature->update([
                    'resignation' => '1',
                ]);
            } elseif ($request->decision == 'deferred' || $request->decision == 'refused') {

                $lastPA->update([
                    'status' => $request->decision,
                    'commission_id' => $request->commission_id,
                    'sentence_reason' => $request->comment ?? 'Rejet pendant la commission',
                    'sentence_at' => now(),
                    'sentence_by' => auth()->user()->id,
                ]);

                $candidature->update([
                    'pa' => '0',
                    'commission_step' => '0',
                    'focal_point_area' => null,
                ]);
            }

            return redirect()->route('commissions.candidat_commission', $request->commission_id)->with(
                "success",
                'Données enregistrées'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    // compte rendu commission
    public function cr(Request $request)
    {

        try {
            $this->validate($request, [
                'rapport' => 'nullable|file',
                'file_presence_partner' => 'nullable|file',
                'file_presence' => 'nullable|file',
            ]);

            $commission = Commission::find($request->commission_id);

            if ($request->hasFile('rapport')) {
                $fileName = uniqid('rapport_') . '.' . $request->file('rapport')->getClientOriginalExtension();
                $request->rapport->move(saveByEnv() .  'data/docs/cr_commission', $fileName);
                $filePath = 'data/docs/cr_commission/' . $fileName;

                $commission->update([
                    'rapport' => $filePath,
                ]);
            }

            if ($request->hasFile('file_presence_partner')) {
                $fileName = uniqid('file_presence_partner_') . '.' . $request->file('file_presence_partner')->getClientOriginalExtension();
                $request->file_presence_partner->move(saveByEnv() .  'data/docs/cr_commission', $fileName);
                $filePath = 'data/docs/cr_commission/' . $fileName;

                $commission->update([
                    'file_presence_partner' => $filePath,
                ]);
            }

            if ($request->hasFile('file_presence')) {
                $fileName = uniqid('file_presence_') . '.' . $request->file('file_presence')->getClientOriginalExtension();
                $request->file_presence->move(saveByEnv() .  'data/docs/cr_commission', $fileName);
                $filePath = 'data/docs/cr_commission/' . $fileName;

                $commission->update([
                    'file_presence' => $filePath,
                ]);
            }

            return redirect()->route('commissions.index', $commission->cohort_id)->with(
                "success",
                'Données enregistrées'
            );
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    // page d"affichage des commissions par partenaire
    public function commissionpartner(Cohort $cohort)
    {
        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        $commissions = Commission::whereHas('partenaires', function ($query) use ($partenaire) {
            $query->where('partenaire_id', $partenaire->id);
        })->orderByDESC('created_at')->where('cohort_id', $cohort->id)->get();

        $title = 'Liste des commissions - BARM';

        return view('dashboard.commission.commissionpartner', compact('cohort', 'commissions', 'title'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
