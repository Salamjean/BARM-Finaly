@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-history text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Profilage &bull; Entreprise Privée</div>
                            <h4 class="mb-0 text-primary">Historique des profilages</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Cartes récapitulatives / Métriques -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                            <i class="bx bx-group fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small">Total profilés</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ $candidats->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                            <i class="bx bx-conversation fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small">RDV 1 (Entretiens)</span>
                            <h4 class="mb-0 fw-bold text-success">
                                {{ $candidats->filter(fn($c) => $c->candidatentretiens->where('presence', 1)->count() > 0)->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 me-3">
                            <i class="bx bx-chart fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small">RDV 2 (Bilans faits)</span>
                            <h4 class="mb-0 fw-bold text-info">
                                {{ $candidats->filter(fn($c) => $c->bilancompetences->where('presence', 1)->count() > 0)->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3">
                            <i class="bx bx-check-double fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small">Confirmés EP</span>
                            <h4 class="mb-0 fw-bold text-warning">
                                {{ $candidats->where('orientation', 'entreprise-privee')->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau de l'historique complet -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bx bx-list-check text-primary me-2"></i>
                        Historique des procédures de profilage
                    </h5>
                    <span class="badge bg-light text-secondary border">
                        {{ $candidats->count() }} candidat(s) enregistré(s)
                    </span>
                </div>
                
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">#</th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i> Candidat
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-conversation text-primary me-1"></i> RDV 1 : Entretien
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-chart text-primary me-1"></i> RDV 2 : Bilan
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-compass text-primary me-1"></i> Orientation actuelle
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidats as $index => $candidat)
                                @php
                                    $dernierEntretien = $candidat->candidatentretiens->sortByDesc('created_at')->first();
                                    $dernierBilan = $candidat->bilancompetences->sortByDesc('created_at')->first();
                                @endphp
                                <tr class="align-middle">
                                    <td>
                                        <span class="badge bg-light text-secondary border">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                                {{ strtoupper(substr($candidat->user->firstname ?? 'C', 0, 1) . substr($candidat->user->lastname ?? 'A', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user ? $candidat->user->fullName() : 'Inconnu' }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">Matricule: {{ $candidat->user->mecano ?? 'N/A' }}</span>
                                                    <span>{{ $candidat->phone_number ?? $candidat->user->phone ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($dernierEntretien)
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($dernierEntretien->presence == 1)
                                                    <span class="badge bg-success">
                                                        <i class="bx bx-check me-1"></i> Présent
                                                    </span>
                                                @elseif ($dernierEntretien->presence == 2 || $dernierEntretien->presence === '2' || $dernierEntretien->presence === 'abandon')
                                                    <span class="badge bg-warning text-dark" style="background-color: #ff9800 !important; color: white !important;">
                                                        <i class="bx bx-log-out-circle me-1"></i> Abandon
                                                    </span>
                                                @elseif ($dernierEntretien->presence === 0 || $dernierEntretien->presence === '0')
                                                    <span class="badge bg-danger">
                                                        <i class="bx bx-x me-1"></i> Absent
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bx bx-time me-1"></i> En attente
                                                    </span>
                                                @endif
                                                <div class="small text-muted">
                                                    @if ($dernierEntretien->entretien)
                                                        {{ dateFr($dernierEntretien->entretien->date, 'letter') }}
                                                        <span class="badge bg-light text-dark border ms-1">
                                                            {{ $dernierEntretien->entretien->type == 'collectif' ? 'Collectif' : 'Individuel' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($dernierEntretien->comment)
                                                <div class="mt-1 small text-secondary text-truncate" style="max-width: 200px;" title="{{ $dernierEntretien->comment }}">
                                                    <i class="bx bx-comment-detail me-1 text-primary"></i> {{ $dernierEntretien->comment }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-muted border">Non programmé</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($dernierBilan)
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($dernierBilan->presence == 1 || $dernierBilan->presence === '1')
                                                    <span class="badge bg-success">
                                                        <i class="bx bx-check me-1"></i> Effectué
                                                    </span>
                                                @elseif ($dernierBilan->presence == 2 || $dernierBilan->presence === '2' || $dernierBilan->presence === 'abandon')
                                                    <span class="badge bg-warning text-dark" style="background-color: #ff9800 !important; color: white !important;">
                                                        <i class="bx bx-log-out-circle me-1"></i> Abandon
                                                    </span>
                                                @elseif ($dernierBilan->presence === 0 || $dernierBilan->presence === '0')
                                                    <span class="badge bg-danger">
                                                        <i class="bx bx-x me-1"></i> Absent
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bx bx-time me-1"></i> En attente
                                                    </span>
                                                @endif
                                                <div class="small text-muted">
                                                    {{ dateFr($dernierBilan->date, 'letter') }}
                                                </div>
                                            </div>
                                            @if ($dernierBilan->comment)
                                                <div class="mt-1 small text-secondary text-truncate" style="max-width: 200px;" title="{{ $dernierBilan->comment }}">
                                                    <i class="bx bx-comment-detail me-1 text-primary"></i> {{ $dernierBilan->comment }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-muted border">Non effectué</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($candidat->orientation === 'entreprise-privee')
                                            <span class="badge bg-success px-2 py-1">
                                                <i class="bx bx-briefcase me-1"></i> Entreprise Privée
                                            </span>
                                        @elseif ($candidat->orientation === 'fonction-publique')
                                            <span class="badge bg-info px-2 py-1">
                                                <i class="bx bx-building me-1"></i> Fonction Publique
                                            </span>
                                        @elseif ($candidat->orientation === 'auto-emploi')
                                            <span class="badge bg-warning text-dark px-2 py-1">
                                                <i class="bx bx-user-pin me-1"></i> Auto-Emploi
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-2 py-1">
                                                {{ $candidat->orientation ?? 'Non défini' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Bouton Synthèse Globale du Parcours -->
                                            <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir toute la synthèse détaillée du parcours du candidat">
                                                <i class="bx bx-file-find me-1"></i> Parcours complet
                                            </a>

                                            <!-- Bouton Fiche Adhérent -->
                                            @if ($candidat->user)
                                                <a href="{{ route('adherent.show', $candidat->user->id) }}" 
                                                   class="btn btn-outline-secondary btn-sm" 
                                                   title="Voir la fiche adhérent complète">
                                                    <i class="bx bx-user"></i>
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Modale Synthèse Globale du Profilage -->
                                        <div id="syntheseModal{{ $candidat->id }}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title text-white">
                                                            <i class="bx bx-history me-2"></i>
                                                            Synthèse du profilage &bull; {{ $candidat->user ? $candidat->user->fullName() : 'Candidat' }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <!-- Identité -->
                                                        <div class="bg-light p-3 rounded-3 mb-3 border">
                                                            <div class="row g-2">
                                                                <div class="col-sm-6">
                                                                    <div class="text-muted small">Nom & Prénoms :</div>
                                                                    <div class="fw-bold text-dark">{{ $candidat->user ? $candidat->user->fullName() : '-' }}</div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="text-muted small">Matricule Mécano :</div>
                                                                    <div class="fw-bold">{{ $candidat->user->mecano ?? 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="text-muted small">Contact :</div>
                                                                    <div class="fw-bold">{{ $candidat->phone_number ?? '-' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Timeline / Résumé des 3 étapes -->
                                                        <div class="row g-3">
                                                            <!-- Étape 1 : Entretien -->
                                                            <div class="col-12 col-md-6">
                                                                <div class="card h-100 border shadow-none">
                                                                    <div class="card-header bg-light py-2 fw-semibold d-flex justify-content-between align-items-center">
                                                                        <span><i class="bx bx-conversation text-primary me-1"></i> RDV 1 : Entretien</span>
                                                                        @if ($dernierEntretien && $dernierEntretien->presence == 1)
                                                                            <span class="badge bg-success">Validé</span>
                                                                        @elseif ($dernierEntretien && ($dernierEntretien->presence === 0 || $dernierEntretien->presence === '0'))
                                                                            <span class="badge bg-danger">Absent</span>
                                                                        @else
                                                                            <span class="badge bg-secondary">Non complété</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="card-body py-2 small">
                                                                        @if ($dernierEntretien)
                                                                            <div class="mb-1"><strong>Date :</strong> {{ $dernierEntretien->entretien ? dateFr($dernierEntretien->entretien->date, 'letter') : '-' }}</div>
                                                                            <div class="mb-1"><strong>Type :</strong> {{ $dernierEntretien->entretien && $dernierEntretien->entretien->type == 'collectif' ? 'Session Collective' : 'Entretien Individuel' }}</div>
                                                                            <div class="mb-1"><strong>Observations :</strong></div>
                                                                            <div class="bg-light p-2 rounded border text-muted" style="min-height: 50px;">
                                                                                {{ $dernierEntretien->comment ?: 'Aucune observation enregistrée.' }}
                                                                            </div>
                                                                        @else
                                                                            <div class="text-muted text-center py-3">Aucun entretien enregistré</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Étape 2 : Bilan de compétences -->
                                                            <div class="col-12 col-md-6">
                                                                <div class="card h-100 border shadow-none">
                                                                    <div class="card-header bg-light py-2 fw-semibold d-flex justify-content-between align-items-center">
                                                                        <span><i class="bx bx-chart text-primary me-1"></i> RDV 2 : Bilan</span>
                                                                        @if ($dernierBilan && $dernierBilan->presence == 1)
                                                                            <span class="badge bg-success">Validé</span>
                                                                        @elseif ($dernierBilan && ($dernierBilan->presence === 0 || $dernierBilan->presence === '0'))
                                                                            <span class="badge bg-danger">Absent</span>
                                                                        @else
                                                                            <span class="badge bg-secondary">Non complété</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="card-body py-2 small">
                                                                        @if ($dernierBilan)
                                                                            <div class="mb-1"><strong>Date :</strong> {{ dateFr($dernierBilan->date, 'letter') }}</div>
                                                                            <div class="mb-1"><strong>Observations / Compte-rendu :</strong></div>
                                                                            <div class="bg-light p-2 rounded border text-muted" style="min-height: 50px;">
                                                                                {{ $dernierBilan->comment ?: 'Aucune observation enregistrée.' }}
                                                                            </div>
                                                                        @else
                                                                            <div class="text-muted text-center py-3">Aucun bilan enregistré</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Étape 3 : Orientation & Décision -->
                                                            <div class="col-12">
                                                                <div class="card border shadow-none">
                                                                    <div class="card-header bg-light py-2 fw-semibold">
                                                                        <i class="bx bx-gavel text-primary me-1"></i> RDV 3 : Orientation & Décision finale
                                                                    </div>
                                                                    <div class="card-body py-3 small">
                                                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                                            <div>
                                                                                <span class="text-muted d-block">Orientation actuelle :</span>
                                                                                <span class="fw-bold text-dark fs-6">
                                                                                    {{ strtoupper(str_replace('-', ' ', $candidat->orientation)) }}
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                @if ($candidat->orientation === 'entreprise-privee')
                                                                                    <span class="badge bg-success fs-6 px-3 py-2">Confirmé en Entreprise Privée</span>
                                                                                @elseif ($candidat->orientation === 'auto-emploi')
                                                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Réorienté vers Auto-Emploi</span>
                                                                                @elseif ($candidat->orientation === 'fonction-publique')
                                                                                    <span class="badge bg-info fs-6 px-3 py-2">Réorienté vers Fonction Publique</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="bx bx-x me-1"></i> Fermer
                                                        </button>
                                                        @if ($candidat->user)
                                                            <a href="{{ route('adherent.show', $candidat->user->id) }}" class="btn btn-primary">
                                                                <i class="bx bx-user me-1"></i> Fiche complète
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bx bx-folder-open fs-2 d-block mb-2"></i>
                                        Aucun historique de profilage disponible.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
