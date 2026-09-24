@extends('layouts.app')

@section('content')
@push('css-push')
<link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
<style>
    .avatar-initial-concour {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
    }
    #datatable--barm th, #datatable--barm td {
        vertical-align: middle !important;
    }
    .kpi-card {
        transition: all 0.25s ease-in-out;
        cursor: pointer;
        text-decoration: none !important;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.12) !important;
    }
    .kpi-card.active-filter {
        border: 2px solid #5a8dee !important;
        box-shadow: 0 0.5rem 1rem rgba(90, 141, 238, 0.25) !important;
    }
</style>
@endpush

<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="d-none d-sm-flex align-items-center mb-4">
        <div class="border-start border-primary border-3 ps-3">
            <nav aria-label="breadcrumb">
                <div class="d-flex align-items-center">
                    <i class="bx bx-list-check text-primary fs-4 me-3"></i>
                    <div>
                        <div class="text-muted small">Concours & Fonction Publique</div>
                        <h4 class="mb-0 text-primary">{{ $title }}</h4>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <i class="bx bx-error-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Cartes KPI & Filtres rapides cliquables -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Inscrits -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('concours.inscrits', array_merge(request()->except('statut'), ['statut' => ''])) }}" 
               class="card border-0 shadow-sm rounded-4 kpi-card h-100 {{ empty($currentStatut) ? 'active-filter' : '' }}">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase">Total Inscrits</span>
                        <h3 class="mb-0 fw-bold text-dark mt-1">{{ $totalInscrits }}</h3>
                        <small class="text-primary"><i class="bx bx-folder-check me-1"></i>Dossiers déposés</small>
                    </div>
                    <div class="avatar bg-label-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bx bx-group fs-3 text-primary"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 2. Admis -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('concours.inscrits', array_merge(request()->except('statut'), ['statut' => 'admis'])) }}" 
               class="card border-0 shadow-sm rounded-4 kpi-card h-100 {{ $currentStatut === 'admis' ? 'active-filter' : '' }}">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase">Candidats Admis</span>
                        <h3 class="mb-0 fw-bold text-success mt-1">{{ $totalAdmis }}</h3>
                        <small class="text-success"><i class="bx bx-check-shield me-1"></i>En suivi post-insertion</small>
                    </div>
                    <div class="avatar bg-label-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bx bx-trophy fs-3 text-success"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3. Ajournés -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('concours.inscrits', array_merge(request()->except('statut'), ['statut' => 'ajourne'])) }}" 
               class="card border-0 shadow-sm rounded-4 kpi-card h-100 {{ $currentStatut === 'ajourne' ? 'active-filter' : '' }}">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase">Candidats Ajournés</span>
                        <h3 class="mb-0 fw-bold text-danger mt-1">{{ $totalAjournes }}</h3>
                        <small class="text-danger"><i class="bx bx-x-circle me-1"></i>Non retenus</small>
                    </div>
                    <div class="avatar bg-label-danger rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bx bx-x-circle fs-3 text-danger"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. En attente -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('concours.inscrits', array_merge(request()->except('statut'), ['statut' => 'en_attente'])) }}" 
               class="card border-0 shadow-sm rounded-4 kpi-card h-100 {{ $currentStatut === 'en_attente' ? 'active-filter' : '' }}">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase">En Attente</span>
                        <h3 class="mb-0 fw-bold text-warning mt-1">{{ $totalEnAttente }}</h3>
                        <small class="text-warning"><i class="bx bx-time me-1"></i>En attente de résultat</small>
                    </div>
                    <div class="avatar bg-label-warning rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bx bx-hourglass fs-3 text-warning"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Tableau & Filtres -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-bottom">
            <form method="GET" action="{{ route('concours.inscrits') }}" class="row g-3 align-items-center">
                <input type="hidden" name="statut" value="{{ request('statut') }}">

                <div class="col-12 col-md-4">
                    <label class="form-label small fw-semibold text-muted mb-1">Filtrer par Cohorte</label>
                    <select name="cohort_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes les cohortes</option>
                        @foreach($cohorts as $cohort)
                            <option value="{{ $cohort->id }}" {{ request('cohort_id') == $cohort->id ? 'selected' : '' }}>
                                {{ $cohort->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Recherche (Nom, Prénom, Matricule)</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher un candidat..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-2 text-md-end mt-md-auto">
                    @if(request('cohort_id') || request('statut') || request('search'))
                        <a href="{{ route('concours.inscrits') }}" class="btn btn-light-secondary text-secondary w-100">
                            <i class="bx bx-reset me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatable--barm">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Candidat</th>
                            <th class="text-center">Concours & Dépôt</th>
                            <th class="text-center">Résultat</th>
                            <th class="text-center">Affectation / Pièces</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suivis as $suivi)
                            @php
                                $candidat = $suivi->candidature;
                                $isAdmis = ($suivi->resultat_statut === 'admis');
                                $isAjourne = ($suivi->resultat_statut === 'ajourne');
                                $isPending = (!$isAdmis && !$isAjourne);
                            @endphp
                            <tr>
                                <!-- Candidat -->
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <div class="avatar-initial-concour {{ $isAdmis ? 'bg-label-success text-success' : ($isAjourne ? 'bg-label-danger text-danger' : 'bg-label-primary text-primary') }}">
                                            {{ strtoupper(substr($candidat->user->name ?? 'C', 0, 1) . substr($candidat->user->first_name ?? '', 0, 1)) }}
                                        </div>
                                        <div class="text-start">
                                            <span class="fw-bold text-dark d-block">{{ $candidat->user ? $candidat->user->fullName() : 'Candidat #' . $candidat->id }}</span>
                                            <div class="small text-muted">
                                                <span class="badge bg-secondary me-1">{{ $candidat->user->matricule ?? ($candidat->user->mecano ?? 'N/A') }}</span>
                                                <span>{{ $candidat->cohort->title ?? '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Concours & Dépôt -->
                                <td class="text-center">
                                    <span class="fw-bold text-primary d-block">{{ $suivi->intitule_concours }}</span>
                                    <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap mt-1">
                                        <small class="badge bg-label-secondary">{{ $suivi->type_concours ?? 'Concours Direct' }}</small>
                                        @if($suivi->choix_final_date)
                                            <small class="badge bg-light text-dark">
                                                <i class="bx bx-calendar me-1"></i>Déposé le {{ \Carbon\Carbon::parse($suivi->choix_final_date)->format('d/m/Y') }}
                                            </small>
                                        @endif
                                        @if($suivi->choix_final_recu)
                                            <a href="{{ asset($suivi->choix_final_recu) }}" target="_blank" class="badge bg-label-info text-decoration-none" title="Voir le reçu de dépôt">
                                                <i class="bx bx-file me-1"></i>Reçu
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                <!-- Résultat -->
                                <td class="text-center">
                                    @if($isAdmis)
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <span class="badge bg-success px-3 py-2 fs-7">
                                                <i class="bx bx-trophy me-1"></i> Admis
                                            </span>
                                            @if($suivi->resultat_date)
                                                <small class="text-muted mt-1">{{ \Carbon\Carbon::parse($suivi->resultat_date)->format('d/m/Y') }}</small>
                                            @endif
                                        </div>
                                    @elseif($isAjourne)
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <span class="badge bg-danger px-3 py-2 fs-7">
                                                <i class="bx bx-x-circle me-1"></i> Ajourné
                                            </span>
                                            @if($suivi->resultat_date)
                                                <small class="text-muted mt-1">{{ \Carbon\Carbon::parse($suivi->resultat_date)->format('d/m/Y') }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="badge bg-label-warning px-3 py-2 fs-7">
                                            <i class="bx bx-time me-1"></i> En attente
                                        </span>
                                    @endif
                                </td>

                                <!-- Affectation / Pièces -->
                                <td class="text-center">
                                    @if($isAdmis)
                                        <div class="d-flex flex-column align-items-center justify-content-center gap-1">
                                            @if($suivi->resultat_affectation)
                                                <span class="badge bg-label-primary text-truncate" style="max-width: 200px;" title="{{ $suivi->resultat_affectation }}">
                                                    <i class="bx bx-buildings me-1"></i> {{ $suivi->resultat_affectation }}
                                                </span>
                                            @else
                                                <span class="text-muted small">Affectation non renseignée</span>
                                            @endif
                                            @if($suivi->resultat_attestation)
                                                <a href="{{ asset($suivi->resultat_attestation) }}" target="_blank" class="badge bg-label-success text-decoration-none">
                                                    <i class="bx bx-paperclip me-1"></i> Attestation
                                                </a>
                                            @endif
                                        </div>
                                    @elseif($isAjourne)
                                        <span class="text-muted small">{{ $suivi->resultat_obs ?: 'Aucune observation' }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        @if($isAdmis)
                                            <!-- Bouton Suivre (Envoie vers la page de suivi post-insertion) -->
                                            <a href="{{ route('monitored-evaluation.post_monitored.adherent', $suivi->candidature_id) }}" 
                                               class="btn btn-sm btn-success rounded-pill px-3 shadow-none" 
                                               title="Ouvrir le suivi post-insertion">
                                                <i class="bx bx-check-shield me-1"></i> Suivre
                                            </a>
                                            <!-- Bouton modal pour modifier l'admission -->
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-circle" data-bs-toggle="modal" data-bs-target="#editDecisionModal{{ $suivi->id }}" title="Modifier la décision">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>
                                        @elseif($isAjourne)
                                            <!-- Ajourné : affichage statut + bouton modif -->
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-none" data-bs-toggle="modal" data-bs-target="#editDecisionModal{{ $suivi->id }}">
                                                <i class="bx bx-edit me-1"></i> Modifier décision
                                            </button>
                                        @else
                                            <!-- Deux boutons : Admis ou Ajourné -->
                                            <button type="button" class="btn btn-sm btn-success rounded-pill px-3 shadow-none" data-bs-toggle="modal" data-bs-target="#admisModal{{ $suivi->id }}">
                                                <i class="bx bx-check me-1"></i> Admis
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 shadow-none" data-bs-toggle="modal" data-bs-target="#ajourneModal{{ $suivi->id }}">
                                                <i class="bx bx-x me-1"></i> Ajourné
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- MODAL 1 : DÉCLARER ADMIS -->
                            <div class="modal fade" id="admisModal{{ $suivi->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('concours.decision_resultat') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="suivi_id" value="{{ $suivi->id }}">
                                            <input type="hidden" name="resultat_statut" value="admis">

                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title text-white">
                                                    <i class="bx bx-trophy me-2"></i> Déclarer Admis : {{ $candidat->user ? $candidat->user->fullName() : 'Candidat' }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 text-start">
                                                <div class="alert alert-info py-2 small mb-3">
                                                    <strong>Concours :</strong> {{ $suivi->intitule_concours }} ({{ $suivi->type_concours ?? 'Concours Direct' }})
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Date d'admission / proclamation</label>
                                                    <input type="date" name="resultat_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Structure / Ministère d'affectation</label>
                                                    <input type="text" name="resultat_affectation" class="form-control" placeholder="Ex: Ministère de l'Éducation Nationale..." value="{{ $suivi->resultat_affectation }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Attestation d'admission / PV (Optionnel)</label>
                                                    <input type="file" name="resultat_attestation" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                    <div class="form-text small">Formats acceptés : PDF, Images, Word (Max: 10 Mo)</div>
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold text-dark">Observations / Remarques</label>
                                                    <textarea name="resultat_obs" rows="2" class="form-control" placeholder="Détails supplémentaires...">{{ $suivi->resultat_obs }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light p-3">
                                                <button type="button" class="btn btn-light-secondary rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                                    <i class="bx bx-check me-1"></i> Confirmer l'admission
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL 2 : DÉCLARER AJOURNÉ -->
                            <div class="modal fade" id="ajourneModal{{ $suivi->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('concours.decision_resultat') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="suivi_id" value="{{ $suivi->id }}">
                                            <input type="hidden" name="resultat_statut" value="ajourne">

                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title text-white">
                                                    <i class="bx bx-x-circle me-2"></i> Marquer comme Ajourné : {{ $candidat->user ? $candidat->user->fullName() : 'Candidat' }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 text-start">
                                                <p class="text-muted">Êtes-vous sûr de vouloir marquer ce candidat comme ajourné pour ce concours ?</p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Date du résultat</label>
                                                    <input type="date" name="resultat_date" class="form-control" value="{{ date('Y-m-d') }}">
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold text-dark">Motif / Observations (Optionnel)</label>
                                                    <textarea name="resultat_obs" rows="3" class="form-control" placeholder="Observations...">{{ $suivi->resultat_obs }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light p-3">
                                                <button type="button" class="btn btn-light-secondary rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                    <i class="bx bx-x me-1"></i> Confirmer l'ajournement
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL 3 : MODIFIER DÉCISION EXISTANTE -->
                            <div class="modal fade" id="editDecisionModal{{ $suivi->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('concours.decision_resultat') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="suivi_id" value="{{ $suivi->id }}">

                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title text-white">
                                                    <i class="bx bx-edit me-2"></i> Modifier la décision : {{ $candidat->user ? $candidat->user->fullName() : 'Candidat' }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 text-start">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Statut du résultat</label>
                                                    <select name="resultat_statut" class="form-select" required>
                                                        <option value="admis" {{ $suivi->resultat_statut === 'admis' ? 'selected' : '' }}>Admis</option>
                                                        <option value="ajourne" {{ $suivi->resultat_statut === 'ajourne' ? 'selected' : '' }}>Ajourné</option>
                                                        <option value="en_attente" {{ empty($suivi->resultat_statut) || $suivi->resultat_statut === 'en_attente' ? 'selected' : '' }}>En attente de résultat</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Date du résultat</label>
                                                    <input type="date" name="resultat_date" class="form-control" value="{{ $suivi->resultat_date ? \Carbon\Carbon::parse($suivi->resultat_date)->format('Y-m-d') : date('Y-m-d') }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Structure / Ministère d'affectation</label>
                                                    <input type="text" name="resultat_affectation" class="form-control" placeholder="Ex: Ministère de l'Éducation Nationale..." value="{{ $suivi->resultat_affectation }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Attestation / Pièce jointe</label>
                                                    <input type="file" name="resultat_attestation" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                    @if($suivi->resultat_attestation)
                                                        <div class="mt-1">
                                                            <a href="{{ asset($suivi->resultat_attestation) }}" target="_blank" class="small text-primary">
                                                                <i class="bx bx-paperclip me-1"></i> Voir le document actuel
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold text-dark">Observations</label>
                                                    <textarea name="resultat_obs" rows="2" class="form-control">{{ $suivi->resultat_obs }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light p-3">
                                                <button type="button" class="btn btn-light-secondary rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                    <i class="bx bx-save me-1"></i> Enregistrer les modifications
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
