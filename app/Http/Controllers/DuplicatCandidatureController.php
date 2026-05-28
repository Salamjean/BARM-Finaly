<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DuplicatCandidatureController extends Controller
{
    public function store(Request $request)
    {

        if(Auth::check())
            authPermission('chef-cellule-formation-et-insertion');
        else
            $request->validate([
                'accepted' => 'required|in:candidature_express_NOvzCHr@no225'
            ]);
        
        $attrs = $request->validate([
            'candidature_id' => 'required|exists:candidatures,id',
        ]);

        $actor = $request->accepted ? 20 : auth()->id();

        $candidature = Candidature::find($attrs['candidature_id']);
        $user = User::findOrFail($candidature->user_id);

        $userExistCount = User::where('mecano', 'like', $user->mecano . '%')->count();

        $duplicateUser = $user->replicate();
        $duplicateUser->mecano = $user->mecano . '-' . ($userExistCount + 1);
        $duplicateUser->matricule = $user->matricule . '-' . ($userExistCount + 1);
        $duplicateUser->email = null;
        $duplicateUser->created_by = $actor;
        $duplicateUser->save();

        $duplicateCandidature = $candidature->replicate();
        $duplicateCandidature->user_id = $duplicateUser->id;
        $duplicateCandidature->step = '2';
        $duplicateCandidature->status = 'pending';
        $duplicateCandidature->cohort_id = null;
        $duplicateCandidature->session_collective = '0';
        $duplicateCandidature->session_id = null;
        $duplicateCandidature->partner_technical_id = null;
        $duplicateCandidature->partner_financial_id = null;
        $duplicateCandidature->other_partner_financial = null;
        $duplicateCandidature->condition_disciplinaire = null;
        $duplicateCandidature->training = false;
        $duplicateCandidature->focal_point_area = null;
        $duplicateCandidature->commission_step = 0;
        $duplicateCandidature->pa = false;
        $duplicateCandidature->pa_decision = false;
        $duplicateCandidature->data_collect = false;
        $duplicateCandidature->death = '0';
        $duplicateCandidature->death_date = null;
        $duplicateCandidature->death_no_act = null;
        $duplicateCandidature->death_city = null;
        $duplicateCandidature->death_justification = null;
        $duplicateCandidature->condition_admin = null;
        $duplicateCandidature->favorable_opinion = false;
        $duplicateCandidature->docs_favorable_opinion = null;
        $duplicateCandidature->imputation = null;
        $duplicateCandidature->pensionnaire_cgrae = null;
        $duplicateCandidature->credit_committee = false;
        $duplicateCandidature->ten_percent = false;
        $duplicateCandidature->disbursement = false;
        $duplicateCandidature->focal_point_post_monitored = null;
        $duplicateCandidature->post_monitored = false;
        $duplicateCandidature->resignation = '0';
        $duplicateCandidature->resignation_date = null;
        $duplicateCandidature->resignation_justification = null;
        $duplicateCandidature->en_poste = '0';
        $duplicateCandidature->poste_id = null;
        $duplicateCandidature->admissionconcours = '0';
        $duplicateCandidature->affectation = null;
        $duplicateCandidature->concour_id = null;
        $duplicateCandidature->created_by = $actor;
        $duplicateCandidature->created_at = now();
        $duplicateCandidature->updated_at = now();
        $duplicateCandidature->save();

        return to_route('adherent.step', [1, $duplicateUser->id])->with('success', 'Candidature dupliquée avec succès.');
    }
}
