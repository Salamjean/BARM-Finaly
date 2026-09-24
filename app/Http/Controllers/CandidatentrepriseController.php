<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Entreprise;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Candidatentreprise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CandidatentrepriseStoreRequest;
use App\Http\Requests\CandidatentrepriseUpdateRequest;
use App\Models\Cohort;
use App\Models\Candidatentretien;
use App\Models\Bilancompetence;
use App\Models\Cvlm;
use App\Models\Prepaentretien;
use App\Models\Techrechercheemploi;
use App\Models\Candidatformation;
use App\Models\ConcourSuivi;
use Illuminate\Support\Facades\DB;
use App\Models\CandidatureControl;

class CandidatentrepriseController extends Controller
{

    public function candidats()
    {
        $candidats = Candidature::orderByDESC('created_at')
            ->where('death', false)
            ->where('disbursement', false)
            ->where('resignation', false)
            ->where('en_poste', '0')
            ->where('admissionconcours', '0')
            ->get();

        $title = 'Les candidats';

        return view('dashboard.candidatentreprise.candidats', compact('candidats', 'title'));
    }

    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'envoi');
        return $this->renderIndex($activeTab);
    }

    public function envoi(Request $request)
    {
        return $this->renderIndex('envoi');
    }

    public function integres(Request $request)
    {
        return $this->renderIndex('integre');
    }

    private function renderIndex($activeTab = 'envoi')
    {
        $candidatentreprises = Candidatentreprise::with(['candidature.user'])
            ->orderByDesc('created_at')
            ->get();

        // 1. Candidats envoyés en entreprise (uniquement ceux qui ne sont PAS encore acceptés : pending, refused, on_hold, null)
        $envoyes = $candidatentreprises->filter(function($item) {
            return $item->statut !== 'accepted';
        });
        
        // Liste des entreprises pour l'onglet Envoi (uniquement avec des candidats non encore acceptés)
        $entreprisesEnvoi = $envoyes->groupBy(function($item) {
            return $item->entreprise . '|' . $item->date_mise_disposition;
        })->map(function($group) {
            return [
                'entreprise' => $group->first()->entreprise,
                'date_mise_disposition' => $group->first()->date_mise_disposition,
                'total' => $group->count(),
                'pending' => $group->where('statut', 'pending')->count(),
                'refused' => $group->where('statut', 'refused')->count(),
            ];
        })->values();

        // 2. Candidats intégrés (strictement ceux dont le statut est 'accepted')
        $integres = $candidatentreprises->filter(function($item) {
            return $item->statut === 'accepted';
        });
        
        // Liste des entreprises pour l'onglet Intégrer
        $entreprisesIntegres = $integres->groupBy(function($item) {
            $d = $item->date_mise_disposition ?: $item->date_db;
            return $item->entreprise . '|' . $d;
        })->map(function($group) {
            return [
                'entreprise' => $group->first()->entreprise,
                'date_mise_disposition' => $group->first()->date_mise_disposition ?: $group->first()->date_db,
                'total' => $group->count(),
            ];
        })->values();

        $datas = $candidatentreprises->map(function ($item) {
            return [
                'entreprise' => $item->entreprise,
                'date_mise_disposition' => $item->date_mise_disposition,
            ];
        })->unique(function ($item) {
            return $item['entreprise'] . $item['date_mise_disposition'];
        })->values();

        $title = $activeTab === 'integre' 
            ? 'Mise à disposition - Candidats Intégrés' 
            : 'Mise à disposition - Envoi en entreprise';

        return view('dashboard.candidatentreprise.index', compact('candidatentreprises', 'title', 'datas', 'envoyes', 'integres', 'entreprisesEnvoi', 'entreprisesIntegres', 'activeTab'));
    }

    public function mise_a_disposition()
    {
        $candidats = Candidature::orderByDESC('created_at')->where('death', '0')->where('resignation', '0')->where('orientation', 'entreprise-privee')->where('en_poste', '0')->get();

        $entreprises = Entreprise::orderByDESC('created_at')->get();

        $title = 'Mise à dispositions des candidats';

        return view('dashboard.candidatentreprise.mise_a_disposition', compact('entreprises', 'title', 'candidats'));
    }

    public function store_mise_a_disposition(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'entreprise' => 'required|string',
                'candidatures' => 'required|exists:candidatures,id',
                'date_mise_disposition' => 'required|date',
                'poste' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->entreprise == 'other') {
                $data = Entreprise::create([
                    'nom' => $request->nom,
                    'autor_id' => Auth::user()->id,
                ]);

                $entreprise = $data->nom;
            } else {
                $entreprise = $request->entreprise;
            }

            foreach ($request->candidatures as $candidat) {

                $candidatentreprise = Candidatentreprise::create([
                    'entreprise' => $entreprise,
                    'date_mise_disposition' => $request->date_mise_disposition,
                    'poste' => $request->poste,
                    'candidature_id' => $candidat,
                    'autor_id' => Auth::user()->id,
                ]);
            }

            // $candidatures = $request->candidatures;
            // $candidatentreprise->candidatures()->attach($candidatures);

            return  redirect()->route('candidatentreprises.index', $request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function store_candidature_spontannee(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'entreprise' => 'required|string',
                'candidature_id' => 'required|exists:candidatures,id',
                'date_mise_disposition' => 'required|date',
                'poste' => 'required|string',
                'lettre_recommandation' => 'nullable|file',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->entreprise == 'other') {
                $data = Entreprise::create([
                    'nom' => $request->nom,
                    'autor_id' => Auth::user()->id,
                ]);

                $entreprise = $data->nom;
            } else {
                $entreprise = $request->entreprise;
            }

            $filePath = null;
            if ($request->hasFile('lettre_recommandation')) {
                $fileName = uniqid('lettre_recommandation_') . '.' . $request->file('lettre_recommandation')->getClientOriginalExtension();
                $request->lettre_recommandation->move(saveByEnv() . 'data/docs/lettre_recommandation', $fileName);
                $filePath = 'data/docs/lettre_recommandation/' . $fileName;
            }


            $candidatentreprise = Candidatentreprise::create([
                'entreprise' => $entreprise,
                'date_mise_disposition' => $request->date_mise_disposition,
                'candidature_id' => $request->candidature_id,
                'poste' => $request->poste,
                'lettre_recommandation' => $filePath,
                'autor_id' => Auth::user()->id,
            ]);


            // $candidatures = $request->candidatures;
            // $candidatentreprise->candidatures()->attach($candidatures);

            return  redirect()->route('candidatentreprises.show_candidatentreprise', $request->candidature_id)->with("success", 'Donnée
            enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function changestatut(Request $request)
    {
        try {

            $this->validate($request, [
                'statut' => 'required|string',
                'type_contrat' => 'nullable|string',
                'contrat' => 'nullable|file',
                'service' => 'nullable|string',
                'date_db' => 'nullable|date',
                'date_fin' => 'nullable|date',
                'localisation' => 'nullable|string',
                'commentaire' => 'nullable',
            ]);

            $candidatentreprise = Candidatentreprise::findOrFail($request->candidatentreprise_id);
            $candidat = Candidature::findOrFail($candidatentreprise->candidature_id);

            $filePath = null;
            if ($request->hasFile('contrat')) {
                $fileName = uniqid('contrat_') . '.' . $request->file('contrat')->getClientOriginalExtension();
                $request->contrat->move(saveByEnv() . 'data/docs/contrat', $fileName);
                $filePath = 'data/docs/contrat/' . $fileName;
            }

            if ($request->statut == 'accepted') {

                $candidatentreprise->update([
                    'statut' => $request->statut,
                    'type_contrat' => $request->type_contrat,
                    'contrat' => $filePath,
                    'service' => $request->service,
                    'date_db' => $request->date_db,
                    'date_fin' => $request->date_fin,
                    'localisation' => $request->localisation,
                    'commentaire' => $request->commentaire,
                ]);

                $candidat->update([
                    'en_poste' => '1',
                    'post_monitored' => true,
                    'poste_id' => $candidatentreprise->id,
                    'affectation' => $request->localisation,
                ]);

                $msg = "Candidature acceptée ! Le candidat est désormais intégré en poste et visible dans l'onglet « Intégrer ».";
            } elseif ($request->statut == 'refused') {
                $candidatentreprise->update([
                    'statut' => $request->statut,
                ]);
                $msg = "Décision enregistrée : candidature marquée comme non retenue.";
            } else {
                $msg = "Données enregistrées avec succès.";
            }

            return back()->with("success", $msg);
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function end_poste(Request $request)
    {
        try {
            $this->validate($request, [
                'statut' => 'required|string',
            ]);

            $candidatentreprise = Candidatentreprise::findOrFail($request->candidatentreprise_id);
            $candidat = Candidature::findOrFail($candidatentreprise->candidature_id);

            $candidatentreprise->update([
                'statut' => 'finished',
            ]);

            $candidat->update([
                'en_poste' => '0',
                'post_monitored' => false,
                'poste_id' => null,
                'affectation' => null,
            ]);

            return back()->with("success", 'Donnéeenregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function create_candidatentreprise(Candidature $candidat)
    {
        $entreprises = Entreprise::orderByDESC('created_at')->get();

        $title = 'Candidature spontanée';

        return view('dashboard.candidatentreprise.create_candidatentreprise', compact('entreprises', 'title', 'candidat'));
    }

    public function show_candidatentreprise(Candidature $candidat)
    {

        $candidatentreprises = Candidatentreprise::where('candidature_id', $candidat->id)->orderByDesc('created_at')->get();

        $title = 'Liste des candidatures spontanées';

        return view('dashboard.candidatentreprise.show_candidatentreprise', compact('candidatentreprises', 'title'));
    }

    public function store(Request $request)
    {
        $candidatentreprise = Candidatentreprise::create($request->validated());

        $request->session()->flash('candidatentreprise.id', $candidatentreprise->id);

        return redirect()->route('candidatentreprises.index');
    }

    public function show($entreprise, $date = null)
    {
        $type = request('type', 'all');

        $query = Candidatentreprise::with(['candidature.user'])
            ->where('entreprise', $entreprise);

        if ($date && $date !== 'all') {
            $query->where('date_mise_disposition', $date);
        }

        if ($type === 'envoi') {
            $query->where('statut', '!=', 'accepted');
        } elseif ($type === 'integre') {
            $query->where('statut', 'accepted');
        }

        $candidatentreprises = $query->orderByDesc('created_at')->get();

        $title = ($type === 'integre' ? 'Candidats intégrés' : 'Candidats envoyés') . ' - ' . $entreprise;

        return view('dashboard.candidatentreprise.show', compact('candidatentreprises', 'entreprise', 'date', 'type', 'title'));
    }

    public function edit(Candidatentreprise $candidatentreprise)
    {
        return view('dashboard.candidatentreprise.edit', compact('candidatentreprise'));
    }

    public function update(Request $request, Candidatentreprise $candidatentreprise)
    {
        $candidatentreprise->update($request->validated());

        $request->session()->flash('candidatentreprise.id', $candidatentreprise->id);

        return redirect()->route('candidatentreprises.index');
    }


    public function suivie_ep_candidats(Request $request)
    {
        $selectedCohort = $request->get('cohort_id');
        $selectedEntreprise = $request->get('entreprise');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Base query pour les candidatures orientées entreprise privée actives
        $query = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'entreprise-privee');

        if ($selectedCohort) {
            $query->where('cohort_id', $selectedCohort);
        }
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $candidatsIds = (clone $query)->pluck('id')->toArray();
        $totalCandidats = count($candidatsIds);

        // Répartition Genre
        $totalHommes = (clone $query)->where(function ($q) {
            $q->where('gender', 'Masculin')->orWhere('gender', 'M')->orWhere('gender', 'Homme')->orWhere('gender', 'homme');
        })->count();
        $totalFemmes = (clone $query)->where(function ($q) {
            $q->where('gender', 'Feminin')->orWhere('gender', 'F')->orWhere('gender', 'Femme')->orWhere('gender', 'femme');
        })->count();

        // 1. RDV 1 : Entretien
        $rdv1Count = Candidatentretien::whereIn('candidature_id', $candidatsIds)->where('presence', 1)->distinct('candidature_id')->count('candidature_id');
        $rdv1Absents = Candidatentretien::whereIn('candidature_id', $candidatsIds)->where('presence', 0)->distinct('candidature_id')->count('candidature_id');

        // 2. RDV 2 : Bilan de compétences
        $rdv2Count = Bilancompetence::whereIn('candidature_id', $candidatsIds)->where('presence', 1)->distinct('candidature_id')->count('candidature_id');

        // 3. RDV 3 : Validation / Décision de Profilage
        $rdv3Valides = (clone $query)->where('profilage_decision', 1)->count();
        $rdv3Eligibles = (clone $query)->where(function ($q) {
                $q->where('profilage_decision', 0)
                    ->orWhere('profilage_decision', false)
                    ->orWhereNull('profilage_decision');
            })
            ->whereHas('bilancompetences', function ($q) {
                $q->where('presence', 1);
            })->count();

        // 4. Préparation à l'insertion
        $cvlmCount = Cvlm::whereIn('candidature_id', $candidatsIds)->distinct('candidature_id')->count('candidature_id');
        $prepaCount = Prepaentretien::whereIn('candidature_id', $candidatsIds)->distinct('candidature_id')->count('candidature_id');
        $treCount = Techrechercheemploi::whereIn('candidature_id', $candidatsIds)->distinct('candidature_id')->count('candidature_id');
        $formationCount = Candidatformation::whereIn('candidature_id', $candidatsIds)->distinct('candidature_id')->count('candidature_id');

        // Candidats ayant bénéficié d'au moins un module de préparation ou formation
        $beneficiairesPrepa = Candidature::whereIn('id', $candidatsIds)->where(function ($q) {
            $q->whereHas('cvlms')
                ->orWhereHas('prepaentretiens')
                ->orWhereHas('techrechercheemplois')
                ->orWhereHas('candidatformations');
        })->count();

        // 5. Mise à disposition en entreprise
        $madQuery = Candidatentreprise::whereIn('candidature_id', $candidatsIds);
        if ($selectedEntreprise) {
            $madQuery->where('entreprise', $selectedEntreprise);
        }
        $madTotal = (clone $madQuery)->count();
        $madAcceptes = (clone $madQuery)->where('statut', 'accepted')->count();
        $madPending = (clone $madQuery)->where('statut', 'pending')->count();
        $madRejected = (clone $madQuery)->where('statut', 'rejected')->count();
        $madCandidatsUniques = (clone $madQuery)->distinct('candidature_id')->count('candidature_id');

        // 6. Candidats effectivement en poste
        $enPosteCount = (clone $query)->where('en_poste', '1')->count();

        // Taux clés
        $tauxInsertion = $totalCandidats > 0 ? round(($enPosteCount / $totalCandidats) * 100, 1) : 0;
        $tauxRecrutementMAD = $madTotal > 0 ? round(($madAcceptes / $madTotal) * 100, 1) : 0;
        $tauxProfilage = $totalCandidats > 0 ? round(($rdv3Valides / $totalCandidats) * 100, 1) : 0;

        // Statistiques par entreprise partenaire
        $entreprisesStats = Candidatentreprise::whereIn('candidature_id', $candidatsIds)
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
        $contratsStats = Candidatentreprise::whereIn('candidature_id', $candidatsIds)
            ->whereNotNull('type_contrat')
            ->where('type_contrat', '!=', '')
            ->select('type_contrat', DB::raw('count(*) as count'))
            ->groupBy('type_contrat')
            ->get();

        // Liste complète des candidats avec toutes les métriques de suivi
        $candidats = (clone $query)->with([
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
        }, SORT_NATURAL | SORT_FLAG_CASE);

        $cohortes = Cohort::orderBy('title')->get();
        $allEntreprises = Entreprise::orderBy('nom')->get();

        $activeTab = $request->get('tab', 'stats');

        $title = 'Suivi des Candidats (Entreprise Privée)';

        return view('dashboard.candidatentreprise.suivie_ep_candidats', compact(
            'candidats',
            'activeTab',
            'totalCandidats',
            'totalHommes',
            'totalFemmes',
            'rdv1Count',
            'rdv1Absents',
            'rdv2Count',
            'rdv3Valides',
            'rdv3Eligibles',
            'cvlmCount',
            'prepaCount',
            'treCount',
            'formationCount',
            'beneficiairesPrepa',
            'madTotal',
            'madAcceptes',
            'madPending',
            'madRejected',
            'madCandidatsUniques',
            'enPosteCount',
            'tauxInsertion',
            'tauxRecrutementMAD',
            'tauxProfilage',
            'entreprisesStats',
            'contratsStats',
            'cohortes',
            'allEntreprises',
            'selectedCohort',
            'selectedEntreprise',
            'dateFrom',
            'dateTo',
            'title'
        ));
    }

    public function decision_ep()
    {
        $candidats = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'entreprise-privee')
            ->where(function ($query) {
                $query->where('profilage_decision', 0)
                    ->orWhere('profilage_decision', false)
                    ->orWhereNull('profilage_decision');
            })
            ->whereHas('bilancompetences', function ($query) {
                $query->where('presence', 1);
            })
            ->with([
                'user',
                'bilancompetences',
                'candidatentretiens.entretien',
                'diplomes',
                'jobs',
                'candidatformations.formation',
                'cvlms',
                'prepaentretiens',
                'candidatentreprises'
            ])
            ->get()
            ->sortBy(function ($candidat) {
                return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
            }, SORT_NATURAL | SORT_FLAG_CASE);

        $title = 'Rendez-vous 3 : Validation / Décision - Profilage';

        return view('dashboard.candidatentreprise.decision_ep', compact('candidats', 'title'));
    }

    public function suivie_fp_candidats(Request $request)
    {
        $selectedCohort = $request->get('cohort_id');
        $selectedConcours = $request->get('concours');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'fonction-publique');

        if ($selectedCohort) {
            $query->where('cohort_id', $selectedCohort);
        }
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $candidatsIds = (clone $query)->pluck('id')->toArray();
        $totalCandidats = count($candidatsIds);

        $totalHommes = (clone $query)->where(function ($q) {
            $q->where('gender', 'Masculin')->orWhere('gender', 'M')->orWhere('gender', 'Homme')->orWhere('gender', 'homme');
        })->count();
        $totalFemmes = (clone $query)->where(function ($q) {
            $q->where('gender', 'Feminin')->orWhere('gender', 'F')->orWhere('gender', 'Femme')->orWhere('gender', 'femme');
        })->count();

        // 1. Profilage
        $rdv1Count = Candidatentretien::whereIn('candidature_id', $candidatsIds)->where('presence', 1)->distinct('candidature_id')->count('candidature_id');
        $rdv1Absents = Candidatentretien::whereIn('candidature_id', $candidatsIds)->where('presence', 0)->distinct('candidature_id')->count('candidature_id');
        $rdv2Count = Bilancompetence::whereIn('candidature_id', $candidatsIds)->where('presence', 1)->distinct('candidature_id')->count('candidature_id');
        $rdv3Valides = (clone $query)->where('profilage_decision', 1)->count();
        $rdv3Eligibles = (clone $query)->where(function ($q) {
                $q->where('profilage_decision', 0)
                    ->orWhere('profilage_decision', false)
                    ->orWhereNull('profilage_decision');
            })
            ->whereHas('bilancompetences', function ($q) {
                $q->where('presence', 1);
            })->count();

        // 2. Concours (ConcourSuivi)
        $suivisFP = ConcourSuivi::whereIn('candidature_id', $candidatsIds)->get();
        if ($selectedConcours) {
            $suivisFP = $suivisFP->where('intitule_concours', $selectedConcours);
        }

        $choixConcoursCount = $suivisFP->whereNotNull('intitule_concours')->count();
        $prepaConcoursCount = $suivisFP->whereNotNull('prepa_statut')->count();
        $prepaPresentsCount = $suivisFP->where('prepa_statut', 'present')->count();
        $prepaAbsentsCount = $suivisFP->where('prepa_statut', 'absent')->count();
        $prepaAbandonsCount = $suivisFP->where('prepa_statut', 'abandon')->count();
        
        $dossierR1Count = $suivisFP->whereNotNull('dossier_r1_date')->count();
        $dossierR2Count = $suivisFP->whereNotNull('dossier_r2_date')->count();
        $dossierCompletCount = $suivisFP->whereNotNull('dossier_r1_date')->whereNotNull('dossier_r2_date')->count();

        $dossiersDeposesCount = $suivisFP->where('choix_final_statut', 'depose')->count();
        $candidatsAdmis = $suivisFP->where('resultat_statut', 'admis')->count();
        $candidatsAjournes = $suivisFP->where('resultat_statut', 'ajourne')->count();
        $candidatsEnAttente = $suivisFP->where('choix_final_statut', 'depose')->where(function($item) {
            return empty($item->resultat_statut) || $item->resultat_statut === 'en_attente';
        })->count();

        // Taux
        $tauxProfilage = $totalCandidats > 0 ? round(($rdv3Valides / $totalCandidats) * 100, 1) : 0;
        $tauxAdmission = $dossiersDeposesCount > 0 ? round(($candidatsAdmis / $dossiersDeposesCount) * 100, 1) : 0;
        $tauxDepot = $totalCandidats > 0 ? round(($dossiersDeposesCount / $totalCandidats) * 100, 1) : 0;

        // Statistiques par Intitulé de concours
        $concoursStats = ConcourSuivi::whereIn('candidature_id', $candidatsIds)
            ->whereNotNull('intitule_concours')
            ->select(
                'intitule_concours',
                'type_concours',
                DB::raw('count(*) as total_candidats'),
                DB::raw('SUM(CASE WHEN prepa_statut = "present" THEN 1 ELSE 0 END) as total_prepa'),
                DB::raw('SUM(CASE WHEN dossier_r1_date IS NOT NULL AND dossier_r2_date IS NOT NULL THEN 1 ELSE 0 END) as total_dossiers_prets'),
                DB::raw('SUM(CASE WHEN choix_final_statut = "depose" THEN 1 ELSE 0 END) as total_deposes'),
                DB::raw('SUM(CASE WHEN resultat_statut = "admis" THEN 1 ELSE 0 END) as total_admis'),
                DB::raw('SUM(CASE WHEN resultat_statut = "ajourne" THEN 1 ELSE 0 END) as total_ajournes')
            )
            ->groupBy('intitule_concours', 'type_concours')
            ->orderByDesc('total_candidats')
            ->get();

        // Liste complète des candidats pour l'onglet individuel
        $candidats = (clone $query)->with([
            'user',
            'cohort',
            'candidatentretiens',
            'bilancompetences',
            'concourSuivi',
            'candidatformations.formation',
        ])->get()->sortBy(function ($candidat) {
            return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
        }, SORT_NATURAL | SORT_FLAG_CASE);

        $cohortes = Cohort::orderBy('title')->get();
        $allConcours = ConcourSuivi::whereNotNull('intitule_concours')->pluck('intitule_concours')->unique()->values();

        $activeTab = $request->get('tab', 'stats');
        $title = 'Suivi des Candidats (Fonction Publique)';

        return view('dashboard.candidatentreprise.suivie_fp_candidats', compact(
            'candidats',
            'activeTab',
            'totalCandidats',
            'totalHommes',
            'totalFemmes',
            'rdv1Count',
            'rdv1Absents',
            'rdv2Count',
            'rdv3Valides',
            'rdv3Eligibles',
            'choixConcoursCount',
            'prepaConcoursCount',
            'prepaPresentsCount',
            'prepaAbsentsCount',
            'prepaAbandonsCount',
            'dossierR1Count',
            'dossierR2Count',
            'dossierCompletCount',
            'dossiersDeposesCount',
            'candidatsAdmis',
            'candidatsAjournes',
            'candidatsEnAttente',
            'tauxProfilage',
            'tauxAdmission',
            'tauxDepot',
            'concoursStats',
            'cohortes',
            'allConcours',
            'selectedCohort',
            'selectedConcours',
            'dateFrom',
            'dateTo',
            'title'
        ));
    }

    public function decision_fp()
    {
        $candidats = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'fonction-publique')
            ->where(function ($query) {
                $query->where('profilage_decision', 0)
                    ->orWhere('profilage_decision', false)
                    ->orWhereNull('profilage_decision');
            })
            ->whereHas('bilancompetences', function ($query) {
                $query->where('presence', 1);
            })
            ->with([
                'user',
                'bilancompetences',
                'candidatentretiens.entretien',
                'diplomes',
                'jobs',
                'candidatformations.formation',
                'soumissiondossiers',
                'concours'
            ])
            ->get()
            ->sortBy(function ($candidat) {
                return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
            }, SORT_NATURAL | SORT_FLAG_CASE);

        $title = 'Rendez-vous 3 : Validation / Décision - Profilage';

        return view('dashboard.candidatentreprise.decision_fp', compact('candidats', 'title'));
    }

    public function historique_ep()
    {
        $candidats = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where(function ($query) {
                $query->where('orientation', 'entreprise-privee')
                    ->orWhereHas('candidatentretiens', function ($q) {
                        $q->whereHas('entretien', function ($eq) {
                            $eq->where('parcours', 'entreprise_privee');
                        });
                    });
            })
            ->where(function ($query) {
                $query->whereHas('candidatentretiens')
                    ->orWhereHas('bilancompetences');
            })
            ->with(['user', 'bilancompetences', 'candidatentretiens.entretien'])
            ->get()
            ->sortBy(function ($candidat) {
                return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
            }, SORT_NATURAL | SORT_FLAG_CASE);

        $title = 'Historique des profilages - Entreprise Privée';

        return view('dashboard.candidatentreprise.historique_ep', compact('candidats', 'title'));
    }

    public function historique_fp()
    {
        $candidats = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where(function ($query) {
                $query->where('orientation', 'fonction-publique')
                    ->orWhereHas('candidatentretiens', function ($q) {
                        $q->whereHas('entretien', function ($eq) {
                            $eq->where('parcours', 'fonction_public');
                        });
                    });
            })
            ->where(function ($query) {
                $query->whereHas('candidatentretiens')
                    ->orWhereHas('bilancompetences');
            })
            ->with(['user', 'bilancompetences', 'candidatentretiens.entretien'])
            ->get()
            ->sortBy(function ($candidat) {
                return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
            }, SORT_NATURAL | SORT_FLAG_CASE);

        $title = 'Historique des profilages - Fonction Publique';

        return view('dashboard.candidatentreprise.historique_fp', compact('candidats', 'title'));
    }

    public function synthese_parcours($candidat_id)
    {
        $candidat = Candidature::with([
            'user',
            'cohort',
            'diplomes',
            'jobs',
            'candidatentretiens.entretien',
            'bilancompetences',
            'candidatformations.formation',
            'cvlms',
            'prepaentretiens',
            'techrechercheemplois',
            'candidatentreprises',
            'soumissiondossiers',
            'concours.admi',
            'choiceFinal',
        ])->findOrFail($candidat_id);

        $title = 'Synthèse du parcours - ' . ($candidat->user ? $candidat->user->fullName() : 'Candidat');

        return view('dashboard.candidatentreprise.synthese_parcours', compact('candidat', 'title'));
    }

    public function destroy(Request $request, string $id)
    {
        authPermission('chef-cellule-formation-et-insertion');

        $candidatentreprise = Candidatentreprise::findOrFail($id);
        if ($candidatentreprise->statut == 'accepted')
            return response()->json(['success' => false, 'message' => 'La candidature est acceptée, vous ne pouvez pas la supprimer']);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $candidatentreprise->candidature_id,
            'type' => 'deleted',
            'table' => 'candidatentreprises',
            'data' => json_encode($candidatentreprise),
        ]);

        $candidatentreprise->delete();

        return response()->json(['success' => true]);
    }

    public function updateComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'commentaire' => 'nullable|string',
            ]);

            $candidatentreprise = Candidatentreprise::findOrFail($id);

            $candidatentreprise->update([
                'commentaire' => $request->commentaire,
            ]);

            return back()->with("success", 'Commentaire modifié avec succès');
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la mise à jour');
        }
    }
}
