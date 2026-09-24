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
                        <i class="bx bx-briefcase-alt-2 text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Prépa à l'insertion</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec indicateurs de synthèse -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-primary text-primary me-3">
                            <i class="bx bx-group fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $candidats->count() }}</h4>
                            <small class="text-muted">Total Candidats</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-success text-success me-3">
                            <i class="bx bx-check-circle fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-success">
                                {{ $candidats->filter(function ($c) {
                                    $last = $c->techrechercheemplois->first();
                                    return $last && (int)$last->presence === 1;
                                })->count() }}
                            </h4>
                            <small class="text-muted">TRE Réalisées</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-warning text-warning me-3">
                            <i class="bx bx-time-five fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-warning">
                                {{ $candidats->filter(function ($c) {
                                    $last = $c->techrechercheemplois->first();
                                    return !$last || (int)$last->presence === 0;
                                })->count() }}
                            </h4>
                            <small class="text-muted">En attente / Non fait</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light text-dark me-3" style="background-color: #fff3e0 !important; color: #ff9800 !important;">
                            <i class="bx bx-log-out-circle fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold" style="color: #ff9800;">
                                {{ $candidats->filter(function ($c) {
                                    $last = $c->techrechercheemplois->first();
                                    return $last && (int)$last->presence === 2;
                                })->count() }}
                            </h4>
                            <small class="text-muted">Abandons</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Candidat</th>
                                <th class="text-center">Prérequis validés</th>
                                <th>Date TRE</th>
                                <th>Statut</th>
                                <th>Observations</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidats as $candidat)
                                @php
                                    $dernierTre = $candidat->techrechercheemplois->first();
                                @endphp
                                <tr class="align-middle">
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</div>
                                        <div class="small text-muted">
                                            <span class="badge bg-secondary me-1">{{ $candidat->user->mecano ?? 'N/A' }}</span>
                                            <span>{{ $candidat->phone_number ?? ($candidat->user->phone ?? '') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <span class="badge bg-success" title="Nombre de documents CV/LM">
                                                <i class="bx bx-check me-1"></i> CV/LM ({{ $candidat->cvlms->count() }})
                                            </span>
                                            <span class="badge bg-primary" title="Nombre de préparations d'entretien">
                                                <i class="bx bx-check me-1"></i> Prépa ({{ $candidat->prepaentretiens->count() }})
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($dernierTre && $dernierTre->date)
                                            <span class="fw-semibold text-dark">{{ dateFr($dernierTre->date, 'letter') }}</span>
                                        @else
                                            <span class="badge bg-light text-muted border">Non définie</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$dernierTre)
                                            <span class="badge bg-secondary">
                                                <i class="bx bx-time me-1"></i> En attente
                                            </span>
                                        @elseif ((int)$dernierTre->presence === 1)
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i> Réalisé / Fait
                                            </span>
                                        @elseif ((int)$dernierTre->presence === 2)
                                            <span class="badge bg-warning text-dark" style="background-color: #ff9800 !important; color: white !important;">
                                                <i class="bx bx-log-out-circle me-1"></i> Abandon
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bx bx-x-circle me-1"></i> Non réalisé / Absent
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($dernierTre && $dernierTre->commentaire)
                                            <div class="small text-secondary text-truncate" style="max-width: 250px;" title="{{ $dernierTre->commentaire }}">
                                                <i class="bx bx-comment-detail me-1 text-primary"></i> {{ $dernierTre->commentaire }}
                                            </div>
                                        @else
                                            <small class="text-muted">Aucun commentaire</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                            <!-- Bouton Pop-up Clôture TRE -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary shadow-sm"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#treModal{{ $candidat->id }}"
                                                    title="Clôturer ou mettre à jour la technique de recherche d'emploi">
                                                <i class="bx bx-check-shield me-1"></i> Clôturer TRE
                                            </button>

                                            <!-- Bouton Dossier (Synthèse parcours) -->
                                            <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->id) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="Voir le dossier / parcours du candidat">
                                                <i class="bx bx-folder-open me-1"></i> Dossier
                                            </a>

                                            <!-- Bouton Profil Adhérent -->
                                            @if ($candidat->user)
                                                <a href="{{ route('adherent.show', $candidat->user->id) }}" 
                                                   class="btn btn-sm btn-outline-secondary" 
                                                   title="Fiche adhérent">
                                                    <i class="bx bx-user"></i>
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Modal Pop-up Clôture TRE pour ce candidat -->
                                        <div class="modal fade" id="treModal{{ $candidat->id }}" tabindex="-1" aria-labelledby="treModalLabel{{ $candidat->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title text-white" id="treModalLabel{{ $candidat->id }}">
                                                            <i class="bx bx-briefcase-alt-2 me-1"></i> Clôturer TRE : {{ $candidat->user ? $candidat->user->fullName() : 'Candidat' }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('techrechercheemplois.cloturer') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="candidature_id" value="{{ $candidat->id }}">
                                                        
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">
                                                                    <i class="bx bx-calendar me-1 text-primary"></i> Date de réalisation <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="date" 
                                                                       name="date" 
                                                                       class="form-control" 
                                                                       value="{{ $dernierTre && $dernierTre->date ? $dernierTre->date->format('Y-m-d') : date('Y-m-d') }}" 
                                                                       required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">
                                                                    <i class="bx bx-check-circle me-1 text-primary"></i> Statut de la TRE <span class="text-danger">*</span>
                                                                </label>
                                                                <select name="presence" class="form-select" required>
                                                                    <option value="1" {{ $dernierTre && (int)$dernierTre->presence === 1 ? 'selected' : '' }}>
                                                                        🟢 Réalisé / Fait (Présent)
                                                                    </option>
                                                                    <option value="0" {{ $dernierTre && (int)$dernierTre->presence === 0 ? 'selected' : '' }}>
                                                                        🔴 Non réalisé / Absent
                                                                    </option>
                                                                    <option value="2" {{ $dernierTre && (int)$dernierTre->presence === 2 ? 'selected' : '' }}>
                                                                        🟠 Abandon
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">
                                                                    <i class="bx bx-comment-dots me-1 text-primary"></i> Commentaires & Observations
                                                                </label>
                                                                <textarea name="commentaire" 
                                                                          class="form-control" 
                                                                          rows="4" 
                                                                          placeholder="Précisez les conclusions, les points abordés ou les motifs...">{{ $dernierTre ? $dernierTre->commentaire : '' }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer bg-light">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                                                <i class="bx bx-save me-1"></i> Enregistrer la clôture
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bx bx-info-circle fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        <p class="mb-1 fw-bold">Aucun candidat éligible pour la Technique de Recherche d'Emploi</p>
                                        <small class="text-muted">Pour apparaître sur cette page, les candidats doivent d'abord avoir validé les étapes <strong>CV & LM</strong> ainsi que la <strong>Préparation aux entretiens</strong>.</small>
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
