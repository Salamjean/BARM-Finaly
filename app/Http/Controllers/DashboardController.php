<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\PA;
use App\Models\Partenaire;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (can('partner-technical')) {

            $conditions = Candidature::where('partner_technical_id', $user->partenaire->id)->whereIn('condition_admin', [
                'Départ volontaire',
                'Démission',
                "Limite d'age",
                'Réforme'
            ])->selectRaw("condition_admin, COUNT(*) as count")
                ->groupBy('condition_admin')
                ->pluck('count', 'condition_admin');

            $conditions_training = Candidature::where([
                ['partner_technical_id', $user->partenaire->id],
                ['training', true],
            ])->whereIn('condition_admin', [
                'Départ volontaire',
                'Démission',
                "Limite d'age",
                'Réforme'
            ])->selectRaw("condition_admin, COUNT(*) as count")
                ->groupBy('condition_admin')
                ->pluck('count', 'condition_admin');

            $conditions_pa = Candidature::where([
                ['partner_technical_id', $user->partenaire->id],
                ['pa', true],
            ])->whereIn('condition_admin', [
                'Départ volontaire',
                'Démission',
                "Limite d'age",
                'Réforme'
            ])->selectRaw("condition_admin, COUNT(*) as count")
                ->groupBy('condition_admin')
                ->pluck('count', 'condition_admin');

            $pension_count = Candidature::where([
                ['partner_technical_id', $user->partenaire->id],
            ])
                ->whereRaw("JSON_CONTAINS(condition_financiere, ?)", ['"Pension retraite"'])
                ->count();

            $solde_count = Candidature::where([
                ['partner_technical_id', $user->partenaire->id],

            ])->whereHas('selfEmploymentMonitoredPayment.disbursements', function ($query) {
                $query->where('status', 'finished');
            })
                ->whereRaw("JSON_CONTAINS(condition_financiere, ?)", ['"Solde de réforme"'])
                ->count();

            $conditions_financial = [
                'Pension retraite' => $pension_count,
                'Solde de réforme' => $solde_count,
            ];

            $pa_decision = PA::where([
                ['partner_id', $user->partenaire->id],
            ])->whereIn('status', [
                'refused',
                'accepted',
                "in_progress",
                'deferred',
                'resignation',
            ])->selectRaw("status, COUNT(*) as count")
                ->groupBy('status')
                ->pluck('count', 'status');

            return view('dashboard', [
                'conditions' => $conditions,
                'conditions_training' => $conditions_training,
                'conditions_pa' => $conditions_pa,
                'conditions_financial' => $conditions_financial,
                'pa_decision' => $pa_decision
            ]);
        } elseif (can('partner-financial')) {

            $candidatures_pa = Candidature::where([
                ['partner_financial_id', $user->partenaire->id],
                ['pa', true],
            ])
                ->selectRaw("partner_technical_id, COUNT(*) as count")
                ->with('partnerTechnical.user')
                ->groupBy('partner_technical_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->partnerTechnical->user->username => $item->count];
                });

            $candidatures_account_opening = Candidature::whereHas('selfEmploymentMonitoredPayment', function ($query) {
                $query->where('account_opening', true);
            })->where([
                ['partner_financial_id', $user->partenaire->id],
            ])
                ->selectRaw("partner_technical_id, COUNT(*) as count")
                ->with('partnerTechnical.user')
                ->groupBy('partner_technical_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->partnerTechnical->user->username => $item->count];
                });

            $candidatures_credit_committee = Candidature::where([
                ['partner_financial_id', $user->partenaire->id],
                ['credit_committee', true],
            ])
                ->selectRaw("partner_technical_id, COUNT(*) as count")
                ->with('partnerTechnical.user')
                ->groupBy('partner_technical_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->partnerTechnical->user->username => $item->count];
                });

            $candidatures_disbursement_in_progress = Candidature::where([
                ['partner_financial_id', $user->partenaire->id],
                ['disbursement', true],
                ['post_monitored', false],
            ])
                ->selectRaw("partner_technical_id, COUNT(*) as count")
                ->with('partnerTechnical.user')
                ->groupBy('partner_technical_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->partnerTechnical->user->username => $item->count];
                });

            $candidatures_post_monitored = Candidature::where([
                ['partner_financial_id', $user->partenaire->id],
                ['disbursement', true],
                ['post_monitored', true],
            ])
                ->selectRaw("partner_technical_id, COUNT(*) as count")
                ->with('partnerTechnical.user')
                ->groupBy('partner_technical_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->partnerTechnical->user->username => $item->count];
                });

            return view('dashboard', [
                'candidatures_pa' => $candidatures_pa,
                'candidatures_account_opening' => $candidatures_account_opening,
                'candidatures_credit_committee' => $candidatures_credit_committee,
                'candidatures_disbursement_in_progress' => $candidatures_disbursement_in_progress,
                'candidatures_post_monitored' => $candidatures_post_monitored
            ]);
        } elseif (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-fonction-public|conseiller-entreprise-prive')) {
            $data = Cache::remember('dashboard_data_' . auth()->id(), 300, function () {
                return $this->getDashboardData();
            });

            return view('dashboard', $data);
        } else {
            $conditions = Candidature::whereIn('condition_admin', [
                'Départ volontaire',
                'Démission',
                "Limite d'age",
                'Réforme'
            ])->selectRaw("condition_admin, COUNT(*) as count")
                ->groupBy('condition_admin')
                ->pluck('count', 'condition_admin');

            $orientations = Candidature::whereIn('orientation', [
                'auto-emploi',
                'fonction-publique',
                'entreprise-privee'
            ])->selectRaw("orientation, COUNT(*) as count")
                ->groupBy('orientation')
                ->pluck('count', 'orientation');

            $grades = Candidature::whereIn('grade', [
                'Soldat 2e classe',
                'Soldat 1ère classe',
                'Caporal',
                'Caporal-Chef',
                'Sergent',
                'Sergent-Chef',
                'Adjudant',
                'Adjudant-Chef',
                'Adjudant-Chef Major',
                'Aspirant',
                'Sous Lieutenant',
                'Lieutenant',
                'Capitaine',
                'Commandant',
                'Lieutenant-Colonel',
                'Colonel',
                'Colonel-Major',
                'Général de Brigade',
                'Général de Division',
                "Général de Corps d'Armée",
                "Général d'Armée"
            ])->selectRaw("grade, COUNT(*) as count")
                ->groupBy('grade')
                ->pluck('count', 'grade');

            $commissionsData = DB::table('commissioncandidats')
                ->whereIn('decision', ['accepted', 'refused', 'deferred', 'resignation'])
                ->selectRaw("decision, COUNT(*) as count")
                ->groupBy('decision')
                ->pluck('count', 'decision');

            
            $decisionTranslations = [
                'accepted' => 'Acceptée',
                'refused' => 'Refusée',
                'deferred' => 'Différée',
                'resignation' => 'Démission'
            ];

            $commissions = [];
            foreach ($commissionsData as $decision => $count) {
                $frenchDecision = $decisionTranslations[$decision] ?? $decision;
                $commissions[$frenchDecision] = $count;
            }

            
            $allPartners = Partenaire::with('user')->where('user_id', '<>', 7)->get();
            $technicalPartners = [];
            $technicalPartnerIds = [];
            $technicalUserIds = [];

            
            foreach ($allPartners as $part) {
                if (can('partner-technical', $part->user)) {
                    $partnerKey = strtoupper($part->user->username);
                    $technicalPartners[$partnerKey] = $part;
                    $technicalPartnerIds[] = $part->id;
                    $technicalUserIds[] = $part->user->id;
                }
            }

            
            $partners_count = [];
            if (!empty($technicalPartnerIds)) {
                $partners_count = Candidature::select('partner_technical_id', DB::raw('COUNT(*) as count'))
                    ->whereIn('partner_technical_id', $technicalPartnerIds)
                    ->groupBy('partner_technical_id')
                    ->pluck('count', 'partner_technical_id');
            }

            
            $disbursementsStats = [];
            if (!empty($technicalUserIds)) {
                $disbursementsStats = DB::table('disbursements')
                    ->join('self_employment_monitored_payments', 'disbursements.self_employment_monitored_payment_id', '=', 'self_employment_monitored_payments.id')
                    ->select(
                        'disbursements.created_by',
                        DB::raw('COUNT(DISTINCT self_employment_monitored_payments.candidature_id) as count'),
                        DB::raw('COALESCE(SUM(disbursements.amount_disbursement), 0) as total_amount')
                    )
                    ->where('disbursements.status', 'finished')
                    ->whereIn('disbursements.created_by', $technicalUserIds)
                    ->groupBy('disbursements.created_by')
                    ->get()
                    ->keyBy('created_by');
            }

            
            $partners_count_display = [];
            $disbursements_count_by_partner = [];
            $disbursements_amount_by_partner = [];

            foreach ($technicalPartners as $partnerKey => $partner) {
                
                $partners_count_display[$partnerKey] = $partners_count[$partner->id] ?? 0;

                
                $disbursementsCount = $disbursementsStats[$partner->user->id] ?? null;
                $disbursements_count_by_partner[$partnerKey] = $disbursementsCount ? (int)$disbursementsCount->count : 0;

                
                $disbursements_amount_by_partner[$partnerKey] = $disbursementsCount ? (float)$disbursementsCount->total_amount : 0;
            }

            
            $conditions_financieres = [];

            $candidatures = Candidature::whereNotNull('condition_financiere')
                ->where('condition_financiere', '!=', '')
                ->get();

            foreach ($candidatures as $candidature) {
                $conditionsArray = json_decode($candidature->condition_financiere, true);

                if (is_array($conditionsArray)) {
                    foreach ($conditionsArray as $condition) {
                        if (!isset($conditions_financieres[$condition])) {
                            $conditions_financieres[$condition] = 0;
                        }
                        $conditions_financieres[$condition]++;
                    }
                }
            }

            return view('dashboard', [
                'adherents_by_condition' => $conditions,
                'adherents_by_orientation' => $orientations,
                'adherents_by_grade' => $grades,
                'adherents_by_commission' => $commissions,
                'adherents_by_partner_technicial' => $partners_count_display,
                'disbursements_count_by_partner' => $disbursements_count_by_partner,
                'disbursements_amount_by_partner' => $disbursements_amount_by_partner,
                'adherents_by_condition_financiere' => $conditions_financieres,
            ]);
        }
    }

    private function getDashboardData()
    {
        $conditions = [];
        $orientations = [];

        $type_armes_auto_emploi = [];
        $grades_auto_emploi = [];
        $commissions_auto_emploi = [];
        $partners_count = [];
        $disbursements_count_by_partner = [];
        $disbursements_amount_by_partner = [];

        $type_armes_entreprise_privee = [];
        $grades_entreprise_privee = [];

        $type_armes_fonction_publique = [];
        $grades_fonction_publique = [];

        $conditions = Candidature::whereIn('condition_admin', [
            'Départ volontaire',
            'Démission',
            "Limite d'age",
            'Réforme'
        ])->selectRaw("condition_admin, COUNT(*) as count")
            ->groupBy('condition_admin')
            ->pluck('count', 'condition_admin');

        $orientations = Candidature::whereIn('orientation', [
            'auto-emploi',
            'fonction-publique',
            'entreprise-privee'
        ])->selectRaw("orientation, COUNT(*) as count")
            ->groupBy('orientation')
            ->pluck('count', 'orientation');

        if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi')) {
            $type_armes_auto_emploi = Candidature::whereIn('armee', [
                'Terre',
                'Air',
                'Force Spéciale',
                'Autre',
                'Marine Nationale',
                'Gendarmerie Nationale',
            ])
                ->where("orientation", "auto-emploi")
                ->selectRaw("armee, COUNT(*) as count")
                ->groupBy('armee')
                ->pluck('count', 'armee');

            $grades_auto_emploi = Candidature::whereIn('grade', [
                'Soldat 2e classe',
                'Soldat 1ère classe',
                'Caporal',
                'Caporal-Chef',
                'Sergent',
                'Sergent-Chef',
                'Adjudant',
                'Adjudant-Chef',
                'Adjudant-Chef Major',
                'Aspirant',
                'Sous Lieutenant',
                'Lieutenant',
                'Capitaine',
                'Commandant',
                'Lieutenant-Colonel',
                'Colonel',
                'Colonel-Major',
                'Général de Brigade',
                'Général de Division',
                "Général de Corps d'Armée",
                "Général d'Armée"
            ])
                ->where("orientation", "auto-emploi")
                ->selectRaw("grade, COUNT(*) as count")
                ->groupBy('grade')
                ->pluck('count', 'grade');

            $commissions_auto_emploi = DB::table('commissioncandidats')
                ->whereIn('decision', ['accepted', 'refused', 'deferred', 'resignation'])
                ->selectRaw("decision, COUNT(*) as count")
                ->groupBy('decision')
                ->pluck('count', 'decision');

            $allPartners = Partenaire::with('user')->where('user_id', '<>', 7)->get();
            $partners = array();
            $technicalPartnerIds = [];
            $technicalUserIds = [];

            foreach ($allPartners as $part) {
                if (can('partner-technical', $part->user)) {
                    $partnerKey = strtoupper($part->user->username);
                    $partners[$partnerKey] = $part;
                    $technicalPartnerIds[] = $part->id;
                    $technicalUserIds[] = $part->user->id;
                }
            }

            
            if (!empty($technicalPartnerIds)) {
                $partnersCountData = Candidature::select('partner_technical_id', DB::raw('COUNT(*) as count'))
                    ->whereIn('partner_technical_id', $technicalPartnerIds)
                    ->groupBy('partner_technical_id')
                    ->pluck('count', 'partner_technical_id');

                foreach ($partners as $key => $partner) {
                    $partners_count[$key] = $partnersCountData[$partner->id] ?? 0;
                }
            }

            
            if (!empty($technicalUserIds)) {
                $disbursementsStats = DB::table('disbursements')
                    ->join('self_employment_monitored_payments', 'disbursements.self_employment_monitored_payment_id', '=', 'self_employment_monitored_payments.id')
                    ->select(
                        'disbursements.created_by',
                        DB::raw('COUNT(DISTINCT self_employment_monitored_payments.candidature_id) as count'),
                        DB::raw('COALESCE(SUM(disbursements.amount_disbursement), 0) as total_amount')
                    )
                    ->where('disbursements.status', 'finished')
                    ->whereIn('disbursements.created_by', $technicalUserIds)
                    ->groupBy('disbursements.created_by')
                    ->get()
                    ->keyBy('created_by');

                foreach ($partners as $partnerKey => $partner) {
                    $disbursementsCount = $disbursementsStats[$partner->user->id] ?? null;
                    $disbursements_count_by_partner[$partnerKey] = $disbursementsCount ? (int)$disbursementsCount->count : 0;
                    $disbursements_amount_by_partner[$partnerKey] = $disbursementsCount ? (float)$disbursementsCount->total_amount : 0;
                }
            }
        }

        if (can('chef-cellule-formation-et-insertion|conseiller-entreprise-prive')) {
            $type_armes_entreprise_privee = Candidature::whereIn('armee', [
                'Terre',
                'Air',
                'Force Spéciale',
                'Autre',
                'Marine Nationale',
                'Gendarmerie Nationale',
            ])
                ->where("orientation", "entreprise-privee")
                ->selectRaw("armee, COUNT(*) as count")
                ->groupBy('armee')
                ->pluck('count', 'armee');

            $grades_entreprise_privee = Candidature::whereIn('grade', [
                'Soldat 2e classe',
                'Soldat 1ère classe',
                'Caporal',
                'Caporal-Chef',
                'Sergent',
                'Sergent-Chef',
                'Adjudant',
                'Adjudant-Chef',
                'Adjudant-Chef Major',
                'Aspirant',
                'Sous Lieutenant',
                'Lieutenant',
                'Capitaine',
                'Commandant',
                'Lieutenant-Colonel',
                'Colonel',
                'Colonel-Major',
                'Général de Brigade',
                'Général de Division',
                "Général de Corps d'Armée",
                "Général d'Armée"
            ])
                ->where("orientation", "entreprise-privee")
                ->selectRaw("grade, COUNT(*) as count")
                ->groupBy('grade')
                ->pluck('count', 'grade');
        }

        if (can('chef-cellule-formation-et-insertion|conseiller-fonction-public')) {
            $type_armes_fonction_publique = Candidature::whereIn('armee', [
                'Terre',
                'Air',
                'Force Spéciale',
                'Autre',
                'Marine Nationale',
                'Gendarmerie Nationale',
            ])
                ->where("orientation", "fonction-publique")
                ->selectRaw("armee, COUNT(*) as count")
                ->groupBy('armee')
                ->pluck('count', 'armee');

            $grades_fonction_publique = Candidature::whereIn('grade', [
                'Soldat 2e classe',
                'Soldat 1ère classe',
                'Caporal',
                'Caporal-Chef',
                'Sergent',
                'Sergent-Chef',
                'Adjudant',
                'Adjudant-Chef',
                'Adjudant-Chef Major',
                'Aspirant',
                'Sous Lieutenant',
                'Lieutenant',
                'Capitaine',
                'Commandant',
                'Lieutenant-Colonel',
                'Colonel',
                'Colonel-Major',
                'Général de Brigade',
                'Général de Division',
                "Général de Corps d'Armée",
                "Général d'Armée"
            ])
                ->where("orientation", "fonction-publique")
                ->selectRaw("grade, COUNT(*) as count")
                ->groupBy('grade')
                ->pluck('count', 'grade');
        }

        
        $conditions_financieres = [];

        $candidatures = Candidature::whereNotNull('condition_financiere')
            ->where('condition_financiere', '!=', '')
            ->get();

        foreach ($candidatures as $candidature) {
            $conditionsArray = json_decode($candidature->condition_financiere, true);

            if (is_array($conditionsArray)) {
                foreach ($conditionsArray as $condition) {
                    if (!isset($conditions_financieres[$condition])) {
                        $conditions_financieres[$condition] = 0;
                    }
                    $conditions_financieres[$condition]++;
                }
            }
        }

        return [
            'adherents_by_condition' => $conditions,
            'adherents_by_orientation' => $orientations,

            'adherents_by_type_armes_auto_emploi' => $type_armes_auto_emploi,
            'adherents_by_grades_auto_emploi' => $grades_auto_emploi,
            'adherents_by_commissions_auto_emploi' => $commissions_auto_emploi,
            'adherents_by_partners_technicial_count' => $partners_count,
            'disbursements_count_by_partner' => $disbursements_count_by_partner,
            'disbursements_amount_by_partner' => $disbursements_amount_by_partner,

            'adherents_by_type_armes_entreprise_privee' => $type_armes_entreprise_privee,
            'adherents_by_grades_entreprise_privee' => $grades_entreprise_privee,

            'adherents_by_type_armes_fonction_publique' => $type_armes_fonction_publique,
            'adherents_by_grades_fonction_publique' => $grades_fonction_publique,

            'adherents_by_condition_financiere' => $conditions_financieres,
        ];
    }

    public function fileCandidature($id)
    {

        $user = User::where('id', $id)->first();

        $pdf = PDF::loadView('pdf.file_candidature', ['user' => $user]);
        $pdf->setPaper('A4', 'portrait')->render();

        $response = new Response();
        $response->setContent($pdf->output())->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', "inline; filename=$id-" . 'fiche_de_candidature_de_' . str_replace(' ', '_', $user->fullName()) . '.pdf');

        return $response;
    }
}
