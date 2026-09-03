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
        $items = Candidature::whereDoesntHave('profilage')->with(['user', 'cohort', 'partnerTechnical.user'])->get();
        $pdf = PDF::loadView('pdf.exports.never_profiled', compact('title', 'items'));
        return $pdf->download('candidats_jamais_profiles.pdf');
    }

    public function exportCandidatsAbsents()
    {
        $title = 'Liste des Candidats Marqués Comme Absents';
        $items = Candidature::whereHas('profilage', function ($q) {
            $q->where('presence', '0');
        })->with(['user', 'cohort', 'partnerTechnical.user'])->get();
        $pdf = PDF::loadView('pdf.exports.candidats_absents', compact('title', 'items'));
        return $pdf->download('candidats_absents.pdf');
    }

    public function exportCandidatsRefuses()
    {
        $title = 'Liste des Candidatures Reversées au BARM';
        $items = Candidature::where('partner_reverse', '1')->with(['user', 'cohort', 'partnerTechnical.user'])->get();
        $pdf = PDF::loadView('pdf.exports.candidats_refuses', compact('title', 'items'));
        return $pdf->download('candidats_reverses_au_barm.pdf');
    }

    public function exportFormations()
    {
        $title = 'Gestion des Formations Professionnelles';
        $items = Formation::orderByDESC('created_at')->get();
        $pdf = PDF::loadView('pdf.exports.formations', compact('title', 'items'));
        return $pdf->download('liste_des_formations.pdf');
    }

    public function exportFormationDetail($id)
    {
        $formation = Formation::with('candidatures.user')->findOrFail($id);
        $title = 'Détail de la Formation : ' . ($formation->title ?? $formation->name ?? $formation->id);
        $pdf = PDF::loadView('pdf.exports.formation_detail', compact('title', 'formation'));
        return $pdf->download('detail_formation_' . $formation->id . '.pdf');
    }
}
