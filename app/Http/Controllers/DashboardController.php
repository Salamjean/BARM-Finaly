<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Candidatentretien;
use App\Models\Bilancompetence;
use App\Models\Cvlm;
use App\Models\Prepaentretien;
use App\Models\Techrechercheemploi;
use App\Models\Candidatformation;
use App\Models\Candidatentreprise;
use App\Models\Entreprise;
use App\Models\Cohort;
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

            $candidaturesFinanced = Candidature::where('partner_technical_id', $user->partenaire->id)
                ->whereHas('selfEmploymentMonitoredPayment.disbursements', function ($query) {
                    $query->where('status', 'finished');
                })
                ->get();

            $pensionDeRetraite = 0;
            $soldeDeReforme = 0;

            foreach ($candidaturesFinanced as $candidature) {
                $pensionnaire = trim(strtolower($candidature->pensionnaire_cgrae ?? ''));
                if (in_array($pensionnaire, ['oui', '1', 'true'])) {
                    $pensionDeRetraite++;
                } else {
                    $soldeDeReforme++;
                }
            }

            $conditions_financial = [
                'Pension de retraite' => $pensionDeRetraite,
                'Solde de réforme' => $soldeDeReforme,
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
            $data = Cache::remember('dashboard_data_v4_' . auth()->id(), 300, function () {
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

            
            $allCandidatures = Candidature::all();

            $categoriesCount = [
                'Pension de retraite' => 0,
                'Solde de réforme' => 0,
            ];

            foreach ($allCandidatures as $candidature) {
                $financials = [];
                if (!empty($candidature->condition_financiere)) {
                    $decoded = json_decode($candidature->condition_financiere, true);
                    if (is_array($decoded)) {
                        $financials = array_map('trim', $decoded);
                    } elseif (is_string($candidature->condition_financiere)) {
                        $financials = [trim($candidature->condition_financiere)];
                    }
                }

                $pensionnaire = trim(strtolower($candidature->pensionnaire_cgrae ?? ''));

                if (!empty($financials)) {
                    foreach ($financials as $fin) {
                        if (!empty($fin)) {
                            if ($fin === 'Pension retraite') {
                                $fin = 'Pension de retraite';
                            }
                            $categoriesCount[$fin] = ($categoriesCount[$fin] ?? 0) + 1;
                        }
                    }
                } else {
                    if (in_array($pensionnaire, ['oui', '1', 'true'])) {
                        $categoriesCount['Pension de retraite']++;
                    } else {
                        $categoriesCount['Solde de réforme']++;
                    }
                }
            }

            $conditions_financieres = $categoriesCount;

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

        $ep_totalCandidats = 0;
        $ep_totalHommes = 0;
        $ep_totalFemmes = 0;
        $ep_rdv1Count = 0;
        $ep_rdv1Absents = 0;
        $ep_rdv2Count = 0;
        $ep_rdv3Valides = 0;
        $ep_rdv3Eligibles = 0;
        $ep_cvlmCount = 0;
        $ep_prepaCount = 0;
        $ep_treCount = 0;
        $ep_formationCount = 0;
        $ep_beneficiairesPrepa = 0;
        $ep_madTotal = 0;
        $ep_madAcceptes = 0;
        $ep_madPending = 0;
        $ep_madRejected = 0;
        $ep_madCandidatsUniques = 0;
        $ep_enPosteCount = 0;
        $ep_tauxInsertion = 0;
        $ep_tauxRecrutementMAD = 0;
        $ep_tauxProfilage = 0;
        $ep_entreprisesStats = collect();
        $ep_contratsStats = collect();
        $ep_candidats = collect();

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

            // Indicateurs et métriques de suivi des candidats en Entreprise Privée
            $ep_query = Candidature::where('death', '0')
                ->where('resignation', '0')
                ->where('orientation', 'entreprise-privee');

            $ep_candidatsIds = (clone $ep_query)->pluck('id')->toArray();
            $ep_totalCandidats = count($ep_candidatsIds);

            // Répartition Genre
            $ep_totalHommes = (clone $ep_query)->where(function ($q) {
                $q->where('gender', 'Masculin')->orWhere('gender', 'M')->orWhere('gender', 'Homme')->orWhere('gender', 'homme');
            })->count();
            $ep_totalFemmes = (clone $ep_query)->where(function ($q) {
                $q->where('gender', 'Feminin')->orWhere('gender', 'F')->orWhere('gender', 'Femme')->orWhere('gender', 'femme');
            })->count();

            // 1. RDV 1 : Entretien
            $ep_rdv1Count = Candidatentretien::whereIn('candidature_id', $ep_candidatsIds)->where('presence', 1)->distinct('candidature_id')->count('candidature_id');
            $ep_rdv1Absents = Candidatentretien::whereIn('candidature_id', $ep_candidatsIds)->where('presence', 0)->distinct('candidature_id')->count('candidature_id');

            // 2. RDV 2 : Bilan de compétences
            $ep_rdv2Count = Bilancompetence::whereIn('candidature_id', $ep_candidatsIds)->where('presence', 1)->distinct('candidature_id')->count('candidature_id');

            // 3. RDV 3 : Validation / Décision de Profilage
            $ep_rdv3Valides = (clone $ep_query)->where('profilage_decision', 1)->count();
            $ep_rdv3Eligibles = (clone $ep_query)->where(function ($q) {
                    $q->where('profilage_decision', 0)
                        ->orWhere('profilage_decision', false)
                        ->orWhereNull('profilage_decision');
                })
                ->whereHas('bilancompetences', function ($q) {
                    $q->where('presence', 1);
                })->count();

            // 4. Préparation à l'insertion
            $ep_cvlmCount = Cvlm::whereIn('candidature_id', $ep_candidatsIds)->distinct('candidature_id')->count('candidature_id');
            $ep_prepaCount = Prepaentretien::whereIn('candidature_id', $ep_candidatsIds)->distinct('candidature_id')->count('candidature_id');
            $ep_treCount = Techrechercheemploi::whereIn('candidature_id', $ep_candidatsIds)->distinct('candidature_id')->count('candidature_id');
            $ep_formationCount = Candidatformation::whereIn('candidature_id', $ep_candidatsIds)->distinct('candidature_id')->count('candidature_id');

            $ep_beneficiairesPrepa = Candidature::whereIn('id', $ep_candidatsIds)->where(function ($q) {
                $q->whereHas('cvlms')
                    ->orWhereHas('prepaentretiens')
                    ->orWhereHas('techrechercheemplois')
                    ->orWhereHas('candidatformations');
            })->count();

            // 5. Mise à disposition en entreprise
            $ep_madQuery = Candidatentreprise::whereIn('candidature_id', $ep_candidatsIds);
            $ep_madTotal = (clone $ep_madQuery)->count();
            $ep_madAcceptes = (clone $ep_madQuery)->where('statut', 'accepted')->count();
            $ep_madPending = (clone $ep_madQuery)->where('statut', 'pending')->count();
            $ep_madRejected = (clone $ep_madQuery)->where('statut', 'rejected')->count();
            $ep_madCandidatsUniques = (clone $ep_madQuery)->distinct('candidature_id')->count('candidature_id');

            // 6. Candidats effectivement en poste
            $ep_enPosteCount = (clone $ep_query)->where('en_poste', '1')->count();

            // Taux clés
            $ep_tauxInsertion = $ep_totalCandidats > 0 ? round(($ep_enPosteCount / $ep_totalCandidats) * 100, 1) : 0;
            $ep_tauxRecrutementMAD = $ep_madTotal > 0 ? round(($ep_madAcceptes / $ep_madTotal) * 100, 1) : 0;
            $ep_tauxProfilage = $ep_totalCandidats > 0 ? round(($ep_rdv3Valides / $ep_totalCandidats) * 100, 1) : 0;

            // Statistiques par entreprise partenaire
            $ep_entreprisesStats = Candidatentreprise::whereIn('candidature_id', $ep_candidatsIds)
                ->select(
                    'entreprise',
                    DB::raw('count(*) as total_envois'),
                    DB::raw('SUM(CASE WHEN statut = "accepted" THEN 1 ELSE 0 END) as total_acceptes'),
                    DB::raw('SUM(CASE WHEN statut = "pending" THEN 1 ELSE 0 END) as total_pending'),
                    DB::raw('SUM(CASE WHEN statut = "rejected" THEN 1 ELSE 0 END) as total_refuses'),
                    DB::raw('COUNT(DISTINCT candidature_id) as total_candidats')
                )
                ->groupBy('entreprise')
                ->orderByDesc('total_envois')
                ->get();

            // Statistiques par type de contrat
            $ep_contratsStats = Candidatentreprise::whereIn('candidature_id', $ep_candidatsIds)
                ->whereNotNull('type_contrat')
                ->where('type_contrat', '!=', '')
                ->select('type_contrat', DB::raw('count(*) as count'))
                ->groupBy('type_contrat')
                ->get();

            $ep_candidats = collect();
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

        
        $allCandidatures = Candidature::all();

        $categoriesCount = [
            'Pension de retraite' => 0,
            'Solde de réforme' => 0,
        ];

        foreach ($allCandidatures as $candidature) {
            $financials = [];
            if (!empty($candidature->condition_financiere)) {
                $decoded = json_decode($candidature->condition_financiere, true);
                if (is_array($decoded)) {
                    $financials = array_map('trim', $decoded);
                } elseif (is_string($candidature->condition_financiere)) {
                    $financials = [trim($candidature->condition_financiere)];
                }
            }

            $pensionnaire = trim(strtolower($candidature->pensionnaire_cgrae ?? ''));

            if (!empty($financials)) {
                foreach ($financials as $fin) {
                    if (!empty($fin)) {
                        if ($fin === 'Pension retraite') {
                            $fin = 'Pension de retraite';
                        }
                        $categoriesCount[$fin] = ($categoriesCount[$fin] ?? 0) + 1;
                    }
                }
            } else {
                if (in_array($pensionnaire, ['oui', '1', 'true'])) {
                    $categoriesCount['Pension de retraite']++;
                } else {
                    $categoriesCount['Solde de réforme']++;
                }
            }
        }

        $conditions_financieres = $categoriesCount;

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

            // Métriques Suivi Entreprise Privée
            'ep_totalCandidats' => $ep_totalCandidats,
            'ep_totalHommes' => $ep_totalHommes,
            'ep_totalFemmes' => $ep_totalFemmes,
            'ep_rdv1Count' => $ep_rdv1Count,
            'ep_rdv1Absents' => $ep_rdv1Absents,
            'ep_rdv2Count' => $ep_rdv2Count,
            'ep_rdv3Valides' => $ep_rdv3Valides,
            'ep_rdv3Eligibles' => $ep_rdv3Eligibles,
            'ep_cvlmCount' => $ep_cvlmCount,
            'ep_prepaCount' => $ep_prepaCount,
            'ep_treCount' => $ep_treCount,
            'ep_formationCount' => $ep_formationCount,
            'ep_beneficiairesPrepa' => $ep_beneficiairesPrepa,
            'ep_madTotal' => $ep_madTotal,
            'ep_madAcceptes' => $ep_madAcceptes,
            'ep_madPending' => $ep_madPending,
            'ep_madRejected' => $ep_madRejected,
            'ep_madCandidatsUniques' => $ep_madCandidatsUniques,
            'ep_enPosteCount' => $ep_enPosteCount,
            'ep_tauxInsertion' => $ep_tauxInsertion,
            'ep_tauxRecrutementMAD' => $ep_tauxRecrutementMAD,
            'ep_tauxProfilage' => $ep_tauxProfilage,
            'ep_entreprisesStats' => $ep_entreprisesStats,
            'ep_contratsStats' => $ep_contratsStats,
            'ep_candidats' => $ep_candidats,

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
