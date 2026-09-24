@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
        <style>
            .stat-kpi-card {
                border-radius: 14px;
                border: 1px solid rgba(0,0,0,0.06);
                transition: all 0.25s ease;
                background: #fff;
            }
            .stat-kpi-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
            }
            .kpi-icon-wrapper {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
            }
            .funnel-step {
                position: relative;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 16px;
                transition: all 0.2s ease;
                min-width: 140px;
            }
            .funnel-step:hover {
                border-color: #3b82f6;
                box-shadow: 0 4px 12px rgba(59, 130, 246, 0.12);
            }
            .funnel-arrow {
                display: flex;
                align-items: center;
                justify-content: center;
                color: #94a3b8;
                font-size: 22px;
            }
            .progress-thin {
                height: 6px;
                border-radius: 4px;
            }
            .card-header-gradient {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                border-bottom: 1px solid #e2e8f0;
            }
            .nav-pills-custom .nav-link {
                color: #475569;
                font-weight: 600;
                padding: 12px 24px;
                border-radius: 10px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                transition: all 0.2s ease;
            }
            .nav-pills-custom .nav-link.active {
                background: #0284c7;
                color: #ffffff;
                border-color: #0284c7;
                box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
            }
            .badge-subtle-success {
                background-color: #ecfdf5 !important;
                color: #047857 !important;
                border: 1px solid #a7f3d0 !important;
            }
            .badge-subtle-warning {
                background-color: #fffbeb !important;
                color: #b45309 !important;
                border: 1px solid #fde68a !important;
            }
            .badge-subtle-info {
                background-color: #eff6ff !important;
                color: #1d4ed8 !important;
                border: 1px solid #bfdbfe !important;
            }
            .badge-subtle-secondary {
                background-color: #f1f5f9 !important;
                color: #475569 !important;
                border: 1px solid #cbd5e1 !important;
            }
            .badge-subtle-danger {
                background-color: #fef2f2 !important;
                color: #b91c1c !important;
                border: 1px solid #fecaca !important;
            }
            .badge-subtle-dark {
                background-color: #f8fafc !important;
                color: #334155 !important;
                border: 1px solid #cbd5e1 !important;
            }
            .badge-gender-homme {
                background-color: #e0f2fe !important;
                color: #0369a1 !important;
                border: 1px solid #bae6fd !important;
                font-weight: 700 !important;
            }
            .badge-gender-femme {
                background-color: #fce7f3 !important;
                color: #be185d !important;
                border: 1px solid #fbcfe8 !important;
                font-weight: 700 !important;
            }
            .pill-indicator {
                font-size: 11px;
                padding: 2px 7px;
                border-radius: 6px;
                display: inline-block;
                font-weight: 600;
            }
            .kpi-icon-primary { background: #e0f2fe !important; color: #0369a1 !important; }
            .kpi-icon-info { background: #eff6ff !important; color: #1d4ed8 !important; }
            .kpi-icon-warning { background: #fef3c7 !important; color: #b45309 !important; }
            .kpi-icon-secondary { background: #f1f5f9 !important; color: #334155 !important; }
            .kpi-icon-success { background: #dcfce7 !important; color: #15803d !important; }
            .kpi-icon-danger { background: #fee2e2 !important; color: #b91c1c !important; }
            .badge-solid-primary {
                background-color: #0284c7 !important;
                color: #ffffff !important;
                font-weight: 700;
            }
            .badge-solid-success {
                background-color: #16a34a !important;
                color: #ffffff !important;
                font-weight: 700;
            }
            .badge-solid-warning {
                background-color: #f59e0b !important;
                color: #0f172a !important;
                font-weight: 700;
            }
            .badge-solid-danger {
                background-color: #dc2626 !important;
                color: #ffffff !important;
                font-weight: 700;
            }
            .badge-solid-secondary {
                background-color: #475569 !important;
                color: #ffffff !important;
                font-weight: 700;
            }
        </style>
    @endpush

    <div class="container-fluid py-2">
        <!-- En-tête & Fil d'ariane -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div class="border-start border-primary border-4 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user-pin text-primary fs-3 me-2"></i>
                        <div>
                            <div class="text-muted small fw-medium">Entreprise Privée &bull; Espace Conseiller</div>
                            <h4 class="mb-0 text-primary fw-bold">Suivi des Candidats</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 no-print">
                <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" onclick="window.print()">
                    <i class="bx bx-printer me-1"></i> Imprimer
                </button>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" onclick="exportToPDF('suivi-candidats-ep')">
                    <i class="bx bx-download me-1"></i> Exporter en PDF
                </button>
            </div>
        </div>

        <!-- Filtres dynamiques -->
        <div class="card border-0 shadow-sm mb-4 no-print">
            <div class="card-body p-3">
                <form action="{{ route('candidatentreprises.suivie_ep_candidats') }}" method="GET" class="row g-2 align-items-end">
                    <input type="hidden" name="tab" id="inputActiveTab" value="{{ $activeTab }}">
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label small fw-semibold text-muted mb-1">Cohorte</label>
                        <select name="cohort_id" class="form-select form-select-sm">
                            <option value="">Toutes les cohortes</option>
                            @foreach ($cohortes as $c)
                                <option value="{{ $c->id }}" {{ $selectedCohort == $c->id ? 'selected' : '' }}>
                                    {{ $c->title }} ({{ $c->reference }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label small fw-semibold text-muted mb-1">Entreprise Partenaire</label>
                        <select name="entreprise" class="form-select form-select-sm">
                            <option value="">Toutes les entreprises</option>
                            @foreach ($allEntreprises as $ent)
                                <option value="{{ $ent->nom }}" {{ $selectedEntreprise == $ent->nom ? 'selected' : '' }}>
                                    {{ $ent->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <label class="form-label small fw-semibold text-muted mb-1">Date Début</label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <label class="form-label small fw-semibold text-muted mb-1">Date Fin</label>
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 col-sm-12 d-flex gap-1">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 shadow-sm">
                            <i class="bx bx-filter-alt me-1"></i> Filtrer
                        </button>
                        @if($selectedCohort || $selectedEntreprise || $dateFrom || $dateTo)
                            <a href="{{ route('candidatentreprises.suivie_ep_candidats', ['tab' => $activeTab]) }}" class="btn btn-outline-secondary btn-sm" title="Réinitialiser">
                                <i class="bx bx-reset"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </di        <!-- Système d'onglets (Navigation entre Statistiques globales et Liste individuelle) -->
        <ul class="nav nav-pills nav-pills-custom gap-2 mb-4" id="suiviTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'stats' ? 'active' : '' }}" 
                        id="tab-stats-btn" 
                        data-bs-toggle="pill" 
                        data-bs-target="#tab-stats" 
                        type="button" 
                        role="tab" 
                        aria-controls="tab-stats" 
                        aria-selected="{{ $activeTab === 'stats' ? 'true' : 'false' }}"
                        onclick="document.getElementById('inputActiveTab').value='stats'">
                    <i class="bx bx-bar-chart-alt-2 fs-5 align-middle me-2"></i>
                    <span>Statistiques Globales</span>
                    <span class="badge {{ $activeTab === 'stats' ? 'bg-white text-primary' : 'bg-light text-secondary border' }} ms-2 rounded-pill px-2">
                        Synthèse & KPI
                    </span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'liste' ? 'active' : '' }}" 
                        id="tab-liste-btn" 
                        data-bs-toggle="pill" 
                        data-bs-target="#tab-liste" 
                        type="button" 
                        role="tab" 
                        aria-controls="tab-liste" 
                        aria-selected="{{ $activeTab === 'liste' ? 'true' : 'false' }}"
                        onclick="document.getElementById('inputActiveTab').value='liste'">
                    <i class="bx bx-list-check fs-5 align-middle me-2"></i>
                    <span>Liste & Suivi Individuel des Candidats</span>
                    <span class="badge {{ $activeTab === 'liste' ? 'bg-white text-primary' : 'bg-primary text-white' }} ms-2 rounded-pill px-2">
                        {{ $candidats->count() }}
                    </span>
                </button>
            </li>
        </ul>

        <!-- Contenu des onglets -->
        <div class="tab-content" id="suiviTabsContent">

            <!-- ========================================================================= -->
            <!-- ONGLET 1 : STATISTIQUES GLOBALES & SYNTHÈSE CHIFFRÉE -->
            <!-- ========================================================================= -->
            <div class="tab-pane fade {{ $activeTab === 'stats' ? 'show active' : '' }}" id="tab-stats" role="tabpanel" aria-labelledby="tab-stats-btn">

                <!-- 6 KPI Principaux -->
                <div class="row g-3 mb-4">
                    <!-- 1. Total Orientés EP -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Orientés EP</span>
                                <div class="kpi-icon-wrapper kpi-icon-primary shadow-sm">
                                    <i class="bx bx-user-pin"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">{{ number_format($totalCandidats, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span><i class="bx bx-male text-primary"></i> {{ $totalHommes }} ({{ $totalCandidats > 0 ? round(($totalHommes / $totalCandidats) * 100) : 0 }}%)</span>
                                <span><i class="bx bx-female text-danger"></i> {{ $totalFemmes }} ({{ $totalCandidats > 0 ? round(($totalFemmes / $totalCandidats) * 100) : 0 }}%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Profilés Validés -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Profilés Validés</span>
                                <div class="kpi-icon-wrapper kpi-icon-info shadow-sm">
                                    <i class="bx bx-check-shield"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-info mb-1">{{ number_format($rdv3Valides, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>En attente RDV 3 : <strong>{{ $rdv3Eligibles }}</strong></span>
                                <span class="badge badge-subtle-info">{{ $tauxProfilage }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Préparés & Formés -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Préparés / Formés</span>
                                <div class="kpi-icon-wrapper kpi-icon-warning shadow-sm">
                                    <i class="bx bx-briefcase-alt"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: #b45309;">{{ number_format($beneficiairesPrepa, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>CV: {{ $cvlmCount }} | Form: {{ $formationCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Mis à Disposition -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Mises à Disposition</span>
                                <div class="kpi-icon-wrapper kpi-icon-secondary shadow-sm">
                                    <i class="bx bx-send"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-secondary mb-1">{{ number_format($madTotal, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>{{ $madCandidatsUniques }} candidats uniques</span>
                                <span class="badge badge-subtle-warning">{{ $madPending }} att.</span>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Candidats Acceptés / En Poste -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Acceptés / En Poste</span>
                                <div class="kpi-icon-wrapper kpi-icon-success shadow-sm">
                                    <i class="bx bx-user-check"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-success mb-1">{{ number_format($enPosteCount, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>Acceptés ent: <strong>{{ $madAcceptes }}</strong></span>
                                <span class="badge badge-solid-success">{{ $madAcceptes }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Taux d'Insertion Global -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-color: #93c5fd;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-primary small fw-bold">Taux d'Insertion</span>
                                <div class="kpi-icon-wrapper bg-primary text-white shadow-sm">
                                    <i class="bx bx-line-chart"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-primary mb-1">{{ $tauxInsertion }}%</h3>
                            <div class="progress progress-thin bg-white mb-1">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, $tauxInsertion) }}%"></div>
                            </div>
                            <div class="text-muted small text-end" style="font-size: 10px;">
                                Taux accept. MAD: <strong>{{ $tauxRecrutementMAD }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pipeline / Tunnel de progression des candidats -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-git-merge text-primary fs-4 me-2"></i>
                                <h6 class="mb-0 fw-bold text-dark">Tunnel d'avancement & Conversion du parcours candidat</h6>
                            </div>
                            <span class="badge bg-light text-secondary border">Flux temps réel</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-2 align-items-center text-center">
                            <!-- Étape 1 : Orientation -->
                            <div class="col-lg col-md-4 col-6">
                                <div class="funnel-step h-100">
                                    <span class="badge badge-solid-primary mb-2">1. Orientation EP</span>
                                    <h4 class="fw-bold text-dark mb-1">{{ $totalCandidats }}</h4>
                                    <small class="text-muted d-block">100% des inscrits</small>
                                    <div class="progress progress-thin mt-2">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto d-none d-lg-block funnel-arrow">
                                <i class="bx bx-right-arrow-alt"></i>
                            </div>

                            <!-- Étape 2 : RDV 1 Entretien -->
                            <div class="col-lg col-md-4 col-6">
                                <div class="funnel-step h-100">
                                    <span class="badge badge-subtle-info mb-2">2. RDV 1 Entretien</span>
                                    <h4 class="fw-bold text-info mb-1">{{ $rdv1Count }}</h4>
                                    <small class="text-muted d-block">
                                        {{ $totalCandidats > 0 ? round(($rdv1Count / $totalCandidats) * 100) : 0 }}% réalisés
                                    </small>
                                    <div class="progress progress-thin mt-2">
                                        <div class="progress-bar bg-info" style="width: {{ $totalCandidats > 0 ? ($rdv1Count / $totalCandidats) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto d-none d-lg-block funnel-arrow">
                                <i class="bx bx-right-arrow-alt"></i>
                            </div>

                            <!-- Étape 3 : RDV 2 Bilan -->
                            <div class="col-lg col-md-4 col-6">
                                <div class="funnel-step h-100">
                                    <span class="badge badge-subtle-secondary mb-2">3. RDV 2 Bilan</span>
                                    <h4 class="fw-bold text-secondary mb-1">{{ $rdv2Count }}</h4>
                                    <small class="text-muted d-block">
                                        {{ $totalCandidats > 0 ? round(($rdv2Count / $totalCandidats) * 100) : 0 }}% bilans validés
                                    </small>
                                    <div class="progress progress-thin mt-2">
                                        <div class="progress-bar bg-secondary" style="width: {{ $totalCandidats > 0 ? ($rdv2Count / $totalCandidats) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto d-none d-lg-block funnel-arrow">
                                <i class="bx bx-right-arrow-alt"></i>
                            </div>

                            <!-- Étape 4 : RDV 3 Décision -->
                            <div class="col-lg col-md-4 col-6">
                                <div class="funnel-step h-100">
                                    <span class="badge badge-solid-warning mb-2">4. RDV 3 Décision</span>
                                    <h4 class="fw-bold mb-1" style="color: #b45309;">{{ $rdv3Valides }}</h4>
                                    <small class="text-muted d-block">
                                        {{ $rdv3Eligibles }} en attente
                                    </small>
                                    <div class="progress progress-thin mt-2">
                                        <div class="progress-bar bg-warning" style="width: {{ $totalCandidats > 0 ? ($rdv3Valides / $totalCandidats) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto d-none d-lg-block funnel-arrow">
                                <i class="bx bx-right-arrow-alt"></i>
                            </div>

                            <!-- Étape 5 : Mise à disposition -->
                            <div class="col-lg col-md-4 col-6">
                                <div class="funnel-step h-100">
                                    <span class="badge badge-subtle-dark mb-2">5. Mis à disposition</span>
                                    <h4 class="fw-bold text-dark mb-1">{{ $madCandidatsUniques }}</h4>
                                    <small class="text-muted d-block">
                                        {{ $madTotal }} envois réalisés
                                    </small>
                                    <div class="progress progress-thin mt-2">
                                        <div class="progress-bar bg-dark" style="width: {{ $totalCandidats > 0 ? ($madCandidatsUniques / $totalCandidats) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto d-none d-lg-block funnel-arrow">
                                <i class="bx bx-right-arrow-alt"></i>
                            </div>

                            <!-- Étape 6 : En poste -->
                            <div class="col-lg col-md-4 col-6">
                                <div class="funnel-step h-100" style="border-color: #10b981; background: #f0fdf4;">
                                    <span class="badge badge-solid-success mb-2">6. En Poste</span>
                                    <h4 class="fw-bold text-success mb-1">{{ $enPosteCount }}</h4>
                                    <small class="text-success fw-semibold d-block">
                                        {{ $tauxInsertion }}% insérés
                                    </small>
                                    <div class="progress progress-thin mt-2">
                                        <div class="progress-bar bg-success" style="width: {{ min(100, $tauxInsertion) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <!-- Modules de Préparation à l'insertion & Formation -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-chalkboard text-primary fs-4 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark">Modules de Préparation & Formations</h6>
                                    </div>
                                    <span class="badge bg-primary">{{ $beneficiairesPrepa }} Bénéficiaires</span>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-3">
                                    <!-- CV et LM -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-file"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">CV & LM</span>
                                                </div>
                                                <span class="badge bg-primary fs-6">{{ $cvlmCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">Candidats ayant rédigé ou optimisé leur CV et lettre.</p>
                                            <a href="{{ route('cvlms.candidats') }}" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="bx bx-list-ul me-1"></i> Voir la liste
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Prépa-Entretien -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-info text-white rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-conversation"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">Prépa-Entretien</span>
                                                </div>
                                                <span class="badge bg-info fs-6">{{ $prepaCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">Simulations et préparation aux entretiens d'embauche.</p>
                                            <a href="{{ route('prepaentretiens.candidats') }}" class="btn btn-outline-info btn-sm w-100">
                                                <i class="bx bx-list-ul me-1"></i> Voir la liste
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Technique Recherche Emploi (TRE) -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-warning text-dark rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-search-alt"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">Tech Recherche Emploi</span>
                                                </div>
                                                <span class="badge bg-warning text-dark fs-6">{{ $treCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">Ateliers TRE et prospection ciblée.</p>
                                            <a href="{{ route('techrechercheemplois.candidats') }}" class="btn btn-outline-warning btn-sm w-100 text-dark">
                                                <i class="bx bx-list-ul me-1"></i> Voir la liste
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Formations Professionnelles -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-success text-white rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-book-reader"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">Formations Spécialisées</span>
                                                </div>
                                                <span class="badge bg-success fs-6">{{ $formationCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">Formations qualifiantes et renforcement de capacités.</p>
                                            <a href="{{ route('formations.index') }}" class="btn btn-outline-success btn-sm w-100">
                                                <i class="bx bx-list-ul me-1"></i> Voir formations
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Répartition Démographie & Contrats -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-pie-chart-alt-2 text-primary fs-4 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark">Démographie & Répartition des contrats</h6>
                                    </div>
                                    <span class="badge bg-light text-secondary border">Détails</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <!-- Genre -->
                                    <div class="col-sm-6">
                                        <h6 class="fw-semibold text-muted small text-uppercase mb-3">Répartition par Genre</h6>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span class="fw-semibold"><i class="bx bx-male text-primary"></i> Hommes</span>
                                                <span>{{ $totalHommes }} ({{ $totalCandidats > 0 ? round(($totalHommes / $totalCandidats) * 100, 1) : 0 }}%)</span>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-primary" style="width: {{ $totalCandidats > 0 ? ($totalHommes / $totalCandidats) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span class="fw-semibold"><i class="bx bx-female text-danger"></i> Femmes</span>
                                                <span>{{ $totalFemmes }} ({{ $totalCandidats > 0 ? round(($totalFemmes / $totalCandidats) * 100, 1) : 0 }}%)</span>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" style="width: {{ $totalCandidats > 0 ? ($totalFemmes / $totalCandidats) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contrats -->
                                    <div class="col-sm-6">
                                        <h6 class="fw-semibold text-muted small text-uppercase mb-3">Types de Contrats Signés</h6>
                                        @forelse ($contratsStats as $c)
                                            <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                                <span class="fw-semibold text-dark small">
                                                    <i class="bx bx-file-blank text-primary me-1"></i> {{ $c->type_contrat }}
                                                </span>
                                                <span class="badge bg-primary rounded-pill">{{ $c->count }}</span>
                                            </div>
                                        @empty
                                            <div class="text-center py-3 text-muted small">
                                                <i class="bx bx-info-circle fs-3 d-block mb-1 opacity-50"></i>
                                                En cours de formalisation
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Statut Mises à disposition -->
                                <hr class="my-4">
                                <div class="row text-center g-3">
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #16a34a !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-success mb-1">
                                                <i class="bx bx-check-circle fs-5"></i>
                                                <span class="small fw-bold">Acceptés / Retenus</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $madAcceptes }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #f59e0b !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 mb-1" style="color: #b45309;">
                                                <i class="bx bx-time-five fs-5"></i>
                                                <span class="small fw-bold">En attente retour</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $madPending }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #dc2626 !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-danger mb-1">
                                                <i class="bx bx-x-circle fs-5"></i>
                                                <span class="small fw-bold">Non retenus</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $madRejected }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau récapitulatif par Entreprise Partenaire -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-buildings text-primary fs-4 me-2"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Récapitulatif par Entreprise Partenaire</h6>
                                    <small class="text-muted">Détail chiffré des mises à disposition, acceptations et taux de placement par structure</small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('candidatentreprises.envoi') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-send me-1"></i> Envoi en entreprise
                                </a>
                                <a href="{{ route('candidatentreprises.integres') }}" class="btn btn-outline-success btn-sm">
                                    <i class="bx bx-check-double me-1"></i> Intégrés en poste
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="datatable-entreprises" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Entreprise Partenaire</th>
                                        <th class="text-center">Total Envoyés</th>
                                        <th class="text-center">Acceptés (En Poste)</th>
                                        <th class="text-center">En Attente</th>
                                        <th class="text-center">Refusés</th>
                                        <th class="text-center" style="width: 180px;">Taux de Conversion</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($entreprisesStats as $ent)
                                        @php
                                            $tauxEnt = $ent->total_envois > 0 ? round(($ent->total_acceptes / $ent->total_envois) * 100, 1) : 0;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; min-width: 38px; font-size: 14px;">
                                                        {{ strtoupper(substr($ent->entreprise ?? 'E', 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark fs-6">{{ $ent->entreprise }}</div>
                                                        <small class="text-muted"><i class="bx bx-user me-1 text-secondary"></i>{{ $ent->total_candidats }} candidat(s) concerné(s)</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-secondary px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-paper-plane me-1 align-middle"></i> {{ $ent->total_envois }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-success px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-check-circle me-1 align-middle"></i> {{ $ent->total_acceptes }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-warning px-3 py-2 fs-6 shadow-sm" style="background-color: #f59e0b !important; color: #0f172a !important;">
                                                    <i class="bx bx-time-five me-1 align-middle"></i> {{ $ent->total_pending }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-danger px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-x-circle me-1 align-middle"></i> {{ $ent->total_refuses }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="fw-bold small text-dark">{{ $tauxEnt }}%</span>
                                                    <div class="progress progress-thin flex-grow-1" style="max-width: 90px; height: 8px;">
                                                        <div class="progress-bar {{ $tauxEnt >= 50 ? 'bg-success' : ($tauxEnt > 0 ? 'bg-warning' : 'bg-secondary') }}" 
                                                             style="width: {{ $tauxEnt }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('candidatentreprises.show', $ent->entreprise) }}" class="btn btn-sm btn-outline-primary shadow-sm fw-semibold">
                                                    <i class="bx bx-folder-open me-1"></i> Voir candidats
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="bx bx-buildings fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <p class="mb-0 fw-bold">Aucune mise à disposition enregistrée pour le moment</p>
                                                <small class="text-muted">Les candidatures envoyées en entreprise apparaîtront ici avec leurs statistiques.</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ========================================================================= -->
            <!-- ONGLET 2 : LISTE & SUIVI INDIVIDUEL AVEC STATISTIQUES PAR CANDIDAT -->
            <!-- ========================================================================= -->
            <div class="tab-pane fade {{ $activeTab === 'liste' ? 'show active' : '' }}" id="tab-liste" role="tabpanel" aria-labelledby="tab-liste-btn">
                <div class="card border-0 shadow-sm">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-table text-primary fs-4 me-2"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Indicateurs & Statistiques directes par candidat</h6>
                                    <small class="text-muted">Visualisation complète du parcours d'insertion de chaque adhérent sans ouvrir son dossier</small>
                                </div>
                            </div>
                            <span class="badge bg-primary px-3 py-2 fs-6">
                                Total : {{ $candidats->count() }} candidat(s)
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle dt-responsive" id="datatable--barm" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0" style="min-width: 220px;">
                                            <i class="bx bx-user text-primary me-1"></i> Candidat
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 210px;">
                                            <i class="bx bx-user-check text-primary me-1"></i> Profilage (RDV 1, 2, 3)
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 170px;">
                                            <i class="bx bx-briefcase-alt text-primary me-1"></i> Prépa Insertion
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 110px;">
                                            <i class="bx bx-book-open text-primary me-1"></i> Formations
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 160px;">
                                            <i class="bx bxs-buildings text-primary me-1"></i> Mise à disposition
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 110px;">
                                            <i class="bx bx-flag text-primary me-1"></i> Situation
                                        </th>
                                        <th class="border-0 text-end pe-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($candidats as $candidat)
                                        @php
                                            // RDV 1
                                            $entretiensCount = $candidat->candidatentretiens ? $candidat->candidatentretiens->where('presence', 1)->count() : 0;
                                            // RDV 2
                                            $bilansCount = $candidat->bilancompetences ? $candidat->bilancompetences->where('presence', 1)->count() : 0;
                                            // Prépa
                                            $cvlmCountCand = $candidat->cvlms ? $candidat->cvlms->count() : 0;
                                            $prepaCountCand = $candidat->prepaentretiens ? $candidat->prepaentretiens->count() : 0;
                                            $treCountCand = $candidat->techrechercheemplois ? $candidat->techrechercheemplois->count() : 0;
                                            // Formations
                                            $formationsCountCand = $candidat->candidatformations ? $candidat->candidatformations->count() : 0;
                                            // Mise à disposition
                                            $mads = $candidat->candidatentreprises ?? collect();
                                            $lastMad = $mads->sortByDesc('created_at')->first();
                                            $madTotalCand = $mads->count();
                                            $isAccepted = $mads->where('statut', 'accepted')->count() > 0 || $candidat->en_poste == '1';
                                        @endphp
                                        <tr>
                                            <!-- 1. Candidat -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; min-width: 38px; font-size: 13px;">
                                                        {{ strtoupper(substr($candidat->user->firstname ?? 'C', 0, 1) . substr($candidat->user->lastname ?? 'A', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $candidat->user ? $candidat->user->fullName() : 'N/A' }}</div>
                                                        <div class="small text-muted d-flex align-items-center gap-1 flex-wrap mt-1">
                                                            @if($candidat->user && $candidat->user->mecano)
                                                                <span class="badge bg-secondary text-white" style="font-size: 10px;">
                                                                    <i class="bx bx-id-card me-1"></i>Mécano: {{ $candidat->user->mecano }}
                                                                </span>
                                                            @endif
                                                            @php
                                                                $rawGender = strtolower(trim($candidat->gender ?? ($candidat->user->gender ?? '')));
                                                                $isFemme = in_array($rawGender, ['feminin', 'féminin', 'femme', 'f']);
                                                            @endphp
                                                            @if($isFemme)
                                                                <span class="badge badge-gender-femme" style="font-size: 10px;">
                                                                    <i class="bx bx-female me-1"></i>Femme
                                                                </span>
                                                            @else
                                                                <span class="badge badge-gender-homme" style="font-size: 10px;">
                                                                    <i class="bx bx-male me-1"></i>Homme
                                                                </span>
                                                            @endif
                                                            @if($candidat->phone_number || ($candidat->user && $candidat->user->phone))
                                                                <span class="text-secondary small ms-1">
                                                                    <i class="bx bx-phone me-1"></i>{{ $candidat->phone_number ?? $candidat->user->phone }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- 2. Profilage (RDV 1, 2, 3 en pilules comme Prépa) -->
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                                    <!-- RDV 1 -->
                                                    <span class="pill-indicator {{ $entretiensCount > 0 ? 'badge-subtle-success' : 'badge-subtle-secondary' }}" title="RDV 1 : Entretien ({{ $entretiensCount }})">
                                                        RDV 1: {{ $entretiensCount }}
                                                    </span>
                                                    <!-- RDV 2 -->
                                                    <span class="pill-indicator {{ $bilansCount > 0 ? 'badge-subtle-success' : 'badge-subtle-secondary' }}" title="RDV 2 : Bilan de compétences ({{ $bilansCount }})">
                                                        RDV 2: {{ $bilansCount }}
                                                    </span>
                                                    <!-- RDV 3 -->
                                                    @if ($candidat->profilage_decision == 1)
                                                        <span class="pill-indicator badge-subtle-success" title="RDV 3 : Validé Entreprise Privée">
                                                            RDV 3: Validé
                                                        </span>
                                                    @elseif ($entretiensCount > 0 && $bilansCount > 0)
                                                        <span class="pill-indicator badge-subtle-warning" title="RDV 3 : Prêt pour la décision">
                                                            RDV 3: En attente
                                                        </span>
                                                    @else
                                                        <span class="pill-indicator badge-subtle-secondary" title="RDV 3 : Non profilé">
                                                            RDV 3: 0
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- 3. Prépa Insertion (CV, Prépa, TRE) -->
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                                    <!-- CV & LM -->
                                                    <span class="pill-indicator {{ $cvlmCountCand > 0 ? 'badge-subtle-success' : 'badge-subtle-secondary' }}" title="CV et Lettre de motivation">
                                                        CV: {{ $cvlmCountCand }}
                                                    </span>
                                                    <!-- Prépa-Entretien -->
                                                    <span class="pill-indicator {{ $prepaCountCand > 0 ? 'badge-subtle-info' : 'badge-subtle-secondary' }}" title="Simulations d'entretiens">
                                                        Prépa: {{ $prepaCountCand }}
                                                    </span>
                                                    <!-- TRE -->
                                                    <span class="pill-indicator {{ $treCountCand > 0 ? 'badge-subtle-warning' : 'badge-subtle-secondary' }}" title="Techniques de recherche d'emploi">
                                                        TRE: {{ $treCountCand }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- 4. Formations -->
                                            <td class="text-center">
                                                @if ($formationsCountCand > 0)
                                                    <span class="badge badge-subtle-success px-2 py-1 fw-bold">
                                                        <i class="bx bx-book me-1"></i> {{ $formationsCountCand }} form.
                                                    </span>
                                                @else
                                                    <span class="badge badge-subtle-secondary px-2 py-1">
                                                        0 form.
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 5. Mise à disposition (Entreprise) -->
                                            <td class="text-center">
                                                @if ($lastMad)
                                                    <div>
                                                        <div class="fw-bold text-dark small">{{ $lastMad->entreprise }}</div>
                                                        @if ($lastMad->statut == 'accepted' || $isAccepted)
                                                            <span class="badge badge-subtle-success" style="font-size: 10px;">
                                                                <i class="bx bx-check me-1"></i> Accepté
                                                            </span>
                                                        @elseif ($lastMad->statut == 'rejected')
                                                            <span class="badge badge-subtle-danger" style="font-size: 10px;">
                                                                Refusé
                                                            </span>
                                                        @else
                                                            <span class="badge badge-subtle-warning" style="font-size: 10px;">
                                                                En attente
                                                            </span>
                                                        @endif
                                                        @if($madTotalCand > 1)
                                                            <small class="text-muted d-block mt-1" style="font-size: 10px;">({{ $madTotalCand }} envois)</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="badge badge-subtle-secondary px-2 py-1">
                                                        Non envoyé
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 6. Situation / En poste -->
                                            <td class="text-center">
                                                @if ($candidat->en_poste == '1' || $isAccepted)
                                                    <span class="badge bg-success px-2 py-1 shadow-sm">
                                                        <i class="bx bx-user-check me-1"></i> En Poste
                                                    </span>
                                                @elseif ($lastMad)
                                                    <span class="badge bg-warning text-dark px-2 py-1">
                                                        <i class="bx bx-send me-1"></i> En Entreprise
                                                    </span>
                                                @elseif ($formationsCountCand > 0 || $cvlmCountCand > 0 || $prepaCountCand > 0 || $treCountCand > 0)
                                                    <span class="badge bg-info px-2 py-1">
                                                        <i class="bx bx-briefcase-alt me-1"></i> En Prépa
                                                    </span>
                                                @elseif ($candidat->profilage_decision == 1)
                                                    <span class="badge bg-primary px-2 py-1">
                                                        <i class="bx bx-check-shield me-1"></i> Profilé
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary px-2 py-1">
                                                        En Profilage
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 7. Actions -->
                                            <td class="text-end pe-3">
                                                <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->id) }}" 
                                                   class="btn btn-outline-primary btn-sm shadow-sm text-nowrap" 
                                                   title="Consulter toute la synthèse du parcours de ce candidat">
                                                    <i class="bx bx-folder-open me-1"></i> Voir dossier
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="bx bx-user-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <p class="mb-0 fw-bold">Aucun candidat trouvé pour les critères sélectionnés</p>
                                                <small class="text-muted">Modifiez les filtres pour afficher les candidats.</small>
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
@endsection