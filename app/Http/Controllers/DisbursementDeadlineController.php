<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\DisbursementDeadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisbursementDeadlineController extends Controller
{
    public function store(Request $request)
    {

        authPermission('responsable-suivi-evaluation|chef-celulle-suivi-evaluation|partner-financial');

        $adherent = Candidature::find($request->adherent);

        $validator = Validator::make($request->all(), [
            'adherent' => 'required|exists:candidatures,id',
            'amount_deadline' => 'required|numeric',
            'date_expiry' => 'required|date',
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        if ($adherent->selfEmploymentMonitoredPayment->disbursements->whereIn('status', ['pending', 'in_progress', 'finished'])->count() > 0) {

            $date_expiry = $request->date_expiry;
            $amount = $request->amount_deadline;

            DisbursementDeadline::create([
                'self_employment_monitored_payment_id' => $adherent->selfEmploymentMonitoredPayment->id,
                'amount' => $amount,
                'date_expiry' => $date_expiry,
                'title' => "Echéance " . date('d-m-Y'),
                'created_by' => auth()->id(),
                'reminder_dates' => '[]',
            ]);
        }

        return response()->json([
            'action' => true,
            'message' => 'Fiche de decaissement transmise au BARM.',
        ]);
    }

    public function update(Request $request, string $id)
    {

        authPermission('responsable-suivi-evaluation|chef-celulle-suivi-evaluation|partner-financial');

        $deadline = DisbursementDeadline::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date_refund' => 'required|date',
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        if ($deadline->status == 'paid')
            return response()->json([
                'action' => false,
                'message' => 'Echéance déjà payée.',
            ]);

        $deadline->update([
            'date_refund' => $request->date_refund,
            'updated_by' => auth()->id(),
            'status' => "paid",
        ]);

        return response()->json([
            'action' => true,
            'message' => 'Echéance modifiée avec succès.',
        ]);
    }

    public function update_reminder(Request $request, string $id)
    {

        authPermission('responsable-suivi-evaluation|chef-celulle-suivi-evaluation|partner-financial');

        $deadline = DisbursementDeadline::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date_reminder' => 'required|date',
            'proof_file' => "nullable|file|mimes:pdf,jpeg,png,jpg",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        $file = null;
        if ($request->proof_file) {
            $file = time() . '.' . $request->proof_file->getClientOriginalExtension();
            $request->proof_file->move(saveByEnv() . "data/docs/report_file_disbursement/", $file);
            $file = 'data/docs/report_file_disbursement/' . $file;
        }
        $reminder_dates = json_decode($deadline->reminder_dates);
        $reminder_dates[] = [
            'created_by' => auth()->id(),
            'date' => $request->date_reminder,
            'file' => $file,
        ];

        $deadline->update([
            'reminder_dates' => json_encode($reminder_dates),
        ]);

        return response()->json([
            'action' => true,
            'message' => 'Rappel mis à jour avec succès.',
        ]);
    }
}
