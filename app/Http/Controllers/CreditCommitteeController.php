<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\PA;
use App\Models\Cohort;
use App\Models\Candidature;
use App\Models\PvCommittee;
use Illuminate\Http\Request;
use App\Models\CreditCommittee;
use Illuminate\Support\Facades\Log;

class CreditCommitteeController extends Controller
{
    public function index()
    {
        $pv = [];

        if (can('partner-financial'))
            $pv = PvCommittee::where('partner_financial_id', auth()->user()->partenaire->id)->orderByDESC('created_at')->get();

        elseif (can('partner-technical'))
            $pv = PvCommittee::whereHas('creditCommittees', function ($q) {
                $q->whereHas('candidature', function ($q2) {
                    $q2->where('partner_technical_id', auth()->user()->partenaire->id);
                });
            })->orderByDesc('created_at')->get();

        elseif (can('chef-barm|c2d'))
            $pv = PvCommittee::orderByDesc('created_at')->get();

        return view('dashboard.monitored_evaluation.credit_committee.index', ['committees' => $pv]);
    }

    public function create()
    {

        $adherents = [];

        if (can('partner-financial')) {

            $adherents = Candidature::with('user')->where('partner_financial_id', auth()->user()->partenaire->id)
                ->where('credit_committee', true)
                ->doesntHave('creditCommittee')
                ->get();
        }

        return view('dashboard.monitored_evaluation.credit_committee.create', ['adherents' => $adherents]);
    }

    public function store(Request $request)
    {
        authPermission('partner-financial');

        try {
            $request->validate([
                'date' => 'required|date',
                'adherents_id' => 'required',
            ]);

            $adherents = explode(',', $request->adherents_id);

            if (count($adherents) == 0)
                return back()->with('error', 'Veuillez selectionner au moins un adhérent');

            $attrs = [];
            $attrs['reference'] = 'CC-' . date('Ym') . '-' . rand(1000, 9999);
            $attrs['date'] = $request->date;
            $attrs['partner_financial_id'] = auth()->user()->partenaire->id;

            $pv = PvCommittee::create($attrs);

            foreach ($adherents as $id)
                CreditCommittee::create([
                    'pv_committee_id' => $pv->id,
                    'candidature_id' => $id,
                ]);

            return redirect()->route('monitored-evaluation.credit_committee.index')
                ->with('success', 'Adhérent ajouté à la liste des candidats pour le conseil de crédit');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la sauvegarde');
        }
    }


    public function show(int $id)
    {
        $pv = PvCommittee::findOrFail($id);

        return view('dashboard.monitored_evaluation.credit_committee.show', ['pv' => $pv]);
    }

    public function validation(Request $request)
    {

        try {
            $request->validate([
                "committee_id" => 'required|exists:credit_committees,id',
                "amount" => "required|numeric",
                "deferred_months" => "required|numeric",
                "loan_duration" => "required|numeric",
                "agency" => "required|string",
                "pension" => "required|in:oui,non",
                "pension_partner_financial" => "required|in:oui,non",
            ]);

            $committee = CreditCommittee::findOrFail($request->committee_id);
            $pv = PvCommittee::findOrFail($committee->pv_committee_id);
            $candidature = Candidature::findOrFail($committee->candidature->id);
            $pa = PA::findOrFail($candidature->paAccepted->id);

            $committee->update([
                "amount_agreed" => $request->amount,
                "agency" => $request->agency,
                "deferred_months" => $request->deferred_months,
                "loan_duration" => $request->loan_duration,
                "pension" => $request->pension == 'oui' ? true : false,
                "pension_partner_financial" => $request->pension_partner_financial == 'oui' ? true : false,
                "status" => "finished",
            ]);

            $candidature->update([
                'ten_percent' => false,
            ]);

            $committee_all = $pv->creditCommittees->count();
            $committee_validated = CreditCommittee::where([
                ['pv_committee_id', $committee->pv_committee_id],
                ['status', 'finished'],
            ])->count();

            $pa->update([
                'amount_awarded' => $request->amount,
            ]);

            if ($committee_all == $committee_validated) {
                $pv->update([
                    'status' => 'finished',
                ]);
            }

            return back()->with('success', 'Validation du candidat pour le conseil de crédit ' . $committee->pvCommittee->reference . ' effectuée avec succès.');
        
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la validation');
        }
    }

    public function ajourner(Request $request)
    {
        try {
            $request->validate([
                'committee_id' => 'required|exists:credit_committees,id',
                'motif' => 'required|string',
            ]);

            $committee = CreditCommittee::findOrFail($request->committee_id);
            
            // Mise à jour du statut et du motif d'ajournement
            $committee->update([
                'status' => 'ajourne',
                'motif_ajournement' => $request->motif,
            ]);
            
            return back()->with('success', 'Le candidat a été ajourné avec succès.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Erreur de validation: " . json_encode($e->errors()));
            return back()->with('error', 'Erreur de validation: ' . implode(', ', $e->validator->errors()->all()));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'ajournement: " . $e->getMessage());
            return back()->with('error', 'Erreur détaillée: ' . $e->getMessage());
        }
    }

    public function remettreEnAttente(Request $request)
    {
        try {
            $request->validate([
                'committee_id' => 'required|exists:credit_committees,id',
            ]);

            $committee = CreditCommittee::findOrFail($request->committee_id);
            
            // Remettre le statut à 'pending' et effacer le motif d'ajournement
            $committee->update([
                'status' => 'pending',
                'motif_ajournement' => null,
            ]);
            
            return back()->with('success', 'Le candidat a été remis en attente avec succès.');
            
        } catch (\Exception $e) {
            Log::error("Erreur lors de la remise en attente: " . $e->getMessage());
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}
