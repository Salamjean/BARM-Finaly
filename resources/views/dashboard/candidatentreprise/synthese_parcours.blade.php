@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y px-4">
    <!-- Fil d'ariane & Bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold py-1 mb-1 text-primary">
                <i class="bx bx-briefcase-alt-2 me-2"></i> Synthèse Complète du Parcours Candidat
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                    @if ($candidat->orientation === 'fonction-publique')
                        <li class="breadcrumb-item"><a href="{{ route('candidatentreprises.decision_fp') }}">Décision Profilage FP</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('candidatentreprises.decision_ep') }}">Décision Profilage EP</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $candidat->user ? $candidat->user->fullName() : 'Candidat' }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            @php
                $dernierDocCv = $candidat->cvlms->whereNotNull('cv')->sortByDesc('created_at')->first();
                $dernierDocLm = $candidat->cvlms->whereNotNull('lm')->sortByDesc('created_at')->first();
                $cvPath = $dernierDocCv?->cv ?? $candidat->cv;
                $lmPath = $dernierDocLm?->lm ?? $candidat->demande_manuscrite;
            @endphp

            @if ($cvPath)
                <a href="{{ asset($cvPath) }}" class="btn btn-success shadow-sm" download target="_blank" title="Télécharger le Curriculum Vitae (CV)">
                    <i class="bx bx-download me-1"></i> Télécharger CV
                </a>
            @endif

            @if ($lmPath)
                <a href="{{ asset($lmPath) }}" class="btn btn-info text-white shadow-sm" download target="_blank" title="Télécharger la Lettre de Motivation (LM)">
                    <i class="bx bx-download me-1"></i> Télécharger LM
                </a>
            @endif

            <button onclick="window.history.back()" class="btn btn-outline-secondary shadow-sm">
                <i class="bx bx-arrow-back me-1"></i> Retour
            </button>
            <button onclick="window.print()" class="btn btn-outline-primary shadow-sm d-none d-md-inline-flex">
                <i class="bx bx-printer me-1"></i> Imprimer
            </button>
            @if ($candidat->user)
                <a href="{{ route('adherent.show', $candidat->user->id) }}" class="btn btn-secondary shadow-sm">
                    <i class="bx bx-user me-1"></i> Fiche Adhérent
                </a>
            @endif
            @if ($candidat->profilage_decision)
                <div class="d-inline-flex align-items-center gap-1">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 fs-6 rounded-3">
                        <i class="bx bx-check-double me-1 align-middle"></i> Décision Validée
                    </span>
                    <button type="button" class="btn btn-outline-warning shadow-sm" data-bs-toggle="modal" data-bs-target="#decisionModal" title="Modifier la décision">
                        <i class="bx bx-edit me-1"></i> Modifier
                    </button>
                </div>
            @else
                <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#decisionModal">
                    <i class="bx bx-gavel me-1"></i> Donner la décision
                </button>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bx bx-check-circle me-2 fs-5 align-middle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bx bx-error-circle me-2 fs-5 align-middle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- En-tête Profil du Candidat -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 bg-light bg-opacity-75">
            <div class="row align-items-center g-3">
                <div class="col-auto text-center">
                    @if ($candidat->image)
                        <img src="{{ asset($candidat->image) }}" alt="Photo" class="rounded-circle shadow-sm border border-3 border-white" style="width: 85px; height: 85px; object-fit: cover;">
                    @else
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-2 shadow-sm border border-3 border-white" style="width: 85px; height: 85px;">
                            {{ strtoupper(substr($candidat->user->firstname ?? 'C', 0, 1) . substr($candidat->user->lastname ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h4 class="fw-bold text-dark mb-0">{{ $candidat->user ? $candidat->user->fullName() : 'Inconnu' }}</h4>
                        @if ($candidat->orientation === 'entreprise-privee')
                            <span class="badge bg-success px-3 py-1 rounded-pill">
                                <i class="bx bx-briefcase me-1"></i> Entreprise Privée
                            </span>
                        @elseif ($candidat->orientation === 'fonction-publique')
                            <span class="badge bg-info px-3 py-1 rounded-pill">
                                <i class="bx bx-building me-1"></i> Fonction Publique
                            </span>
                        @elseif ($candidat->orientation === 'auto-emploi')
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill">
                                <i class="bx bx-user-pin me-1"></i> Auto-Emploi
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-1 rounded-pill">
                                {{ $candidat->orientation ?? 'Non défini' }}
                            </span>
                        @endif

                        @if ($candidat->en_poste == 1)
                            <span class="badge bg-success px-2 py-1"><i class="bx bx-check-circle me-1"></i> En Poste</span>
                        @endif
                    </div>
                    <div class="row g-2 text-muted small mt-1">
                        <div class="col-auto">
                            <i class="bx bx-id-card text-primary me-1"></i> <strong>Mécano :</strong> {{ $candidat->user->mecano ?? 'N/A' }}
                        </div>
                        <div class="col-auto">&bull;</div>
                        <div class="col-auto">
                            <i class="bx bx-barcode text-primary me-1"></i> <strong>Matricule :</strong> {{ $candidat->user->matricule ?? 'N/A' }}
                        </div>
                        <div class="col-auto">&bull;</div>
                        <div class="col-auto">
                            <i class="bx bx-phone text-primary me-1"></i> {{ $candidat->phone_number ?? $candidat->user->phone ?? 'N/A' }}
                        </div>
                        <div class="col-auto">&bull;</div>
                        <div class="col-auto">
                            <i class="bx bx-envelope text-primary me-1"></i> {{ $candidat->user->email ?? 'N/A' }}
                        </div>
                        <div class="col-auto">&bull;</div>
                        <div class="col-auto">
                            <i class="bx bx-map-pin text-primary me-1"></i> {{ $candidat->affectation ?? $candidat->residence ?? 'Non renseigné' }}
                        </div>
                        @if ($candidat->cohort)
                            <div class="col-auto">&bull;</div>
                            <div class="col-auto">
                                <i class="bx bx-group text-primary me-1"></i> <strong>Cohorte :</strong> {{ $candidat->cohort->reference }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicateurs / Nombre de fois où chaque action a été effectuée -->
    <div class="row g-3 mb-4">
        <!-- Entretiens -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-primary border-4">
                <div class="text-muted small fw-semibold mb-1">RDV 1 &bull; Entretiens</div>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="fs-3 fw-bold text-primary">{{ $candidat->candidatentretiens->count() }}</span>
                </div>
                @php $dernierEntretien = $candidat->candidatentretiens->sortByDesc('created_at')->first(); @endphp
                @if ($dernierEntretien && $dernierEntretien->presence == 1)
                    <span class="badge bg-success-subtle text-success mt-1 small">Présent (Validé)</span>
                @elseif ($dernierEntretien && ($dernierEntretien->presence === 0 || $dernierEntretien->presence === '0'))
                    <span class="badge bg-danger-subtle text-danger mt-1 small">Absent</span>
                @else
                    <span class="badge bg-light text-muted mt-1 small">En attente</span>
                @endif
            </div>
        </div>

        <!-- Bilans -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-info border-4">
                <div class="text-muted small fw-semibold mb-1">RDV 2 &bull; Bilans</div>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="fs-3 fw-bold text-info">{{ $candidat->bilancompetences->count() }}</span>
                </div>
                @php $dernierBilan = $candidat->bilancompetences->sortByDesc('created_at')->first(); @endphp
                @if ($dernierBilan && $dernierBilan->presence == 1)
                    <span class="badge bg-success-subtle text-success mt-1 small">Effectué (Validé)</span>
                @elseif ($dernierBilan && ($dernierBilan->presence === 0 || $dernierBilan->presence === '0'))
                    <span class="badge bg-danger-subtle text-danger mt-1 small">Absent</span>
                @else
                    <span class="badge bg-light text-muted mt-1 small">Non effectué</span>
                @endif
            </div>
        </div>

        <!-- Formations -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-success border-4">
                <div class="text-muted small fw-semibold mb-1">Formations</div>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="fs-3 fw-bold text-success">{{ $candidat->candidatformations->count() }}</span>
                </div>
                @php $attestationsCount = $candidat->candidatformations->whereNotNull('attestation')->count(); @endphp
                <span class="badge bg-light text-secondary mt-1 small">{{ $attestationsCount }} attestation(s)</span>
            </div>
        </div>

        <!-- CV & LM -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-warning border-4">
                <div class="text-muted small fw-semibold mb-1">CV & LM</div>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="fs-3 fw-bold text-warning">{{ $candidat->cvlms->count() }}</span>
                </div>
                <span class="badge bg-light text-secondary mt-1 small">Document(s) déposé(s)</span>
            </div>
        </div>

        <!-- Prépa Entretiens -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-secondary border-4">
                <div class="text-muted small fw-semibold mb-1">Prépa Entretiens</div>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="fs-3 fw-bold text-secondary">{{ $candidat->prepaentretiens->count() }}</span>
                </div>
                <span class="badge bg-light text-secondary mt-1 small">Séance(s) de coaching</span>
            </div>
        </div>

        <!-- Insertion / Mises à dispo / Concours -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-dark border-4">
                <div class="text-muted small fw-semibold mb-1">
                    {{ $candidat->orientation === 'fonction-publique' ? 'Concours / Dossiers' : 'Mises à disposition' }}
                </div>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="fs-3 fw-bold text-dark">
                        {{ $candidat->orientation === 'fonction-publique' ? $candidat->soumissiondossiers->count() + $candidat->concours->count() : $candidat->candidatentreprises->count() }}
                    </span>
                </div>
                @php
                    $enCours = $candidat->candidatentreprises->where('statut', 'pending')->count();
                    $acceptes = $candidat->candidatentreprises->where('statut', 'accepted')->count();
                @endphp
                <span class="badge bg-light text-secondary mt-1 small">{{ $acceptes }} validé / {{ $enCours }} en cours</span>
            </div>
        </div>
    </div>

    <!-- Navigation par Onglets de Synthèse -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom p-3">
            <ul class="nav nav-pills nav-fill gap-2" id="syntheseTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold py-2" id="profilage-tab" data-bs-toggle="tab" data-bs-target="#profilage-pane" type="button" role="tab">
                        <i class="bx bx-shield-quarter me-1 text-primary"></i> 1. Profilage & Évaluation (RDV 1, 2, 3)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold py-2" id="actions-tab" data-bs-toggle="tab" data-bs-target="#actions-pane" type="button" role="tab">
                        <i class="bx bx-briefcase me-1 text-success"></i> 2. Actions & Insertion en cours
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold py-2" id="formations-tab" data-bs-toggle="tab" data-bs-target="#formations-pane" type="button" role="tab">
                        <i class="bx bx-graduation me-1 text-info"></i> 3. Formations, CV & Préparation
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold py-2" id="academique-tab" data-bs-toggle="tab" data-bs-target="#academique-pane" type="button" role="tab">
                        <i class="bx bx-book-open me-1 text-warning"></i> 4. Diplômes & Expériences antérieures
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="syntheseTabContent">
                
                <!-- ========================================================================= -->
                <!-- ONGLET 1 : PROFILAGE (RDV 1, RDV 2, RDV 3)                                -->
                <!-- ========================================================================= -->
                <div class="tab-pane fade show active" id="profilage-pane" role="tabpanel">
                    <div class="row g-4">
                        <!-- RDV 1 : Entretiens -->
                        <div class="col-lg-6">
                            <div class="card border h-100 shadow-none">
                                <div class="card-header bg-light py-2 fw-bold d-flex justify-content-between align-items-center">
                                    <span><i class="bx bx-chat text-primary me-2"></i> Rendez-vous 1 : Entretiens ({{ $candidat->candidatentretiens->count() }})</span>
                                </div>
                                <div class="card-body p-3">
                                    @if ($candidat->candidatentretiens && $candidat->candidatentretiens->count() > 0)
                                        <div class="timeline ps-2">
                                            @foreach ($candidat->candidatentretiens as $index => $ce)
                                                <div class="p-3 mb-3 border rounded-3 bg-light bg-opacity-50">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="fw-bold text-dark">
                                                            Entretien {{ $index + 1 }} &bull; {{ $ce->entretien ? ($ce->entretien->type == 'collectif' ? 'Session Collective' : 'Entretien Individuel') : 'Entretien' }}
                                                        </span>
                                                        @if ($ce->presence == 1 || $ce->presence === '1')
                                                            <span class="badge bg-success"><i class="bx bx-check me-1"></i> Présent</span>
                                                        @elseif ($ce->presence == 2 || $ce->presence === '2')
                                                            <span class="badge bg-warning text-dark"><i class="bx bx-error-circle me-1"></i> Abandon</span>
                                                        @elseif ($ce->presence === 0 || $ce->presence === '0')
                                                            <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Absent</span>
                                                        @else
                                                            <span class="badge bg-secondary"><i class="bx bx-time me-1"></i> En attente</span>
                                                        @endif
                                                    </div>
                                                    <div class="small text-muted mb-2">
                                                        <i class="bx bx-calendar me-1"></i> Date : {{ $ce->entretien ? dateFr($ce->entretien->date, 'letter') : '-' }}
                                                    </div>
                                                    @if ($ce->comment)
                                                        <div class="p-2 bg-white rounded border small text-dark">
                                                            <strong>Observations de l'évaluateur :</strong><br>
                                                            {{ $ce->comment }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4 text-muted">
                                            <i class="bx bx-conversation fs-1 opacity-50 mb-2"></i>
                                            <p class="mb-0">Aucun entretien enregistré pour le moment.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- RDV 2 : Bilan de compétences -->
                        <div class="col-lg-6">
                            <div class="card border h-100 shadow-none">
                                <div class="card-header bg-light py-2 fw-bold d-flex justify-content-between align-items-center">
                                    <span><i class="bx bx-chart text-info me-2"></i> Rendez-vous 2 : Bilan de compétences ({{ $candidat->bilancompetences->count() }})</span>
                                </div>
                                <div class="card-body p-3">
                                    @if ($candidat->bilancompetences && $candidat->bilancompetences->count() > 0)
                                        @foreach ($candidat->bilancompetences as $index => $bc)
                                            <div class="p-3 mb-3 border rounded-3 bg-light bg-opacity-50">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-bold text-dark">Bilan n°{{ $index + 1 }}</span>
                                                    @if ($bc->presence == 1 || $bc->presence === '1')
                                                        <span class="badge bg-success"><i class="bx bx-check me-1"></i> Effectué / Présent</span>
                                                    @elseif ($bc->presence == 2 || $bc->presence === '2')
                                                        <span class="badge bg-warning text-dark"><i class="bx bx-error-circle me-1"></i> Abandon</span>
                                                    @elseif ($bc->presence === 0 || $bc->presence === '0')
                                                        <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Absent</span>
                                                    @else
                                                        <span class="badge bg-secondary"><i class="bx bx-time me-1"></i> En attente</span>
                                                    @endif
                                                </div>
                                                <div class="small text-muted mb-2">
                                                    <i class="bx bx-calendar me-1"></i> Date du bilan : {{ dateFr($bc->date, 'letter') }}
                                                </div>
                                                @if ($bc->comment)
                                                    <div class="p-2 bg-white rounded border small text-dark mb-2">
                                                        <strong>Synthèse & Conclusions :</strong><br>
                                                        {{ $bc->comment }}
                                                    </div>
                                                @endif
                                                @if ($bc->file)
                                                    <a href="{{ asset($bc->file) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                                        <i class="bx bx-download me-1"></i> Télécharger le document joint
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4 text-muted">
                                            <i class="bx bx-chart fs-1 opacity-50 mb-2"></i>
                                            <p class="mb-0">Aucun bilan de compétences enregistré pour le moment.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- RDV 3 : Décision finale de profilage -->
                        <div class="col-12">
                            @if ($candidat->profilage_decision)
                                <div class="card border border-success border-opacity-50 bg-success bg-opacity-10 shadow-none">
                                    <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-success px-3 py-1 rounded-pill">
                                                    <i class="bx bx-check-double me-1"></i> RDV 3 &bull; Profilage Validé & Clôturé
                                                </span>
                                                @if ($candidat->date_decision_profilage)
                                                    <small class="text-muted"><i class="bx bx-calendar me-1"></i> Validé le {{ dateFr($candidat->date_decision_profilage, 'letter') }}</small>
                                                @endif
                                            </div>
                                            <h5 class="fw-bold text-dark mb-1">
                                                Orientation définitive : <span class="text-success">{{ strtoupper(str_replace('-', ' ', $candidat->orientation ?? '')) }}</span>
                                            </h5>
                                            @if ($candidat->motif_decision_profilage)
                                                <p class="text-secondary small mb-0 mt-1">
                                                    <i class="bx bx-comment-detail text-primary me-1"></i> <strong>Motif / Remarques :</strong> {{ $candidat->motif_decision_profilage }}
                                                </p>
                                            @endif
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-outline-success btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#decisionModal">
                                                <i class="bx bx-edit me-1"></i> Modifier la décision
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card border border-warning border-opacity-50 bg-warning bg-opacity-10 shadow-none">
                                    <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1">
                                                <i class="bx bx-shield-quarter text-warning me-2 fs-4 align-middle"></i>
                                                Rendez-vous 3 &bull; Décision d'orientation du candidat
                                            </h5>
                                            <p class="text-muted small mb-0">
                                                Statut actuel : <strong class="text-dark">En attente de validation</strong> &bull; Parcours actuel : <strong>{{ strtoupper(str_replace('-', ' ', $candidat->orientation ?? 'Non défini')) }}</strong>
                                            </p>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#decisionModal">
                                                <i class="bx bx-gavel me-1"></i> Donner la décision
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ========================================================================= -->
                <!-- ONGLET 2 : ACTIONS & INSERTION EN COURS                                    -->
                <!-- ========================================================================= -->
                <div class="tab-pane fade" id="actions-pane" role="tabpanel">
                    @if ($candidat->orientation === 'fonction-publique')
                        <!-- Section Fonction Publique : Soumissions et Concours -->
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="card border shadow-none h-100">
                                    <div class="card-header bg-light py-2 fw-bold">
                                        <i class="bx bx-file text-info me-2"></i> Soumissions de dossiers ({{ $candidat->soumissiondossiers->count() }})
                                    </div>
                                    <div class="card-body p-3">
                                        @if ($candidat->soumissiondossiers && $candidat->soumissiondossiers->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover mb-0 align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Concours</th>
                                                            <th>Date de soumission</th>
                                                            <th>Statut</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidat->soumissiondossiers as $sd)
                                                            <tr>
                                                                <td class="fw-bold">{{ $sd->concour->intitule ?? $sd->concours ?? '-' }}</td>
                                                                <td>{{ dateFr($sd->created_at, 'letter') }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $sd->statut == 'accepted' ? 'success' : ($sd->statut == 'rejected' ? 'danger' : 'info') }}">
                                                                        {{ $sd->statut ?: 'Soumis' }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted text-center py-4 mb-0">Aucun dossier de concours soumis.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card border shadow-none h-100">
                                    <div class="card-header bg-light py-2 fw-bold">
                                        <i class="bx bx-medal text-warning me-2"></i> Inscriptions aux Concours ({{ $candidat->concours->count() }})
                                    </div>
                                    <div class="card-body p-3">
                                        @if ($candidat->concours && $candidat->concours->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover mb-0 align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Concours</th>
                                                            <th>Statut</th>
                                                            <th>Affectation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidat->concours as $co)
                                                            <tr>
                                                                <td class="fw-bold">{{ $co->concour->intitule ?? '-' }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $co->admission == 1 ? 'success' : ($co->admission === 0 ? 'danger' : 'warning text-dark') }}">
                                                                        {{ $co->admission == 1 ? 'Admis' : ($co->admission === 0 ? 'Ajourné' : 'En attente') }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $co->affectation ?: 'Non affecté' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted text-center py-4 mb-0">Aucune inscription aux concours enregistrée.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Section Entreprise Privée : Mises à disposition & Postes -->
                        <div class="card border shadow-none">
                            <div class="card-header bg-light py-2 fw-bold d-flex justify-content-between align-items-center">
                                <span><i class="bx bx-buildings text-primary me-2"></i> Propositions de postes & Mises à disposition ({{ $candidat->candidatentreprises->count() }})</span>
                            </div>
                            <div class="card-body p-3">
                                @if ($candidat->candidatentreprises && $candidat->candidatentreprises->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0 align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Entreprise</th>
                                                    <th>Poste proposé</th>
                                                    <th>Date de mise à disposition</th>
                                                    <th>Type de contrat</th>
                                                    <th>Statut de l'action</th>
                                                    <th>Observations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($candidat->candidatentreprises as $key => $ce)
                                                    <tr>
                                                        <td><span class="badge bg-light text-secondary border">{{ $key + 1 }}</span></td>
                                                        <td class="fw-bold text-dark">{{ $ce->entreprise }}</td>
                                                        <td>{{ $ce->poste }}</td>
                                                        <td>{{ dateFr($ce->date_mise_disposition, 'letter') }}</td>
                                                        <td><span class="badge bg-light text-primary border">{{ $ce->type_contrat ?: 'N/A' }}</span></td>
                                                        <td>
                                                            @if ($ce->statut === 'accepted')
                                                                <span class="badge bg-success"><i class="bx bx-check me-1"></i> Accepté</span>
                                                            @elseif ($ce->statut === 'refused')
                                                                <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Refusé</span>
                                                            @elseif ($ce->statut === 'finished')
                                                                <span class="badge bg-secondary">Terminé</span>
                                                            @else
                                                                <span class="badge bg-info"><i class="bx bx-time me-1"></i> En cours / Envoyé</span>
                                                            @endif
                                                        </td>
                                                        <td class="small text-muted">{{ $ce->commentaire ?: '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4 text-muted">
                                        <i class="bx bx-briefcase fs-1 opacity-50 mb-2"></i>
                                        <p class="mb-0">Aucune mise à disposition ou candidature en entreprise pour le moment.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ========================================================================= -->
                <!-- ONGLET 3 : FORMATIONS, CV & PRÉPARATIONS                                  -->
                <!-- ========================================================================= -->
                <div class="tab-pane fade" id="formations-pane" role="tabpanel">
                    <div class="row g-4">
                        <!-- Formations suivies -->
                        <div class="col-lg-6">
                            <div class="card border h-100 shadow-none">
                                <div class="card-header bg-light py-2 fw-bold">
                                    <i class="bx bx-graduation text-success me-2"></i> Formations suivies ({{ $candidat->candidatformations->count() }})
                                </div>
                                <div class="card-body p-3">
                                    @if ($candidat->candidatformations && $candidat->candidatformations->count() > 0)
                                        @foreach ($candidat->candidatformations as $cf)
                                            <div class="p-3 mb-3 border rounded-3 bg-light bg-opacity-50">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="fw-bold text-dark mb-0">{{ $cf->formation->intitule ?? 'Formation' }}</h6>
                                                    @if ($cf->presence == 1 || $cf->presence === '1')
                                                        <span class="badge bg-success"><i class="bx bx-check me-1"></i> Présent</span>
                                                    @elseif ($cf->presence == 2 || $cf->presence === '2')
                                                        <span class="badge bg-warning text-dark"><i class="bx bx-error-circle me-1"></i> Abandon</span>
                                                    @else
                                                        <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Absent</span>
                                                    @endif
                                                </div>
                                                <div class="small text-muted mb-2">
                                                    <i class="bx bx-building me-1"></i> Organisme : {{ $cf->formation->entreprise ?? '-' }} &bull; 
                                                    <i class="bx bx-map me-1"></i> Lieu : {{ $cf->formation->lieu ?? '-' }}
                                                </div>
                                                @if ($cf->attestation)
                                                    <a href="{{ asset($cf->attestation) }}" class="btn btn-xs btn-outline-success" target="_blank" download>
                                                        <i class="bx bx-download me-1"></i> Attestation de formation
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted text-center py-4 mb-0">Aucune formation suivie pour le moment.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- CV & LM + Préparation aux entretiens -->
                        <div class="col-lg-6">
                            <div class="card border mb-4 shadow-none">
                                <div class="card-header bg-light py-2 fw-bold d-flex justify-content-between align-items-center">
                                    <span><i class="bx bx-file text-warning me-2"></i> Documents CV & Lettres de motivation</span>
                                    <span class="badge bg-warning text-dark">{{ $candidat->cvlms->count() + ($candidat->cv ? 1 : 0) }} document(s)</span>
                                </div>
                                <div class="card-body p-3">
                                    @php
                                        $hasAnyDoc = ($candidat->cvlms && $candidat->cvlms->count() > 0) || $candidat->cv || $candidat->demande_manuscrite;
                                    @endphp

                                    @if ($hasAnyDoc)
                                        <div class="d-flex flex-column gap-2">
                                            @if ($candidat->cv || $candidat->demande_manuscrite)
                                                <div class="p-3 border rounded-3 bg-light bg-opacity-75">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <strong class="text-dark"><i class="bx bx-folder me-1 text-primary"></i> Documents initiaux d'adhésion</strong>
                                                            <div class="text-muted small">Déposés lors de la candidature initiale</div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @if ($candidat->cv)
                                                            <a href="{{ asset($candidat->cv) }}" class="btn btn-sm btn-success shadow-sm" download target="_blank">
                                                                <i class="bx bx-download me-1"></i> Télécharger CV Initial
                                                            </a>
                                                        @endif
                                                        @if ($candidat->demande_manuscrite)
                                                            <a href="{{ asset($candidat->demande_manuscrite) }}" class="btn btn-sm btn-info text-white shadow-sm" download target="_blank">
                                                                <i class="bx bx-download me-1"></i> Télécharger Demande / LM Initiale
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            @foreach ($candidat->cvlms as $cv)
                                                <div class="p-3 border rounded-3 bg-white shadow-sm">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <strong class="text-dark fs-6">{{ $cv->poste ?: ($cv->intitule ?: 'Document CV/LM') }}</strong>
                                                            <div class="text-muted small">
                                                                <i class="bx bx-calendar me-1"></i> Déposé le {{ dateFr($cv->date, 'letter') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @if ($cv->cv)
                                                            <a href="{{ asset($cv->cv) }}" class="btn btn-sm btn-outline-success" download target="_blank">
                                                                <i class="bx bx-cloud-download me-1"></i> Télécharger CV
                                                            </a>
                                                        @endif
                                                        @if ($cv->lm)
                                                            <a href="{{ asset($cv->lm) }}" class="btn btn-sm btn-outline-info" download target="_blank">
                                                                <i class="bx bx-cloud-download me-1"></i> Télécharger LM
                                                            </a>
                                                        @endif
                                                    </div>
                                                    @if ($cv->commentaire)
                                                        <div class="mt-2 p-2 bg-light rounded small text-secondary">
                                                            <i class="bx bx-comment-detail me-1 text-primary"></i> {{ $cv->commentaire }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4 text-muted">
                                            <i class="bx bx-file-blank fs-1 opacity-50 mb-2"></i>
                                            <p class="mb-0">Aucun CV ou lettre de motivation déposé pour ce candidat.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card border mb-4 shadow-none">
                                <div class="card-header bg-light py-2 fw-bold">
                                    <i class="bx bx-conversation text-secondary me-2"></i> Préparation aux Entretiens ({{ $candidat->prepaentretiens->count() }})
                                </div>
                                <div class="card-body p-3">
                                    @if ($candidat->prepaentretiens && $candidat->prepaentretiens->count() > 0)
                                        @foreach ($candidat->prepaentretiens as $pe)
                                            <div class="p-2 mb-2 border rounded bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong class="small text-dark">Séance du {{ dateFr($pe->date, 'letter') }}</strong>
                                                </div>
                                                <p class="small text-muted mb-0 mt-1">{{ $pe->commentaire ?: 'Aucun commentaire renseigné.' }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted text-center py-3 mb-0">Aucune séance de préparation enregistrée.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Techniques de recherche d'emploi (TRE) -->
                            <div class="card border shadow-none">
                                <div class="card-header bg-light py-2 fw-bold">
                                    <i class="bx bx-briefcase-alt-2 text-primary me-2"></i> Techniques de Recherche d'Emploi - TRE ({{ $candidat->techrechercheemplois->count() }})
                                </div>
                                <div class="card-body p-3">
                                    @if ($candidat->techrechercheemplois && $candidat->techrechercheemplois->count() > 0)
                                        @foreach ($candidat->techrechercheemplois as $tre)
                                            <div class="p-2 mb-2 border rounded bg-light">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="small text-dark">Séance du {{ dateFr($tre->date, 'letter') }}</strong>
                                                    @if ((int)$tre->presence === 1)
                                                        <span class="badge bg-success"><i class="bx bx-check me-1"></i> Réalisé</span>
                                                    @elseif ((int)$tre->presence === 2)
                                                        <span class="badge bg-warning text-dark" style="background-color: #ff9800 !important; color: white !important;"><i class="bx bx-log-out-circle me-1"></i> Abandon</span>
                                                    @else
                                                        <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Non réalisé</span>
                                                    @endif
                                                </div>
                                                <p class="small text-muted mb-0">{{ $tre->commentaire ?: 'Aucune observation enregistrée.' }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted text-center py-3 mb-0">Aucune séance TRE clôturée pour le moment.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================================================= -->
                <!-- ONGLET 4 : PARCOURS ACADÉMIQUE & EXPÉRIENCES                              -->
                <!-- ========================================================================= -->
                <div class="tab-pane fade" id="academique-pane" role="tabpanel">
                    <div class="row g-4">
                        <!-- Diplômes -->
                        <div class="col-lg-6">
                            <div class="card border h-100 shadow-none">
                                <div class="card-header bg-light py-2 fw-bold">
                                    <i class="bx bx-award text-primary me-2"></i> Diplômes & Certifications ({{ $candidat->diplomes->count() }})
                                </div>
                                <div class="card-body p-3">
                                    @if ($candidat->diplomes && $candidat->diplomes->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($candidat->diplomes as $dip)
                                                <li class="list-group-item px-0 py-2">
                                                    <div class="fw-bold text-dark">{{ $dip->nom_diplome ?: $dip->titre }}</div>
                                                    <div class="text-muted small">
                                                        <i class="bx bx-buildings me-1"></i> {{ $dip->ecole ?: $dip->etablissement }} &bull; 
                                                        <i class="bx bx-calendar me-1"></i> {{ $dip->annee ?: $dip->date_obtention }}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted text-center py-4 mb-0">Aucun diplôme renseigné.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Expériences -->
                        <div class="col-lg-6">
                            <div class="card border h-100 shadow-none">
                                <div class="card-header bg-light py-2 fw-bold">
                                    <i class="bx bx-briefcase-alt text-primary me-2"></i> Expériences professionnelles ({{ $candidat->jobs->count() }})
                                </div>
                                <div class="card-body p-3">
                                    @if ($candidat->jobs && $candidat->jobs->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($candidat->jobs as $exp)
                                                <li class="list-group-item px-0 py-2">
                                                    <div class="fw-bold text-dark">{{ $exp->poste ?: $exp->intitule }}</div>
                                                    <div class="text-muted small">
                                                        <i class="bx bx-buildings me-1"></i> {{ $exp->entreprise }} &bull; 
                                                        <i class="bx bx-calendar me-1"></i> {{ $exp->annee_debut }} - {{ $exp->annee_fin ?: 'Présent' }}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted text-center py-4 mb-0">Aucune expérience enregistrée.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Décision de Profilage -->
    <div class="modal fade" id="decisionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">
                        <i class="bx bx-shield-quarter me-1"></i> Décision de Profilage : {{ $candidat->user ? $candidat->user->fullName() : 'Candidat' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <p class="text-muted mb-1 small">Parcours actuel : <strong>{{ strtoupper($candidat->orientation ?? 'Non défini') }}</strong></p>
                        <p class="small text-secondary mb-3">
                            Après analyse complète du parcours (entretiens, bilan, formations et compétences), choisissez l'orientation à valider :
                        </p>
                    </div>

                    <!-- Option 1 : Confirmer -->
                    <form action="{{ route('adherent.decision.profilage', $candidat->id) }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="decision" value="confirm">
                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold shadow-sm">
                            <i class="bx bx-check-circle me-1 fs-5 align-middle"></i> 
                            Confirmer en {{ $candidat->orientation === 'fonction-publique' ? 'Fonction Publique' : 'Entreprise Privée' }}
                        </button>
                    </form>

                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1">
                        <span class="px-2 text-muted small fw-semibold">OU RÉORIENTER / CHANGER DE PARCOURS</span>
                        <hr class="flex-grow-1">
                    </div>

                    <!-- Option 2 : Refuser & Réorienter -->
                    <form action="{{ route('adherent.decision.profilage', $candidat->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="decision" value="reject">

                        <div class="mb-3 text-start">
                            <label class="form-label fw-semibold text-dark small">
                                 Nouvelle orientation <span class="text-danger">*</span>
                            </label>
                            <select name="new_orientation" class="form-select" required>
                                <option value="" disabled selected>-- Choisir le nouveau parcours --</option>
                                <option value="entreprise-privee">🏢 Entreprise Privée</option>
                                <option value="fonction-publique">🏛️ Fonction Publique</option>
                                <option value="auto-emploi">🌱 Auto-Emploi</option>
                            </select>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label fw-semibold text-dark small">
                                Motif de la décision / Réorientation
                            </label>
                            <textarea name="motif" rows="2" class="form-control" placeholder="Indiquez le motif ou les remarques sur le profil..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 py-2 fw-semibold text-dark shadow-sm">
                            <i class="bx bx-transfer-alt me-1 fs-5 align-middle"></i> Valider la Réorientation
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
