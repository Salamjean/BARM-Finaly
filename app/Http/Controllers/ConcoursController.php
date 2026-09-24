<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\ConcourSuivi;
use App\Models\Intituleconcour;
use App\Models\Typeconcour;
use App\Models\Choixconcour;
use App\Models\Inscriptionconcour;
use App\Models\Candidatsadmi;
use App\Models\Cohort;
use App\Models\CandidatureControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ConcoursController extends Controller
{
    /**
     * Sous-onglet 1 : Choix du concours - Liste
     */
    public function choix(Request $request)
    {
        $title = 'Choix du Concours';
        $activeTab = 'choix';

        $query = Candidature::with(['user', 'cohort', 'concourSuivi'])
            ->where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'fonction-publique');

        if ($request->filled('cohort_id')) {
            $query->where('cohort_id', $request->cohort_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $candidats = $query->orderBy('created_at', 'desc')->get();
        $cohorts = Cohort::orderBy('title')->get();

        return view('dashboard.concours.choix', compact('title', 'activeTab', 'candidats', 'cohorts'));
    }

    /**
     * Sous-onglet 1 : Choix du concours - Formulaire dédié
     */
    public function editChoix(Candidature $candidat)
    {
        $title = 'Choix du Concours - ' . ($candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id);
        $suivi = ConcourSuivi::firstOrNew(['candidature_id' => $candidat->id]);
        $intitules = Intituleconcour::orderBy('libelle')->get();
        $types = Typeconcour::orderBy('libelle')->get();

        return view('dashboard.concours.edit_choix', compact('title', 'candidat', 'suivi', 'intitules', 'types'));
    }

    /**
     * Enregistrer / Mettre à jour le Choix du concours
     */
    public function storeChoix(Request $request)
    {
        $validated = $request->validate([
            'candidature_id' => 'required|exists:candidatures,id',
            'date_choix' => 'required|date',
            'intitule_concours' => 'required|string',
            'other_intitule' => 'nullable|string',
            'type_concours' => 'nullable|string',
            'other_type' => 'nullable|string',
        ]);

        $intitule = $request->intitule_concours;
        if ($intitule === '__other__' && $request->filled('other_intitule')) {
            $intitule = trim($request->other_intitule);
            Intituleconcour::firstOrCreate(['libelle' => $intitule]);
        }

        $type = $request->type_concours;
        if ($type === '__other__' && $request->filled('other_type')) {
            $type = trim($request->other_type);
            Typeconcour::firstOrCreate(['libelle' => $type]);
        }

        $suivi = ConcourSuivi::firstOrNew(['candidature_id' => $request->candidature_id]);
        $suivi->date_choix = $request->date_choix;
        $suivi->intitule_concours = $intitule;
        $suivi->type_concours = $type ?: 'Concours Direct';
        $suivi->autor_id = Auth::id();
        $suivi->save();

        // Synchronisation rétrocompatible avec Choixconcour
        Choixconcour::updateOrCreate(
            ['candidature_id' => $request->candidature_id],
            [
                'intitule_concours' => $intitule,
                'type_concours' => $type ?: 'Concours Direct',
                'autor_id' => Auth::id(),
            ]
        );

        return redirect()->route('concours.choix')->with('success', 'Choix de concours enregistré avec succès pour le candidat.');
    }

    /**
     * Sous-onglet 2 : Prépa Concours - Liste
     */
    public function prepa(Request $request)
    {
        $title = 'Préparation au Concours';
        $activeTab = 'prepa';

        $query = ConcourSuivi::with(['candidature.user', 'candidature.cohort'])
            ->whereNotNull('intitule_concours')
            ->whereHas('candidature', function ($q) {
                $q->where('death', '0')->where('resignation', '0');
            });

        if ($request->filled('cohort_id')) {
            $query->whereHas('candidature', function ($q) use ($request) {
                $q->where('cohort_id', $request->cohort_id);
            });
        }

        if ($request->filled('statut')) {
            if ($request->statut === 'en_attente') {
                $query->whereNull('prepa_statut');
            } else {
                $query->where('prepa_statut', $request->statut);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('candidature.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $suivis = $query->orderBy('updated_at', 'desc')->get();
        $cohorts = Cohort::orderBy('title')->get();

        return view('dashboard.concours.prepa', compact('title', 'activeTab', 'suivis', 'cohorts'));
    }

    /**
     * Sous-onglet 2 : Prépa Concours - Formulaire dédié
     */
    public function editPrepa(ConcourSuivi $suivi)
    {
        $candidat = $suivi->candidature;
        $title = 'Prépa Concours - ' . ($candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id);

        return view('dashboard.concours.edit_prepa', compact('title', 'suivi', 'candidat'));
    }

    /**
     * Enregistrer / Mettre à jour Prépa Concours
     */
    public function storePrepa(Request $request)
    {
        $validated = $request->validate([
            'suivi_id' => 'required|exists:concour_suivis,id',
            'prepa_date_debut' => 'nullable|date',
            'prepa_date_fin' => 'nullable|date|after_or_equal:prepa_date_debut',
            'prepa_statut' => 'required|in:present,absent,abandon',
            'prepa_obs' => 'nullable|string',
        ]);

        $suivi = ConcourSuivi::findOrFail($request->suivi_id);
        $suivi->prepa_date_debut = $request->prepa_date_debut;
        $suivi->prepa_date_fin = $request->prepa_date_fin;
        $suivi->prepa_statut = $request->prepa_statut;
        $suivi->prepa_obs = $request->prepa_obs;
        $suivi->autor_id = Auth::id();
        $suivi->save();

        return redirect()->route('concours.prepa')->with('success', 'Informations de Prépa Concours enregistrées avec succès.');
    }

    /**
     * Sous-onglet 3 : Prépa de dossier (2 rencontres) - Liste
     */
    public function dossier(Request $request)
    {
        $title = 'Préparation de Dossier (2 rencontres)';
        $activeTab = 'dossier';

        $query = ConcourSuivi::with(['candidature.user', 'candidature.cohort'])
            ->whereNotNull('intitule_concours')
            ->whereHas('candidature', function ($q) {
                $q->where('death', '0')->where('resignation', '0');
            });

        if ($request->filled('cohort_id')) {
            $query->whereHas('candidature', function ($q) use ($request) {
                $q->where('cohort_id', $request->cohort_id);
            });
        }

        if ($request->filled('statut_dossier')) {
            if ($request->statut_dossier === 'complet') {
                $query->whereNotNull('dossier_r1_date')->whereNotNull('dossier_r2_date');
            } elseif ($request->statut_dossier === 'partiel') {
                $query->whereNotNull('dossier_r1_date')->whereNull('dossier_r2_date');
            } elseif ($request->statut_dossier === 'non_commence') {
                $query->whereNull('dossier_r1_date');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('candidature.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $suivis = $query->orderBy('updated_at', 'desc')->get();
        $cohorts = Cohort::orderBy('title')->get();

        return view('dashboard.concours.dossier', compact('title', 'activeTab', 'suivis', 'cohorts'));
    }

    /**
     * Sous-onglet 3 : Prépa de dossier - Formulaire dédié
     */
    public function editDossier(ConcourSuivi $suivi)
    {
        $candidat = $suivi->candidature;
        $title = 'Prépa de Dossier - ' . ($candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id);

        return view('dashboard.concours.edit_dossier', compact('title', 'suivi', 'candidat'));
    }

    /**
     * Enregistrer / Mettre à jour Prépa de dossier
     */
    public function storeDossier(Request $request)
    {
        $validated = $request->validate([
            'suivi_id' => 'required|exists:concour_suivis,id',
            'dossier_r1_date' => 'nullable|date',
            'dossier_r1_statut' => 'nullable|string',
            'dossier_r1_obs' => 'nullable|string',
            'dossier_r1_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'dossier_r2_date' => 'nullable|date',
            'dossier_r2_statut' => 'nullable|string',
            'dossier_r2_obs' => 'nullable|string',
            'dossier_r2_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $suivi = ConcourSuivi::findOrFail($request->suivi_id);

        $destDir = function_exists('saveByEnv') ? saveByEnv() . 'data/docs/dossiers_concours' : public_path('data/docs/dossiers_concours');
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0777, true, true);
        }

        if ($request->hasFile('dossier_r1_file')) {
            $fileName1 = uniqid('dossier_r1_') . '.' . $request->file('dossier_r1_file')->getClientOriginalExtension();
            $request->file('dossier_r1_file')->move($destDir, $fileName1);
            $suivi->dossier_r1_file = 'data/docs/dossiers_concours/' . $fileName1;
        }

        if ($request->hasFile('dossier_r2_file')) {
            $fileName2 = uniqid('dossier_r2_') . '.' . $request->file('dossier_r2_file')->getClientOriginalExtension();
            $request->file('dossier_r2_file')->move($destDir, $fileName2);
            $suivi->dossier_r2_file = 'data/docs/dossiers_concours/' . $fileName2;
        }

        $suivi->dossier_r1_date = $request->dossier_r1_date;
        $suivi->dossier_r1_statut = $request->dossier_r1_statut;
        $suivi->dossier_r1_obs = $request->dossier_r1_obs;

        $suivi->dossier_r2_date = $request->dossier_r2_date;
        $suivi->dossier_r2_statut = $request->dossier_r2_statut;
        $suivi->dossier_r2_obs = $request->dossier_r2_obs;
        $suivi->autor_id = Auth::id();
        $suivi->save();

        return redirect()->route('concours.dossier')->with('success', 'Les 2 rencontres et les fichiers de préparation de dossier ont été enregistrés avec succès.');
    }

    /**
     * Sous-onglet 4 : Choix final & Dépôt - Liste
     */
    public function final(Request $request)
    {
        $title = 'Choix Final & Dépôt';
        $activeTab = 'final';

        $query = ConcourSuivi::with(['candidature.user', 'candidature.cohort'])
            ->whereNotNull('intitule_concours')
            ->whereNotNull('dossier_r1_date')
            ->whereNotNull('dossier_r2_date')
            ->whereHas('candidature', function ($q) {
                $q->where('death', '0')->where('resignation', '0');
            });

        if ($request->filled('cohort_id')) {
            $query->whereHas('candidature', function ($q) use ($request) {
                $q->where('cohort_id', $request->cohort_id);
            });
        }

        if ($request->filled('statut_depot')) {
            if ($request->statut_depot === 'en_attente') {
                $query->whereNull('choix_final_statut');
            } else {
                $query->where('choix_final_statut', $request->statut_depot);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('candidature.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $suivis = $query->orderBy('updated_at', 'desc')->get();
        $cohorts = Cohort::orderBy('title')->get();

        return view('dashboard.concours.final', compact('title', 'activeTab', 'suivis', 'cohorts'));
    }

    /**
     * Sous-onglet 4 : Choix final - Formulaire dédié
     */
    public function editFinal(ConcourSuivi $suivi)
    {
        $candidat = $suivi->candidature;
        $title = 'Choix Final & Dépôt - ' . ($candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id);

        return view('dashboard.concours.edit_final', compact('title', 'suivi', 'candidat'));
    }

    /**
     * Enregistrer / Mettre à jour Choix final & Dépôt
     */
    public function storeFinal(Request $request)
    {
        $validated = $request->validate([
            'suivi_id' => 'required|exists:concour_suivis,id',
            'choix_final_statut' => 'required|in:depose,non_depose',
            'choix_final_date' => 'required|date',
            'choix_final_motif' => 'nullable|string',
            'choix_final_recu' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $suivi = ConcourSuivi::findOrFail($request->suivi_id);

        if ($request->hasFile('choix_final_recu')) {
            $destDir = function_exists('saveByEnv') ? saveByEnv() . 'data/docs/recu_concours' : public_path('data/docs/recu_concours');
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0777, true, true);
            }
            $fileName = uniqid('recu_concour_') . '.' . $request->file('choix_final_recu')->getClientOriginalExtension();
            $request->file('choix_final_recu')->move($destDir, $fileName);
            $suivi->choix_final_recu = 'data/docs/recu_concours/' . $fileName;
        }

        $suivi->choix_final_statut = $request->choix_final_statut;
        $suivi->choix_final_date = $request->choix_final_date;
        $suivi->choix_final_motif = $request->choix_final_motif;
        $suivi->autor_id = Auth::id();
        $suivi->save();

        // Sync with Inscriptionconcour for legacy views/reports
        if ($suivi->choix_final_statut === 'depose') {
            Inscriptionconcour::updateOrCreate(
                ['candidature_id' => $suivi->candidature_id],
                [
                    'date' => $suivi->choix_final_date,
                    'intitule_concours' => $suivi->intitule_concours,
                    'type_concours' => $suivi->type_concours,
                    'recu' => $suivi->choix_final_recu,
                    'status' => '1',
                    'autor_id' => Auth::id(),
                ]
            );
        }

        return redirect()->route('concours.final')->with('success', 'Statut du choix final et dépôt enregistré avec succès.');
    }

    /**
     * Liste des inscrits aux concours (Dossier déposé) avec statistiques et décisions (Admis / Ajournés)
     */
    public function inscrits(Request $request)
    {
        $title = 'Liste des Inscrits aux Concours';
        $activeTab = 'inscrits';

        $baseQuery = ConcourSuivi::with(['candidature.user', 'candidature.cohort'])
            ->where('choix_final_statut', 'depose')
            ->whereHas('candidature', function ($q) {
                $q->where('death', '0')->where('resignation', '0');
            });

        // Cohorte filter for base stats if specified
        $statQuery = clone $baseQuery;
        if ($request->filled('cohort_id')) {
            $statQuery->whereHas('candidature', function ($q) use ($request) {
                $q->where('cohort_id', $request->cohort_id);
            });
        }

        $totalInscrits = (clone $statQuery)->count();
        $totalAdmis = (clone $statQuery)->where('resultat_statut', 'admis')->count();
        $totalAjournes = (clone $statQuery)->where('resultat_statut', 'ajourne')->count();
        $totalEnAttente = (clone $statQuery)->where(function ($q) {
            $q->whereNull('resultat_statut')->orWhere('resultat_statut', 'en_attente');
        })->count();

        // Query for table listing
        $query = clone $statQuery;

        if ($request->filled('statut')) {
            $statut = $request->statut;
            if ($statut === 'admis') {
                $query->where('resultat_statut', 'admis');
            } elseif ($statut === 'ajourne') {
                $query->where('resultat_statut', 'ajourne');
            } elseif ($statut === 'en_attente') {
                $query->where(function ($q) {
                    $q->whereNull('resultat_statut')->orWhere('resultat_statut', 'en_attente');
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('candidature.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $suivis = $query->orderBy('updated_at', 'desc')->get();
        $cohorts = Cohort::orderBy('title')->get();
        $currentStatut = $request->statut ?? '';

        return view('dashboard.concours.inscrits', compact(
            'title',
            'activeTab',
            'suivis',
            'cohorts',
            'totalInscrits',
            'totalAdmis',
            'totalAjournes',
            'totalEnAttente',
            'currentStatut'
        ));
    }

    /**
     * Enregistrer la décision de résultat (Admis / Ajourné) pour un inscrit
     */
    public function storeDecisionResultat(Request $request)
    {
        $validated = $request->validate([
            'suivi_id' => 'required|exists:concour_suivis,id',
            'resultat_statut' => 'required|in:admis,ajourne,en_attente',
            'resultat_date' => 'nullable|date',
            'resultat_affectation' => 'nullable|string',
            'resultat_attestation' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'resultat_obs' => 'nullable|string',
        ]);

        $suivi = ConcourSuivi::with('candidature')->findOrFail($request->suivi_id);
        $candidature = $suivi->candidature;

        if ($request->hasFile('resultat_attestation')) {
            $destDir = function_exists('saveByEnv') ? saveByEnv() . 'data/docs/attestation_concours' : public_path('data/docs/attestation_concours');
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0777, true, true);
            }
            $fileName = uniqid('attestation_concour_') . '.' . $request->file('resultat_attestation')->getClientOriginalExtension();
            $request->file('resultat_attestation')->move($destDir, $fileName);
            $suivi->resultat_attestation = 'data/docs/attestation_concours/' . $fileName;
        }

        $suivi->resultat_statut = $request->resultat_statut;
        $suivi->resultat_date = $request->resultat_date ?? now()->toDateString();
        $suivi->resultat_affectation = $request->resultat_affectation;
        $suivi->resultat_obs = $request->resultat_obs;
        $suivi->autor_id = Auth::id();
        $suivi->save();

        if ($request->resultat_statut === 'admis') {
            // Activer le suivi post-insertion pour le candidat admis
            if ($candidature) {
                $candidature->admissionconcours = '1';
                $candidature->post_monitored = true;
                if ($request->filled('resultat_affectation')) {
                    $candidature->affectation = $request->resultat_affectation;
                }
                $candidature->save();

                // Synchroniser avec Candidatsadmi
                $decision = Candidatsadmi::updateOrCreate(
                    ['candidature_id' => $candidature->id],
                    [
                        'intitule_concours' => $suivi->intitule_concours,
                        'type_concours' => $suivi->type_concours,
                        'affectation' => $request->resultat_affectation,
                        'attestation' => $suivi->resultat_attestation,
                        'autor_id' => Auth::id(),
                    ]
                );

                $candidature->update(['concour_id' => $decision->id]);

                // Synchroniser Inscriptionconcour
                Inscriptionconcour::updateOrCreate(
                    ['candidature_id' => $candidature->id],
                    [
                        'status' => '1',
                        'intitule_concours' => $suivi->intitule_concours,
                        'type_concours' => $suivi->type_concours,
                        'date' => $suivi->choix_final_date ?? now(),
                        'autor_id' => Auth::id(),
                    ]
                );
            }

            return redirect()->back()->with('success', 'Candidat déclaré Admis avec succès ! Il est désormais orienté en suivi post-insertion.');
        } elseif ($request->resultat_statut === 'ajourne') {
            if ($candidature) {
                $candidature->admissionconcours = '0';
                $candidature->post_monitored = false;
                $candidature->save();

                // Synchroniser Inscriptionconcour status 0
                Inscriptionconcour::where('candidature_id', $candidature->id)->update(['status' => '0']);
            }

            return redirect()->back()->with('success', 'Candidat marqué comme Ajourné.');
        } else {
            // En attente
            if ($candidature) {
                $candidature->admissionconcours = '0';
                $candidature->post_monitored = false;
                $candidature->save();
            }

            return redirect()->back()->with('success', 'Statut du résultat réinitialisé en attente.');
        }
    }

    /**
     * Supprimer une entrée concours
     */
    public function destroy($id)
    {
        $suivi = ConcourSuivi::findOrFail($id);

        CandidatureControl::create([
            'user_id' => Auth::id(),
            'adherent_id' => $suivi->candidature_id,
            'type' => 'deleted',
            'table' => 'concour_suivis',
            'data' => json_encode($suivi),
        ]);

        $suivi->delete();

        return redirect()->back()->with('success', 'Entrée concours supprimée avec succès.');
    }
}
