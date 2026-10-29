<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Cohort;
use App\Models\Formation;
use App\Models\PA;
use App\Models\Sessioncollective;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct()
    {
        @ini_set('memory_limit', '512M');
        @ini_set('max_execution_time', '300');
    }

    public function adherent($id)
    {
        $title = 'Fiche d\'autorisation';
        $user = User::findOrFail($id);

        $pdf = PDF::loadView('pdf.file_candidature_final', compact('title', 'user'));
        $pdfname = 'fiche_' . str_replace(' ', '_', $user->fullName()) . '.pdf';

        return $pdf->stream($pdfname);
    }

    public function exportDeaths()
    {
        $title = 'Liste des Adhérents Décédés';
        $items = Candidature::where('death', '1')->with(['user', 'cohort', 'partnerTechnical.user'])->get();
        $pdf = PDF::loadView('pdf.exports.deaths', compact('title', 'items'));
        return $pdf->download('liste_des_decedes.pdf');
    }

    public function exportResignations()
    {
        $title = 'Liste des Adhérents en Démission / Abandon';
        $items = Candidature::where('resignation', '1')->with(['user', 'cohort', 'partnerTechnical.user'])->get();
        $pdf = PDF::loadView('pdf.exports.resignations', compact('title', 'items'));
        return $pdf->download('liste_des_abandons.pdf');
    }

    public function exportDeferred()
    {
        $title = 'Plans d\'affaires différés / rejetés / abandon';
        $items = PA::whereIn('status', ['deferred', 'refused', 'resignation', 'rejected'])
            ->with(['candidature.user', 'candidature.cohort', 'candidature.partnerTechnical.user'])
            ->orderByDESC('updated_at')
            ->get();
        $pdf = PDF::loadView('pdf.exports.deferred', compact('title', 'items'));
        return $pdf->download('plans_affaires_differes_refuses_abandons.pdf');
    }

    public function exportCohorts()
    {
        $title = 'Liste des Cohortes';
        $items = Cohort::withCount('adhrents')->orderByDESC('created_at')->get();
        $pdf = PDF::loadView('pdf.exports.cohorts', compact('title', 'items'));
        return $pdf->download('liste_des_cohortes.pdf');
    }

    public function exportCohortDetail($id)
    {
        $cohort = Cohort::with('adhrents.user')->findOrFail($id);
        $title = 'Détail de la Cohorte : ' . ($cohort->title ?? $cohort->reference ?? $cohort->id);
        $pdf = PDF::loadView('pdf.exports.cohort_detail', compact('title', 'cohort'));
        return $pdf->download('detail_cohorte_' . $cohort->id . '.pdf');
    }

    public function exportSessionCollectives()
    {
        $title = 'Liste des Sessions Collectives d\'Informations';
        $items = Sessioncollective::orderByDESC('created_at')->get();
        $pdf = PDF::loadView('pdf.exports.sessioncollectives', compact('title', 'items'));
        return $pdf->download('liste_sessions_collectives.pdf');
    }

    public function exportSessionCollectiveDetail($id)
    {
        $session = Sessioncollective::with('candidatures.user')->findOrFail($id);
        $title = 'Détail de la Session Collective : ' . ($session->title ?? $session->name ?? $session->id);
        $pdf = PDF::loadView('pdf.exports.sessioncollective_detail', compact('title', 'session'));
        return $pdf->download('detail_session_collective_' . $session->id . '.pdf');
    }

    public function exportNeverProfiled()
    {
        $title = 'Liste des Candidats Jamais Profilés';
        $items = Candidature::with(['user', 'cohort', 'partnerTechnical.user'])
            ->where('orientation', 'auto-emploi')
            ->whereNotNull('cohort_id')
            ->whereNotNull('session_id')
            ->whereNotNull('partner_technical_id')
            ->where('resignation', '0')
            ->where('death', '0')
            ->whereDoesntHave('choiceFinal')
            ->where('pa', '0')
            ->orderByDESC('created_at')
            ->get();
        $pdf = PDF::loadView('pdf.exports.never_profiled', compact('title', 'items'));
        return $pdf->download('candidats_jamais_profiles.pdf');
    }

    public function exportCandidatsAbsents()
    {
        $title = 'Liste des Candidats Marqués Comme Absents';
        $items = Candidature::whereStep('completed')
            ->where('absent', '1')
            ->where('resignation', '0')
            ->where('death', '0')
            ->where('orientation', 'auto-emploi')
            ->whereNotNull('session_id')
            ->with(['user', 'cohort', 'partnerTechnical', 'partenaires.user'])
            ->orderBy('absent_date', 'desc')
            ->get();
        $pdf = PDF::loadView('pdf.exports.candidats_absents', compact('title', 'items'));
        return $pdf->download('candidats_absents.pdf');
    }

    public function exportCandidatsRefuses()
    {
        $title = 'Liste des Candidatures Reversées au BARM';

        $allCandidatures = Candidature::with(['user', 'cohort', 'partnerTechnical.user', 'partenaires' => function ($query) {
            $query->orderBy('candidaturepartenaires.id', 'desc');
        }])
            ->whereStep('completed')
            ->where('resignation', '0')
            ->where('death', '0')
            ->where('absent', '0')
            ->where('orientation', 'auto-emploi')
            ->whereNotNull('session_id')
            ->whereNotNull('cohort_id')
            ->orderByDesc('created_at')
            ->get();

        $items = $allCandidatures->filter(function ($candidature) {
            $dernierPartenaire = $candidature->partenaires->first();
            return $dernierPartenaire && $dernierPartenaire->pivot->status === 'refused';
        });

        $pdf = PDF::loadView('pdf.exports.candidats_refuses', compact('title', 'items'));
        return $pdf->download('candidats_reverses_au_barm.pdf');
    }

    public function exportFormations()
    {
        $title = 'Gestion des Formations Professionnelles';
        $items = Formation::orderByDESC('created_at')->get();

        if ($items->isEmpty()) {
            $items = \App\Models\Training::with('partner.user')->orderByDESC('created_at')->get();
        }

        $pdf = PDF::loadView('pdf.exports.formations', compact('title', 'items'));
        return $pdf->download('liste_des_formations.pdf');
    }

    public function exportFormationDetail($id)
    {
        $formation = Formation::with('candidatures.user')->find($id);

        if (!$formation) {
            $training = \App\Models\Training::with(['participations.candidature.user', 'partner.user', 'cohort'])->findOrFail($id);
            $title = 'Détail de la Formation : ' . ($training->title ?? ('Formation #' . $training->id));
            $pdf = PDF::loadView('pdf.exports.training_detail', compact('title', 'training'));
            return $pdf->download('detail_formation_' . $training->id . '.pdf');
        }

        $title = 'Détail de la Formation : ' . ($formation->intitule ?? $formation->title ?? ('Formation #' . $formation->id));
        $pdf = PDF::loadView('pdf.exports.formation_detail', compact('title', 'formation'));
        return $pdf->download('detail_formation_' . $formation->id . '.pdf');
    }

    public function exportRetiredPreregistrations()
    {
        $title = 'Liste des Préinscriptions Retraités';
        $items = \App\Models\RetiredPreregistration::with('retired')->orderByDESC('created_at')->get();
        $pdf = PDF::loadView('pdf.exports.retired_preregistrations', compact('title', 'items'));
        return $pdf->download('liste_preinscriptions_retraites.pdf');
    }

    public function exportAccountOpenings($idCohort)
    {
        $cohort = Cohort::findOrFail($idCohort);
        $title = 'Ouvertures de comptes - Cohorte ' . ($cohort->reference ?? $cohort->title);
        $items = Candidature::where('cohort_id', $cohort->id)
            ->whereStep('completed')
            ->with(['user', 'partnerFinancial.user'])
            ->get();
        $pdf = PDF::loadView('pdf.exports.account_openings', compact('title', 'cohort', 'items'));
        return $pdf->download('ouvertures_comptes_cohorte_' . $cohort->id . '.pdf');
    }

    public function exportAdherents()
    {
        $title = 'Liste Complète des Adhérents';
        $items = Candidature::whereStep('completed')
            ->with(['user', 'cohort'])
            ->orderByDESC('created_at')
            ->get();
        $pdf = PDF::loadView('pdf.exports.adherents', compact('title', 'items'));
        return $pdf->download('liste_des_adherents.pdf');
    }

    public function exportSessionCollectivePresents()
    {
        $title = 'Liste des Candidats Présents aux Sessions Collectives';
        
        if (auth()->check() && auth()->user()->roles->first()?->name == 'POINTS FOCAUX') {
            $items = Candidature::whereHas('createdBy.personnel', function ($query) {
                $query->where('ville_barm', '=', auth()->user()->personnel->ville_barm);
            })->where('resignation', '0')->where('death', '0')
                ->where('orientation', 'auto-emploi')
                ->whereNotNull('session_id')
                ->where('session_collective', '1')
                ->where('status', 'pending')
                ->with(['user', 'cohort', 'sessionCollective'])
                ->get();
        } else {
            $items = Candidature::where('death', '0')
                ->whereNotNull('session_id')
                ->where('orientation', 'auto-emploi')
                ->where('session_collective', '1')
                ->where('status', 'pending')
                ->with(['user', 'cohort', 'sessionCollective'])
                ->get();
        }

        $pdf = PDF::loadView('pdf.exports.session_presents', compact('title', 'items'));
        return $pdf->download('candidats_presents_sessions.pdf');
    }

    public function exportSuiviEpCandidats(Request $request)
    {
        $validated = $request->validate([
            'entreprise' => 'nullable|string|max:255',
            'date_from'  => 'nullable|date',
            'date_to'    => 'nullable|date',
        ]);

        $selectedEntreprise = $validated['entreprise'] ?? null;
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $query = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'entreprise-privee');

        $filters = [];
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
            $filters[] = "Du " . date('d/m/Y', strtotime($dateFrom));
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
            $filters[] = "Au " . date('d/m/Y', strtotime($dateTo));
        }
        if ($selectedEntreprise) {
            $query->whereHas('candidatentreprises', function ($q) use ($selectedEntreprise) {
                $q->where('entreprise', $selectedEntreprise);
            });
            $filters[] = "Entreprise : " . $selectedEntreprise;
        }

        $items = $query->with([
            'user',
            'cohort',
            'candidatentretiens',
            'bilancompetences',
            'cvlms',
            'prepaentretiens',
            'techrechercheemplois',
            'candidatformations.formation',
            'candidatentreprises'
        ])->get()->sortBy(function ($candidat) {
            return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
        }, SORT_NATURAL | SORT_FLAG_CASE)->values();

        $title = 'Suivi des Candidats (Entreprise Privée)';
        $filtersText = implode(' | ', $filters);
        $total = $items->count();

        $pdf = Pdf::loadView('pdf.exports.suivi_ep_candidats', compact('title', 'items', 'filtersText', 'total'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('suivi_candidats_entreprise_privee.pdf');
    }

    public function exportSuiviFpCandidats(Request $request)
    {
        $validated = $request->validate([
            'concours'        => 'nullable|string|max:255',
            'statut_concours' => 'nullable|string|max:100',
            'cohorte'         => 'nullable|string|max:100',
            'date_from'       => 'nullable|date',
            'date_to'         => 'nullable|date',
        ]);

        $selectedConcours = $validated['concours'] ?? null;
        $selectedStatut = $validated['statut_concours'] ?? null;
        $selectedCohorte = $validated['cohorte'] ?? null;
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $query = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'fonction-publique');

        $filters = [];
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
            $filters[] = "Du " . date('d/m/Y', strtotime($dateFrom));
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
            $filters[] = "Au " . date('d/m/Y', strtotime($dateTo));
        }
        if ($selectedCohorte) {
            $query->where('cohort_id', $selectedCohorte);
            $filters[] = "Cohorte spécifiée";
        }
        if ($selectedConcours) {
            $query->whereHas('concourSuivi', function ($q) use ($selectedConcours) {
                $q->where('intitule_concours', $selectedConcours);
            });
            $filters[] = "Concours : " . $selectedConcours;
        }
        if ($selectedStatut) {
            $query->whereHas('concourSuivi', function ($q) use ($selectedStatut) {
                $q->where('resultat_statut', $selectedStatut);
            });
            $filters[] = "Statut : " . $selectedStatut;
        }

        $items = $query->with([
            'user',
            'cohort',
            'candidatentretiens',
            'bilancompetences',
            'concourSuivi',
            'candidatformations.formation',
        ])->get()->sortBy(function ($candidat) {
            return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
        }, SORT_NATURAL | SORT_FLAG_CASE)->values();

        $title = 'Suivi des Candidats (Fonction Publique)';
        $filtersText = implode(' | ', $filters);
        $total = $items->count();

        $pdf = Pdf::loadView('pdf.exports.suivi_fp_candidats', compact('title', 'items', 'filtersText', 'total'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('suivi_candidats_fonction_publique.pdf');
    }

    public function exportSuiviAeCandidats(Request $request)
    {
        $validated = $request->validate([
            'partner_technical_id' => 'nullable|integer',
            'partner_financial_id' => 'nullable|integer',
            'cohort_id'            => 'nullable|integer',
            'date_from'            => 'nullable|date',
            'date_to'              => 'nullable|date',
        ]);

        $selectedPartnerTech = $validated['partner_technical_id'] ?? null;
        $selectedPartnerFin = $validated['partner_financial_id'] ?? null;
        $selectedCohort = $validated['cohort_id'] ?? null;
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $query = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'auto-emploi');

        $filters = [];
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
            $filters[] = "Du " . date('d/m/Y', strtotime($dateFrom));
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
            $filters[] = "Au " . date('d/m/Y', strtotime($dateTo));
        }
        if ($selectedCohort) {
            $query->where('cohort_id', $selectedCohort);
            $cohortObj = \App\Models\Cohort::find($selectedCohort);
            $filters[] = "Cohorte : " . ($cohortObj ? $cohortObj->title : $selectedCohort);
        }
        if ($selectedPartnerTech) {
            $query->where('partner_technical_id', $selectedPartnerTech);
            $pTech = \App\Models\Partenaire::find($selectedPartnerTech);
            $filters[] = "Partenaire technique : " . ($pTech && $pTech->user && !empty($pTech->user->username) ? $pTech->user->username : ($pTech && $pTech->user ? $pTech->user->fullName() : 'ID ' . $selectedPartnerTech));
        }
        if ($selectedPartnerFin) {
            $query->where('partner_financial_id', $selectedPartnerFin);
            $pFin = \App\Models\Partenaire::find($selectedPartnerFin);
            $filters[] = "Partenaire financier : " . ($pFin && $pFin->user && !empty($pFin->user->username) ? $pFin->user->username : ($pFin && $pFin->user ? $pFin->user->fullName() : 'ID ' . $selectedPartnerFin));
        }

        $items = $query->with([
            'user',
            'cohort',
            'partnerTechnical.user',
            'partnerFinancial.user',
            'selfEmploymentMonitoredPayment.disbursements',
            'creditCommittee',
            'commissionCandidats',
            'pas'
        ])->get()->sortBy(function ($candidat) {
            return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
        }, SORT_NATURAL | SORT_FLAG_CASE)->values();

        $title = 'Suivi des Candidats (Auto-Emploi)';
        $filtersText = implode(' | ', $filters);
        $total = $items->count();

        $pdf = Pdf::loadView('pdf.exports.suivi_ae_candidats', compact('title', 'items', 'filtersText', 'total'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('suivi_candidats_auto_emploi.pdf');
    }
}
