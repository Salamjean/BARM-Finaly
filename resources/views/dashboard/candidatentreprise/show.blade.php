@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush

    <div class="container-fluid flex-grow-1 container-p-y px-4">
        @php
            $isDateSelected = !empty($date) && $date !== 'all';
        @endphp

        <!-- Breadcrumb & Bouton Retour -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-buildings text-primary fs-3 me-3"></i>
                        <div>
                            @if ($isDateSelected)
                                <div class="text-muted small">
                                    Mise en relation &bull; 
                                    <a href="{{ route('candidatentreprises.show', ['entreprise' => $entreprise, 'type' => $type]) }}" class="text-primary fw-medium text-decoration-none">{{ $entreprise }}</a> &bull; 
                                    Session du {{ $date === 'sans-date' ? 'Date non définie' : dateFr($date, 'letter') }}
                                </div>
                                <h4 class="mb-0 text-primary fw-bold">{{ $entreprise }} &bull; Session du {{ $date === 'sans-date' ? 'Date non définie' : dateFr($date, 'dayMonthYear') }}</h4>
                            @else
                                <div class="text-muted small">Mise en relation &bull; Historique des Sessions de l'Entreprise</div>
                                <h4 class="mb-0 text-primary fw-bold">{{ $entreprise }}</h4>
                            @endif
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto d-flex align-items-center gap-2">
                @if ($isDateSelected)
                    <a href="{{ route('candidatentreprises.show', ['entreprise' => $entreprise, 'type' => $type]) }}" 
                       class="btn btn-outline-secondary shadow-sm">
                        <i class="bx bx-arrow-back me-1"></i> Retour aux sessions
                    </a>
                @else
                    <a href="{{ $type === 'integre' ? route('candidatentreprises.integres') : route('candidatentreprises.envoi') }}" 
                       class="btn btn-outline-secondary shadow-sm">
                        <i class="bx bx-arrow-back me-1"></i> Retour aux entreprises
                    </a>
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

        @if (!$isDateSelected)
            <!-- ========================================================================= -->
            <!-- NIVEAU 2 : LISTE DES DATES / SESSIONS DE MISE EN RELATION DE L'ENTREPRISE  -->
            <!-- ========================================================================= -->

            <!-- Cartes récapitulatives globales pour cette entreprise -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-3 bg-light-primary text-primary me-3">
                                <i class="bx bx-building fs-2"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold text-dark">{{ $entreprise }}</h4>
                                <p class="text-muted small mb-0">
                                    <i class="bx bx-calendar-check me-1"></i> <strong>{{ count($datesSessions) }} session(s)</strong> de mise en relation enregistrée(s)
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-primary">{{ $allMisesEnRelation->count() }}</h5>
                                <small class="text-muted">Total Candidats</small>
                            </div>
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-warning">{{ $allMisesEnRelation->where('statut', 'pending')->count() }}</h5>
                                <small class="text-muted">En attente</small>
                            </div>
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-success">{{ $allMisesEnRelation->where('statut', 'accepted')->count() }}</h5>
                                <small class="text-muted">Intégrés / En poste</small>
                            </div>
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-danger">{{ $allMisesEnRelation->where('statut', 'refused')->count() }}</h5>
                                <small class="text-muted">Refusés</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des sessions classées par date -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">
                            <i class="bx bx-calendar-event text-primary me-2"></i> Dates de mise en relation
                        </h5>
                        <p class="text-muted small mb-0">Cliquez sur « Ouvrir » sur une date pour consulter et gérer les candidats de cette session.</p>
                    </div>
                    <span class="badge bg-primary rounded-pill">{{ count($datesSessions) }} date(s)</span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="dt-responsive table table-striped table-hover align-middle" id="datatable-dates-sessions" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 25%;">Date de mise en relation</th>
                                    <th style="width: 35%;">Poste(s) concerné(s)</th>
                                    <th style="width: 20%;">Candidats</th>
                                    <th style="width: 15%;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datesSessions as $session)
                                    <tr>
                                        <td class="text-muted">{{ $loop->index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-light-primary text-primary rounded-3 me-3">
                                                    <i class="bx bx-calendar fs-4"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark fs-6">
                                                        {{ $session['date'] === 'sans-date' ? 'Date non définie' : dateFr($session['date'], 'letter') }}
                                                    </div>
                                                    <small class="text-muted">Session d'entretien</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if(count($session['postes']) > 0)
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($session['postes'] as $poste)
                                                        <span class="badge bg-light text-dark border">{{ $poste }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted small">Non précisé</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="badge bg-primary px-3 py-2 rounded-pill">
                                                    <i class="bx bx-user me-1"></i> {{ $session['total'] }} candidat(s)
                                                </span>
                                                @if ($session['pending'] > 0)
                                                    <span class="badge bg-light-warning text-dark border px-2 py-1 rounded-pill small">
                                                        {{ $session['pending'] }} en attente
                                                    </span>
                                                @endif
                                                @if ($session['accepted'] > 0)
                                                    <span class="badge bg-success px-2 py-1 rounded-pill small">
                                                        {{ $session['accepted'] }} accepté(s)
                                                    </span>
                                                @endif
                                                @if ($session['refused'] > 0)
                                                    <span class="badge bg-danger px-2 py-1 rounded-pill small">
                                                        {{ $session['refused'] }} refusé(s)
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('candidatentreprises.show', [$entreprise, $session['date'], 'type' => $type]) }}" 
                                               class="btn btn-primary btn-sm shadow-sm"
                                               title="Ouvrir la liste des candidats de cette date">
                                                <i class="bx bx-folder-open me-1"></i> Ouvrir
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bx bx-calendar-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                            <h6 class="fw-bold mb-1">Aucune session enregistrée pour cette entreprise</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @else
            <!-- ========================================================================= -->
            <!-- NIVEAU 3 : LISTE DES CANDIDATS DE CETTE DATE / SESSION SPÉCIFIQUE         -->
            <!-- ========================================================================= -->

            <!-- Cartes récapitulatives pour la date sélectionnée -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-3 bg-light-warning text-warning me-3">
                                <i class="bx bx-calendar-event fs-2"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold text-dark">{{ $entreprise }}</h4>
                                <p class="text-muted small mb-0">
                                    <i class="bx bx-calendar me-1"></i> Mise en relation du : <strong>{{ $date === 'sans-date' ? 'Date non définie' : dateFr($date, 'letter') }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-primary">{{ $candidatentreprises->count() }}</h5>
                                <small class="text-muted">Candidats à cette date</small>
                            </div>
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-warning">{{ $candidatentreprises->where('statut', 'pending')->count() }}</h5>
                                <small class="text-muted">En attente</small>
                            </div>
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-success">{{ $candidatentreprises->where('statut', 'accepted')->count() }}</h5>
                                <small class="text-muted">Intégrés / En poste</small>
                            </div>
                            <div class="text-center px-3 py-2 bg-light rounded-3 border">
                                <h5 class="mb-0 fw-bold text-danger">{{ $candidatentreprises->where('statut', 'refused')->count() }}</h5>
                                <small class="text-muted">Refusés</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des candidats de cette session -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bx bx-group text-primary me-2"></i> Liste des candidats
                    </h5>
                    <span class="badge bg-primary rounded-pill">{{ $candidatentreprises->count() }} candidat(s)</span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="dt-responsive table table-striped table-hover align-middle" id="datatable-candidats-entreprise" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 25%;">Candidat</th>
                                    <th style="width: 15%;">Poste</th>
                                    <th style="width: 15%;">Statut</th>
                                    <th style="width: 15%;">Contrat & Période</th>
                                    <th style="width: 10%;">Date mise à dispo</th>
                                    <th style="width: 15%;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($candidatentreprises as $item)
                                    <tr>
                                        <td class="text-muted">{{ $loop->index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $item->candidature->user ? $item->candidature->user->fullName() : 'Candidat' }}</div>
                                            <div class="small text-muted">
                                                <span class="badge bg-secondary me-1">{{ $item->candidature->user->mecano ?? 'N/A' }}</span>
                                                <span>{{ $item->candidature->phone_number ?? ($item->candidature->user->phone ?? '') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $item->poste ?: 'Non précisé' }}</span>
                                            @if ($item->service)
                                                <div class="small text-muted mt-1"><i class="bx bx-layer me-1"></i> {{ $item->service }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->statut === 'pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bx bx-time me-1"></i> En cours de traitement
                                                </span>
                                            @elseif ($item->statut === 'accepted')
                                                <span class="badge bg-success">
                                                    <i class="bx bx-check-circle me-1"></i> Accepté / En poste
                                                </span>
                                            @elseif ($item->statut === 'refused')
                                                <span class="badge bg-danger">
                                                    <i class="bx bx-x me-1"></i> Rejeté
                                                </span>
                                            @elseif ($item->statut === 'finished')
                                                <span class="badge bg-secondary">
                                                    <i class="bx bx-stop-circle me-1"></i> Terminé
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $item->statut }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->type_contrat || $item->contrat)
                                                <div class="d-flex align-items-center gap-1">
                                                    <span class="badge bg-info text-white">{{ $item->type_contrat ?: 'Contrat' }}</span>
                                                    @if ($item->contrat)
                                                        <a href="{{ route('document.download', ['path' => $item->contrat, 'name' => 'Contrat_' . Str::slug($item->candidature->user ? $item->candidature->user->fullName() : 'candidat', '_'), 'user' => ($item->candidature->user ? $item->candidature->user->fullName() : ''), 'matricule' => ($item->candidature->user ? $item->candidature->user->matricule : '')]) }}" 
                                                           class="btn btn-xs btn-outline-success" 
                                                           download 
                                                           title="Télécharger le contrat (PDF)">
                                                            <i class="bx bx-download"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                            @if ($item->date_db)
                                                <div class="small text-muted mt-1">
                                                    Du {{ dateFr($item->date_db, 'dayMonthYear') }} {{ $item->date_fin ? 'au ' . dateFr($item->date_fin, 'dayMonthYear') : '' }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small text-muted">
                                                <i class="bx bx-calendar me-1"></i> {{ dateFr($item->date_mise_disposition, 'letter') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                <!-- Bouton Suivre / Changer Statut (modal) -->
                                                @if (can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                                                    @if ($item->statut == 'pending')
                                                        <button type="button" 
                                                                class="btn btn-warning btn-sm shadow-sm"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#rapportModal{{ $item->id }}"
                                                                title="Évaluer / Décision de l'entretien">
                                                            <i class="bx bx-edit me-1"></i> Suivre
                                                        </button>
                                                    @else
                                                        <button type="button" 
                                                                class="btn btn-outline-warning btn-sm shadow-sm"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#rapportModal{{ $item->id }}"
                                                                title="Mettre à jour la décision ou les informations de l'entretien">
                                                            <i class="bx bx-edit-alt me-1"></i> Mettre à jour
                                                        </button>
                                                    @endif
                                                @endif

                                                <!-- Bouton Dossier Synthèse -->
                                                <a href="{{ route('candidatentreprises.synthese_parcours', $item->candidature_id) }}" 
                                                   class="btn btn-outline-info btn-sm shadow-sm" 
                                                   title="Voir le dossier / parcours du candidat">
                                                    <i class="bx bx-folder-open me-1"></i> Dossier
                                                </a>

                                                <!-- Bouton Fiche Adhérent -->
                                                @if ($item->candidature->user)
                                                    <a href="{{ route('adherent.show', $item->candidature->user->id) }}" 
                                                       class="btn btn-outline-secondary btn-sm shadow-sm" 
                                                       title="Fiche profil">
                                                        <i class="bx bx-user"></i>
                                                    </a>
                                                @endif

                                                <!-- Bouton Suivre (Suivi post-insertion) pour les candidats intégrés -->
                                                @if ($item->statut == 'accepted')
                                                    <a href="{{ route('monitored-evaluation.post_monitored.adherent', $item->candidature_id) }}" 
                                                       class="btn btn-success btn-sm shadow-sm" 
                                                       title="Ouvrir le suivi post-insertion">
                                                        <i class="bx bx-check-shield me-1"></i> Suivi
                                                    </a>
                                                @endif
                                            </div>

                                            <!-- Modal Suivi & Décision -->
                                            @if (can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                                                <div id="rapportModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title text-white">
                                                                    <i class="bx bx-briefcase me-1"></i> Compte rendu & Décision : {{ $item->candidature->user ? $item->candidature->user->fullName() : 'Candidat' }}
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('candidatentreprises.changestatut') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="candidatentreprise_id" value="{{ $item->id }}">
                                                                <div class="modal-body p-4 text-start">
                                                                    <div class="alert alert-info py-2 small mb-3">
                                                                        <strong>Entreprise :</strong> {{ $item->entreprise }} &bull; <strong>Poste :</strong> {{ $item->poste }}
                                                                    </div>

                                                                    <div class="row g-3 mb-3">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Date de mise en relation / entretien : </label>
                                                                            <input type="date" class="form-control" name="date_mise_disposition" value="{{ $item->date_mise_disposition ? \Carbon\Carbon::parse($item->date_mise_disposition)->format('Y-m-d') : '' }}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Décision de l'entreprise <span class="text-danger">*</span> : </label>
                                                                            <select class="form-select" name="statut" id="statut{{ $item->id }}" onchange="toggleStatut({{ $item->id }})" required>
                                                                                <option value="" disabled {{ empty($item->statut) || $item->statut == 'pending' ? 'selected' : '' }}>-- Choisir une décision --</option>
                                                                                <option value="accepted" {{ $item->statut == 'accepted' ? 'selected' : '' }}>🟢 Candidature acceptée (Intégrer le candidat en poste)</option>
                                                                                <option value="refused" {{ $item->statut == 'refused' ? 'selected' : '' }}>🔴 Candidature refusée / non retenue</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div id="other{{ $item->id }}" style="display: {{ $item->statut == 'accepted' ? 'block' : 'none' }};">
                                                                        <div class="row g-3">
                                                                            <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Poste confirmé : </label>
                                                                            <input class="form-control" type="text" name="poste_confirme" value="{{ $item->poste }}" placeholder="Poste occupé">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Lieu d'affectation : </label>
                                                                            <input class="form-control" type="text" name="localisation" value="{{ $item->localisation }}" placeholder="Ex: Abidjan, Bouaké...">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Service / Département : </label>
                                                                            <input class="form-control" type="text" name="service" value="{{ $item->service }}" placeholder="Ex: Maintenance, Logistique...">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Type de contrat : </label>
                                                                            <select class="form-select" name="type_contrat">
                                                                                <option value="CDI" {{ $item->type_contrat == 'CDI' ? 'selected' : '' }}>CDI</option>
                                                                                <option value="CDD" {{ $item->type_contrat == 'CDD' ? 'selected' : '' }}>CDD</option>
                                                                                <option value="Stage" {{ $item->type_contrat == 'Stage' ? 'selected' : '' }}>Stage / Période d'essai</option>
                                                                                <option value="Autre" {{ $item->type_contrat == 'Autre' ? 'selected' : '' }}>Autre</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Date de début : </label>
                                                                            <input class="form-control" type="date" name="date_db" value="{{ $item->date_db ? \Carbon\Carbon::parse($item->date_db)->format('Y-m-d') : date('Y-m-d') }}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold text-dark">Date de fin (optionnel) : </label>
                                                                            <input class="form-control" type="date" name="date_fin" value="{{ $item->date_fin ? \Carbon\Carbon::parse($item->date_fin)->format('Y-m-d') : '' }}">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-label fw-semibold text-dark">Contrat / Attestation de travail (fichier) : </label>
                                                                            @if ($item->contrat)
                                                                                <div class="small text-muted mb-1">
                                                                                    <i class="bx bx-file me-1"></i> Fichier existant : <a href="{{ route('document.download', ['path' => $item->contrat, 'name' => 'Contrat_' . Str::slug($item->candidature->user ? $item->candidature->user->fullName() : 'candidat', '_'), 'user' => ($item->candidature->user ? $item->candidature->user->fullName() : ''), 'matricule' => ($item->candidature->user ? $item->candidature->user->matricule : '')]) }}" download>Télécharger / Consulter le contrat (PDF)</a> (Sélectionnez un nouveau fichier pour le remplacer).
                                                                                </div>
                                                                            @endif
                                                                            <input class="form-control" type="file" name="contrat">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-label fw-semibold text-dark">Commentaires / Observations : </label>
                                                                            <textarea name="commentaire" class="form-control" rows="3" placeholder="Remarques et conditions de travail...">{{ $item->commentaire }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Enregistrer la décision</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bx bx-group fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        <h6 class="fw-bold mb-1">Aucun candidat pour cette session de mise en relation</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('js-push')
        <script>
            function toggleStatut(id) {
                var statutSelect = document.getElementById("statut" + id);
                var otherDiv = document.getElementById("other" + id);
                if (statutSelect && otherDiv) {
                    if (statutSelect.value === "accepted") {
                        otherDiv.style.display = "block";
                    } else {
                        otherDiv.style.display = "none";
                    }
                }
            }

            (function($) {
                "use strict";

                if ($('#datatable-dates-sessions').length) {
                    $('#datatable-dates-sessions').DataTable({
                        responsive: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                        }
                    });
                }

                if ($('#datatable-candidats-entreprise').length) {
                    $('#datatable-candidats-entreprise').DataTable({
                        responsive: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                        }
                    });
                }

                // Confirmation pour terminer le poste d'un candidat intégré
                $('.end-poste-btn').on('click', function(e) {
                    e.preventDefault();
                    var candidatId = $(this).data('candidat-id');
                    var candidatNom = $(this).data('candidat-nom');

                    Swal.fire({
                        title: "Terminer le poste ?",
                        text: "Voulez-vous clôturer la période de placement de " + candidatNom + " dans cette entreprise ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Oui, terminer",
                        cancelButtonText: "Annuler"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#endPosteForm-' + candidatId).submit();
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush
@endsection