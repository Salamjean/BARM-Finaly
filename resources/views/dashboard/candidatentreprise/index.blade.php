@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush

    <div class="container-fluid flex-grow-1 container-p-y px-4">
        <!-- Breadcrumb & Barre d'actions -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-briefcase text-primary fs-3 me-3"></i>
                        <div>
                            <div class="text-muted small">Insertion & Placement professionnel</div>
                            <h4 class="mb-0 text-primary fw-bold">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto d-flex align-items-center gap-2">
                @if (can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                    <a href="{{ route('candidatentreprises.mise_a_disposition') }}" class="btn btn-primary shadow-sm">
                        <i class="bx bx-plus me-1"></i>
                        Nouvelle Mise à disposition
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

        <!-- Indicateurs de Synthèse -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-primary text-primary me-3">
                            <i class="bx bx-group fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $candidatentreprises->count() }}</h4>
                            <small class="text-muted">Total Propositions</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-warning text-warning me-3">
                            <i class="bx bx-send fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-warning">{{ $envoyes->count() }}</h4>
                            <small class="text-muted">Envoi en entreprise (En cours)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-success text-success me-3">
                            <i class="bx bx-check-circle fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-success">{{ $integres->count() }}</h4>
                            <small class="text-muted">Candidats Intégrés (Acceptés)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-light-info text-info me-3">
                            <i class="bx bx-buildings fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-info">{{ $candidatentreprises->unique('entreprise')->count() }}</h4>
                            <small class="text-muted">Entreprises partenaires</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $currentTab = $activeTab ?? request('tab', 'envoi');
        @endphp

        <!-- Navigation par Sous-onglets -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom p-3">
                <ul class="nav nav-pills nav-fill gap-2" id="madTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $currentTab === 'envoi' ? 'active' : '' }} fw-semibold py-2 px-3 d-flex align-items-center justify-content-center gap-2" 
                                id="envoi-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#envoi-pane" 
                                type="button" 
                                role="tab"
                                aria-controls="envoi-pane"
                                aria-selected="{{ $currentTab === 'envoi' ? 'true' : 'false' }}">
                            <i class="bx bx-send fs-5"></i>
                            <span>1. Envoi en entreprise</span>
                            <span class="badge bg-warning text-dark rounded-pill ms-1">{{ $envoyes->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $currentTab === 'integre' ? 'active' : '' }} fw-semibold py-2 px-3 d-flex align-items-center justify-content-center gap-2" 
                                id="integre-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#integre-pane" 
                                type="button" 
                                role="tab"
                                aria-controls="integre-pane"
                                aria-selected="{{ $currentTab === 'integre' ? 'true' : 'false' }}">
                            <i class="bx bx-check-shield fs-5 text-success"></i>
                            <span>2. Intégrer (Acceptés)</span>
                            <span class="badge bg-success rounded-pill ms-1">{{ $integres->count() }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="madTabContent">
                    
                    <!-- ========================================================================= -->
                    <!-- SOUS-ONGLET 1 : ENVOI EN ENTREPRISE (LISTE DES ENTREPRISES)               -->
                    <!-- ========================================================================= -->
                    <div class="tab-pane fade {{ $currentTab === 'envoi' ? 'show active' : '' }}" id="envoi-pane" role="tabpanel" aria-labelledby="envoi-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">
                                    <i class="bx bx-paper-plane text-warning me-2"></i> Liste des entreprises - Envois de candidats
                                </h5>
                                <p class="text-muted small mb-0">Sélectionnez une entreprise pour ouvrir et consulter la liste des candidats qui lui ont été envoyés.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="dt-responsive table table-striped table-hover align-middle" id="datatable-envoi" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 35%;">Entreprise / Structure</th>
                                        <th style="width: 25%;">Date de mise à disposition</th>
                                        <th style="width: 20%;">Candidats envoyés</th>
                                        <th style="width: 15%;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($entreprisesEnvoi as $item)
                                        <tr>
                                            <td class="text-muted">{{ $loop->index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="p-2 bg-light-warning text-warning rounded-3 me-3">
                                                        <i class="bx bx-buildings fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark fs-6">{{ $item['entreprise'] }}</div>
                                                        <small class="text-muted">Entreprise partenaire</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-calendar text-primary me-2 fs-5"></i>
                                                    <span class="fw-medium text-dark">{{ dateFr($item['date_mise_disposition'], 'letter') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                                        <i class="bx bx-send me-1"></i> {{ $item['total'] }} candidat(s)
                                                    </span>
                                                    @if ($item['pending'] > 0)
                                                        <span class="badge bg-light-warning text-dark border px-2 py-1 rounded-pill small">
                                                            {{ $item['pending'] }} en attente
                                                        </span>
                                                    @endif
                                                    @if ($item['refused'] > 0)
                                                        <span class="badge bg-danger px-2 py-1 rounded-pill small">
                                                            {{ $item['refused'] }} refusé(s)
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('candidatentreprises.show', [$item['entreprise'], $item['date_mise_disposition'], 'type' => 'envoi']) }}" 
                                                   class="btn btn-primary btn-sm shadow-sm"
                                                   title="Ouvrir l'entreprise pour voir les candidats">
                                                    <i class="bx bx-folder-open me-1"></i> Ouvrir
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bx bx-send fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <h6 class="fw-bold mb-1">Aucune entreprise avec des envois de candidats</h6>
                                                <small class="text-muted">Cliquez sur « Nouvelle Mise à disposition » pour affecter des candidats.</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- SOUS-ONGLET 2 : INTÉGRÉS (LISTE DES ENTREPRISES D'ACCUEIL)                -->
                    <!-- ========================================================================= -->
                    <div class="tab-pane fade {{ $currentTab === 'integre' ? 'show active' : '' }}" id="integre-pane" role="tabpanel" aria-labelledby="integre-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">
                                    <i class="bx bx-check-shield text-success me-2"></i> Liste des entreprises - Candidats intégrés (En poste)
                                </h5>
                                <p class="text-muted small mb-0">Sélectionnez une entreprise pour ouvrir et consulter la liste des candidats actuellement en poste et acceptés.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="dt-responsive table table-striped table-hover align-middle" id="datatable-integre" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 35%;">Entreprise d'accueil</th>
                                        <th style="width: 25%;">Date de mise à disposition</th>
                                        <th style="width: 20%;">Candidats intégrés</th>
                                        <th style="width: 15%;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($entreprisesIntegres as $integre)
                                        <tr>
                                            <td class="text-muted">{{ $loop->index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="p-2 bg-light-success text-success rounded-3 me-3">
                                                        <i class="bx bx-buildings fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark fs-6">{{ $integre['entreprise'] }}</div>
                                                        <small class="text-muted">Entreprise d'accueil</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-calendar text-success me-2 fs-5"></i>
                                                    <span class="fw-medium text-dark">{{ dateFr($integre['date_mise_disposition'], 'letter') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                                    <i class="bx bx-check-circle me-1"></i> {{ $integre['total'] }} intégré(s) en poste
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('candidatentreprises.show', [$integre['entreprise'], $integre['date_mise_disposition'], 'type' => 'integre']) }}" 
                                                   class="btn btn-success btn-sm shadow-sm"
                                                   title="Ouvrir l'entreprise pour voir les candidats intégrés">
                                                    <i class="bx bx-folder-open me-1"></i> Ouvrir
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bx bx-check-shield fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <h6 class="fw-bold mb-1">Aucune entreprise avec des candidats intégrés</h6>
                                                <small class="text-muted">Les candidats dont la proposition est validée comme « Acceptée » apparaîtront ici par entreprise.</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            (function($) {
                "use strict";

                if ($('#datatable-envoi').length) {
                    $('#datatable-envoi').DataTable({
                        responsive: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                        }
                    });
                }

                if ($('#datatable-integre').length) {
                    $('#datatable-integre').DataTable({
                        responsive: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                        }
                    });
                }
            })(jQuery);
        </script>
    @endpush
@endsection
