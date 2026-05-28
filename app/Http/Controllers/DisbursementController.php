<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\Candidature;
use App\Models\Disbursement;
use Illuminate\Http\Request;
use App\Models\HistoryDisbursement;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\SelfEmploymentMonitoredPayment;
use Illuminate\Support\Facades\Auth;

class DisbursementController extends Controller
{
    public function cohorts()
    {
        $cohorts = Cohort::with(['adhrents.selfEmploymentMonitoredPayment'])
            ->whereHas('adhrents.selfEmploymentMonitoredPayment', function ($query) {
                $query->where('account_opening', true);
            })->get();

        foreach ($cohorts as $cohort) {
            $cohort->candidature_count = $cohort->adhrents->count();
            $pending_count = 0;

            foreach ($cohort->adhrents as $adhrent) {
                $query = Candidature::where('id', $adhrent->id)
                    ->where('orientation', 'auto-emploi')
                    ->where('ten_percent', true)
                    ->where('disbursement', true)
                    ->where('post_monitored', false)
                    ->whereHas('selfEmploymentMonitoredPayment', function ($query) {
                        $query->where('account_opening', true);
                    });

                if (can('partner-technical')) {
                    $query->where('partner_technical_id', auth()->user()->partenaire->id);
                } elseif (can('partner-financial')) {
                    $query->where('partner_financial_id', auth()->user()->partenaire->id);
                } elseif (can('point-focal')) {
                    $query->where('focal_point_area',Auth::user()->personnel->ville_barm);
                }

                $pending_count += $query->exists() ? 1 : 0;
            }

            $cohort->candidature_pending_count = $pending_count;
        }

        return view('dashboard.monitored_evaluation.disbursement.cohorts', ['cohorts' => $cohorts]);
    }

    public function cohort(int $id)
    {
        $cohort = Cohort::findOrFail($id);

        $adherents_pending = [];
        $adherents_approved = [];

        if (can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation|partner-technical|partner-financial|point-focal|chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-fonction-public|conseiller-entreprise-prive') || can('chef-barm|c2d|memdef')) {

            $queryBasePending = Candidature::where('cohort_id', $cohort->id)
                ->where('orientation', 'auto-emploi')
                    ->where( 'ten_percent', true)
                ->where('disbursement', true)
                ->where('post_monitored', false);

            $queryBaseApproved = Candidature::where('cohort_id', $cohort->id)
                ->where('post_monitored', true);

            if (can('partner-financial')) {
                $adherents_pending = $queryBasePending
                    ->where('partner_financial_id', auth()->user()->partenaire->id)
                    ->get();

                $adherents_approved = $queryBaseApproved
                    ->where('partner_financial_id', auth()->user()->partenaire->id)
                    ->get();
            } elseif (can('partner-technical')) {
                $adherents_pending = $queryBasePending
                    ->where('partner_technical_id', auth()->user()->partenaire->id)
                    ->get();

                $adherents_approved = $queryBaseApproved
                    ->where('partner_technical_id', auth()->user()->partenaire->id)
                    ->where('other_partner_financial', null)
                    ->get();
            } elseif (can('point-focal')) {
                $adherents_pending = $queryBasePending
                    ->where('focal_point_area',Auth::user()->personnel->ville_barm)
                    ->get();

                $adherents_approved = $queryBaseApproved
                    ->where('focal_point_area',Auth::user()->personnel->ville_barm)
                    ->get();
            } else {
                $adherents_pending = $queryBasePending
                    ->get();

                $adherents_approved = $queryBaseApproved
                    ->where('other_partner_financial', null)
                    ->get();
            }
        }

        return view('dashboard.monitored_evaluation.disbursement.cohort', [
            'cohort' => $cohort,
            'adherents_pending' => $adherents_pending,
            'adherents_approuved' => $adherents_approved,
        ]);
    }

    public function adherent(int $id)
    {
        $adherent = Candidature::findOrFail($id);

        if (!$adherent->selfEmploymentMonitoredPayment)
            abort(403, 'Ce candidat n\'a pas de compte ouvert');

        $pre_disbursement = true;

        if ($adherent->selfEmploymentMonitoredPayment->open_disbursement)
            $pre_disbursement = false;

        if ($pre_disbursement) {
            return view(
                'dashboard.monitored_evaluation.disbursement.adherent',
                compact(
                    'adherent',
                    'pre_disbursement'
                ),
            );
        }

        if (!$pre_disbursement) {

            $last_disbursement = Disbursement::orderByDesc('created_at')->where('self_employment_monitored_payment_id', $adherent->selfEmploymentMonitoredPayment->id)->where('status', 'finished')->first();
            $amount_disbursed =  0;
            foreach ($adherent->selfEmploymentMonitoredPayment->disbursements->toArray() as $amount)
                (int)$amount_disbursed += $amount['status'] === 'finished' ? $amount['amount_disbursement'] : 0;
            
            (int)$left_pay = $adherent->creditCommittee->amount_agreed - $amount_disbursed;

            $add_disbursement_btn = false;

            if (can('partner-technical') && $left_pay > 0) {
                $add_disbursement_btn = true;

                foreach ($adherent->selfEmploymentMonitoredPayment->disbursements as $dis) {
                    if (in_array($dis->status, ['pending', 'in_progress']))
                        $add_disbursement_btn = false;
                }
            }

            return view('dashboard.monitored_evaluation.disbursement.adherent', compact(
                'adherent',
                'add_disbursement_btn',
                'amount_disbursed',
                'left_pay',
                'last_disbursement',
                'pre_disbursement'
            ));
        }
    }

    public function store(Request $request)
    {

        $adherent = Candidature::find($request->id);

        $selfEmploymentMonitoredPayment = SelfEmploymentMonitoredPayment::where(['candidature_id' => $adherent->id])->first();

        if (!$selfEmploymentMonitoredPayment)
            return response()->json([
                'action' => false,
                'message' => 'Ce candidat ne possède pas de compte ouvert.',
            ]);

        if ($request->option == "send_personal_barm") {
            // dd($request->all());
            authPermission('partner-technical');

            $adherent = Candidature::find($request->id);

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:candidatures,id',
                'name' => 'required|array',
                'amount' => "required|array",
                // 'disbursement_file' => "required|file|mimes:pdf",
            ], [
                'required' => 'Veuillez remplir les champs requis',
                // 'disbursement_file.file' => "La fiche de decaissement doit être un fichier",
                // 'disbursement_file.mimes' => "La fiche de decaissement doit être un fichier de type pdf",
            ]);

            if ($validator->fails())
                return response()->json([
                    'action' => false,
                    'message' => $validator->errors()->first(),
                ]);

            $total_amount_awarded = $adherent->creditCommittee->amount_agreed;
            $total_amount = 0;
            foreach ($request->amount as $amount)
                $total_amount += $amount;

            if ((int)$total_amount != (int)$total_amount_awarded)
                return response()->json([
                    'action' => false,
                    'message' => 'Le montant des decaissements ne correspond pas.',
                ]);

            if (!in_array($selfEmploymentMonitoredPayment->status_disbursement, ['init', 'pending', 'cancelled']))
                return response()->json([
                    'action' => false,
                    'message' => 'Le statut du compte ouvert ne permet pas de transmettre une fiche de decaissement.',
                ]);

            // if ($request->disbursement_file) {
            //     $file = time() . '.' . $request->disbursement_file->getClientOriginalExtension();
            //     $request->disbursement_file->move(saveByEnv() . "data/docs/report_file_disbursement/", $file);
            //     $file = 'data/docs/report_file_disbursement/' . $file;
            // }

            $disbursements = Disbursement::where(['self_employment_monitored_payment_id' => $selfEmploymentMonitoredPayment->id])->get();

            if (count($disbursements) > 0)
                foreach ($disbursements as $disbursement) {
                    HistoryDisbursement::create([
                        'title' => $disbursement->title,
                        'self_employment_monitored_payment_id' => $selfEmploymentMonitoredPayment->id,
                        'amount_disbursement' => $disbursement->amount_disbursement,
                        'created_by' => auth()->id(),
                        'report' => $selfEmploymentMonitoredPayment->report_disbursement,
                    ]);
                }

            $disbursements = Disbursement::where(['self_employment_monitored_payment_id' => $selfEmploymentMonitoredPayment->id])->delete();
            foreach ($request->amount as $key => $amount) {
                Disbursement::create([
                    'title' => $request->name[$key],
                    'self_employment_monitored_payment_id' => $selfEmploymentMonitoredPayment->id,
                    'amount_disbursement' => $amount,
                    'created_by' => auth()->id(),
                ]);
            }

            $selfEmploymentMonitoredPayment->update([
                'status_disbursement' => 'pending',
                'disbursement_form' => null,
            ]);

            return response()->json([
                'action' => true,
                'message' => 'Fiche de decaissement transmise au BARM.',
            ]);
        }

        if ($request->option == "send_validated_or_cancelled") {

            authPermission('chef-celulle-suivi-evaluation|responsable-suivi-evaluation');

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:candidatures,id',
                'submit' => "required|in:approved,cancelled",
                // 'signed_disbursement_document' => "required_if:submit,approved|file|mimes:pdf",
            ], [
                'required' => 'Veuillez remplir les champs requis',
                // 'signed_disbursement_document.required_if' => "La fiche de decaissement signé par le chef barm est obligatoire",
                // 'signed_disbursement_document.file' => "La fiche de decaissement signé par le chef barm doit être un fichier",
                // 'disbursement_file.mimes' => "La fiche de decaissement doit être un fichier de type pdf",
            ]);

            if ($validator->fails())
                return response()->json([
                    'action' => false,
                    'message' => $validator->errors()->first(),
                ]);

            $file = null;
            if ($request->signed_disbursement_document) {
                $file = time() . '.' . $request->signed_disbursement_document->getClientOriginalExtension();
                $request->signed_disbursement_document->move(saveByEnv() . "data/docs/report_file_disbursement/", $file);
                $file = 'data/docs/report_file_disbursement/' . $file;
            }

            $selfEmploymentMonitoredPayment->update([
                'open_disbursement' => $request->submit == 'approved' ? true : false,
                'status_disbursement' => $request->submit,
                'report_disbursement' => $request->input('report', null),
                'signed_disbursement_document' => $file,
            ]);

            return response()->json([
                'action' => true,
                'message' => 'Fiche de décaissement ' . ($request->submit == 'approved' ? 'validé' : 'rejétée')  .  ' avec succès.',
            ]);
        }
    }

   

    public function storeAuthorization(Request $request, string $id)
    {

        authPermission('partner-technical');

        $adherent = Candidature::findOrFail($id);

        // $amount_disbursed =  0;
        // foreach ($adherent->selfEmploymentMonitoredPayment->disbursements->toArray() as $amount)
        //     (int)$amount_disbursed += $amount['status'] === 'finished' ? $amount['amount_disbursement'] : 0;

        // (int)$left_pay = $adherent->paAccepted->amount_awarded - $amount_disbursed;

        $validator = Validator::make($request->all(), [
            'document_file' => "required|file|mimes:pdf",
            'report_file' => "nullable|file|mimes:pdf",
        ], [
            'required' => 'Veuillez remplir les champs requis',
            'document_file.file' => "La fiche de decaissement doit être un fichier",
            'document_file.mimes' => "La fiche de decaissement doit être un fichier de type pdf",
            'report_file.file' => "Le rapport de la fiche de decaissement doit être un fichier",
            'report_file.mimes' => "Le rapport de la fiche de decaissement doit être un fichier de type pdf",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        foreach ($adherent->selfEmploymentMonitoredPayment->disbursements as $dis) {
            if (in_array($dis->status, ['pending', 'in_progress']))
                return response()->json([
                    'action' => false,
                    'message' => 'Procédure de decaissement en cours.',
                ]);
        }

        $last_disbursement = Disbursement::orderByDesc('id')->where('self_employment_monitored_payment_id', $adherent->selfEmploymentMonitoredPayment->id)->where('status', 'finished')->first();
        if ($last_disbursement && !$request->report_file)
            return response()->json([
                'action' => false,
                'message' => 'Veuillez insérer le rapport du decaissement ' . $last_disbursement->title . '.',
            ]);


        if ($request->report_file) {
            $file = time() . '.' . $request->report_file->getClientOriginalExtension();
            $request->report_file->move(saveByEnv() . "data/docs/report_file_disbursement/", $file);
            $file = 'data/docs/report_file_disbursement/' . $file;

            $last_disbursement->update([
                'report_date' => date("Y-m-d H:i:s"),
                'report_created_by' => auth()->id(),
                'report_file' => $file,
            ]);
        }

        $file = time() . '.' . $request->document_file->getClientOriginalExtension();
        $request->document_file->move(saveByEnv() . "data/docs/file_disbursement/", $file);
        $file = 'data/docs/file_disbursement/' . $file;

        $attrs = [
            'document_file' => $file,
            'date_hour_submission_document' => date('Y-m-d H:i:s'),
            'created_by' => auth()->id(),
            'status' => 'pending',
        ];

        $disbursement = Disbursement::orderBy('id')
            ->where([['self_employment_monitored_payment_id', $adherent->selfEmploymentMonitoredPayment->id]])
            ->whereIn('status',['cancel', 'init'],)
            ->first();

            if (!$disbursement){
                return response()->json([
                    'action' => false,
                    'message' => 'Plus de decaissement.',
                ]);
            }

        $disbursement->update($attrs);

        return response()->json([
            'action' => true,
            'message' => 'Fiche de decaissement transmise au BARM.',
        ]);
    }

    public function updateAuthorization(Request $request, int $id)
    {
        authPermission('chef-celulle-suivi-evaluation|responsable-suivi-evaluation');

        $disbursement = Disbursement::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'authorizationStatus' => 'required|string|in:authorized,not_authorized',
            'reason' => 'required_if:authorizationStatus,not_authorized',
            'authorization_file' => "required_if:authorizationStatus,authorized|file|mimes:pdf",
        ], [
            'required' => 'Veuillez remplir les champs requis',
            'authorizationStatus.in' => "Erreur de la selection",
            'reason.required_if' => "Veuillez mettre les raison du rejet",
            'authorization_file.file' => "La fiche de decaissement signé doit être un fichier",
            'authorization_file.mimes' => "La fiche de decaissement signé doit être un fichier de type pdf",
            'authorization_file.required_if' => "La fiche de decaissement signé est obligatoire",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        if ($disbursement->authorization)
            return response()->json([
                'action' => false,
                'message' => 'Demande déja autorisée',
            ]);

        $file = null;
        if ($request->authorization_file) {
            $file = time() . '.' . $request->authorization_file->getClientOriginalExtension();
            $request->authorization_file->move(saveByEnv() . "data/docs/report_file_disbursement/", $file);
            $file = 'data/docs/report_file_disbursement/' . $file;
        }
        
        $disbursement->update([

            'authorization' => $request->authorizationStatus === 'authorized' ? true : false,
            'authorization_file' => $file,
            'authorization_date' => date('Y-m-d H:i:s'),
            'authorization_created_by' => auth()->id(),
            'reason' => $request->reason ?? null,

            'status' => $request->authorizationStatus === 'authorized' ? 'in_progress' : 'cancel',

        ]);

        return response()->json([
            'action' => true,
            'message' => 'Demande autorisée',
        ]);
    }

    public function updateDisbursement(Request $request, int $id)
    {
        authPermission('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|partner-financial');

        $disbursement = Disbursement::findOrFail($id);
        $adherent = Candidature::findOrFail($disbursement->selfEmploymentMonitoredPayment->candidature_id);

        $validator = Validator::make($request->all(), [
            'file_disbursement' => 'nullable|file|mimes:pdf',
            'date_disbursement' => 'required|date'
        ], [
            'required' => 'Veuillez remplir les champs requis',
            'file_disbursement.file' => "Le fichier de decaissement doit être un pdf",
            'file_disbursement.mimes' => "Le fichier de decaissement doit être un pdf",
            'date_disbursement.date' => "Date obligatoire",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        if (!$disbursement->authorization && $disbursement->status !== 'in_progress')
            return response()->json([
                'action' => false,
                'message' => 'Demande déja autorisée',
            ]);

        $file = null;
        if($request->file_disbursement){
            $file = time() . '.' . $request->file_disbursement->getClientOriginalExtension();
            $request->file_disbursement->move(saveByEnv() . "data/docs/file_disbursement/", $file);
            $file = 'data/docs/file_disbursement/' . $file;
        }

        $attrs = [
            'date_disbursement' => $request->date_disbursement,
            'file_disbursement' => $file,
            'disbursement_submission_by' => auth()->id(),
            'status' => 'finished',
        ];
        

        $disbursement->update($attrs);

        $amount_disbursed =  0;
        foreach ($adherent->selfEmploymentMonitoredPayment->disbursements->toArray() as $amount) {
            (int)$amount_disbursed += $amount['status'] === 'finished' ? $amount['amount_disbursement'] : 0;
        }
        (int)$left_pay = $adherent->creditCommittee->amount_agreed - $amount_disbursed;

        if ($left_pay === 0)
            $adherent->update(['post_monitored' => true]);

        return response()->json([
            'action' => true,
            'message' => 'Decaissement validé',
        ]);
    }

    public function updateLoan(Request $request, int $id)
    {

        authPermission('partner-financial');

        $selfEmploymentMonitoredPayment = SelfEmploymentMonitoredPayment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date'
        ], [
            'required' => 'Veuillez remplir les champs requis',
            'date.date' => "Date de mise en place obligatoire",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        // if (!$disbursement->authorization && !in_array($disbursement->status, ['in_progress', 'finished']) )
        // return response()->json([
        //     'action' => false,
        //     'message' => 'Demande pas encore autorisé',
        // ]);


        $attrs = [
            'loan_set_up_date' => $request->date,
            'loan_set_up_date_by' => auth()->id(),
        ];


        $selfEmploymentMonitoredPayment->update($attrs);

        return response()->json([
            'action' => true,
            'message' => 'Données mise à jour avec succès',
        ]);
    }

    public function updateLastReport(Request $request, int $id)
    {

        authPermission('conseiller-auto-emploi|chef-cellule-formation-et-insertion|partner-technical|chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation');

        $disbursement = Disbursement::findOrFail($id);
        $adherent = Candidature::findOrFail($disbursement->selfEmploymentMonitoredPayment->candidature_id);

        $validator = Validator::make($request->all(), [
            'report_file' => "required|file|mimes:pdf",
        ], [
            'required' => 'Veuillez remplir les champs requis',
            'report_file.file' => "Le rapport de la fiche de decaissement doit être un fichier",
            'report_file.mimes' => "Le rapport de la fiche de decaissement doit être un fichier de type pdf",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        if ($adherent->post_monitored && !$disbursement->report_file) {
            $file = time() . '.' . $request->report_file->getClientOriginalExtension();
            $request->report_file->move(saveByEnv() . "data/docs/report_file_disbursement/", $file);
            $file = 'data/docs/report_file_disbursement/' . $file;

            $disbursement->update([
                'report_date' => date("Y-m-d H:i:s"),
                'report_created_by' => auth()->id(),
                'report_file' => $file,
            ]);
        }

        return response()->json([
            'action' => true,
            'message' => 'Rapport inséré avec succès.',
        ]);
    }

    public function updateSignedReport(Request $request, int $id)
    {

        authPermission('conseiller-auto-emploi|chef-cellule-formation-et-insertion|chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation');

        $disbursement = Disbursement::findOrFail($id);
        $adherent = Candidature::findOrFail($disbursement->selfEmploymentMonitoredPayment->candidature_id);

        $validator = Validator::make($request->all(), [
            'report_signed_file' => "required|file|mimes:pdf",
        ], [
            'required' => 'Veuillez remplir les champs requis',
            'report_signed_file.file' => "Le rapport de la fiche de decaissement doit être un fichier",
            'report_signed_file.mimes' => "Le rapport de la fiche de decaissement doit être un fichier de type pdf",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        if ($adherent->post_monitored && !$disbursement->report_signed_file) {
            $file = time() . '.' . $request->report_signed_file->getClientOriginalExtension();
            $request->report_signed_file->move(saveByEnv() . "data/docs/report_file_disbursement/", $file);
            $file = 'data/docs/report_file_disbursement/' . $file;

            $disbursement->update([
                'report_signed_date' => date("Y-m-d H:i:s"),
                'report_signed_created_by' => auth()->id(),
                'report_signed_file' => $file,
            ]);
        }

        return response()->json([
            'action' => true,
            'message' => 'Rapport signé inséré avec succès.',
        ]);
    }
}
