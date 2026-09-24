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
                padding: 14px 10px;
                transition: all 0.2s ease;
                min-width: 110px;
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
                font-size: 20px;
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
                            <div class="text-muted small fw-medium">Fonction Publique &bull; Espace Conseiller</div>
                            <h4 class="mb-0 text-primary fw-bold">Suivi des Candidats</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 no-print">
                <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" onclick="window.print()">
                    <i class="bx bx-printer me-1"></i> Imprimer
                </button>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" onclick="exportToPDF('suivi-candidats-fp')">
                    <i class="bx bx-download me-1"></i> Exporter en PDF
                </button>
            </div>
        </div>

        <!-- Filtres dynamiques -->
        <div class="card border-0 shadow-sm mb-4 no-print">
            <div class="card-body p-3">
                <form action="{{ route('candidatentreprises.suivie_fp_candidats') }}" method="GET" class="row g-2 align-items-end">
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
                        <label class="form-label small fw-semibold text-muted mb-1">Concours</label>
                        <select name="concours" class="form-select form-select-sm">
                            <option value="">Tous les concours</option>
                            @foreach ($allConcours as $concours)
                                <option value="{{ $concours }}" {{ $selectedConcours == $concours ? 'selected' : '' }}>
                                    {{ $concours }}
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
                        @if($selectedCohort || $selectedConcours || $dateFrom || $dateTo)
                            <a href="{{ route('candidatentreprises.suivie_fp_candidats', ['tab' => $activeTab]) }}" class="btn btn-outline-secondary btn-sm" title="Réinitialiser">
                                <i class="bx bx-reset"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Système d'onglets (Navigation entre Statistiques globales et Liste individuelle) -->
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

                <!-- 6 KPI Principaux FP -->
                <div class="row g-3 mb-4">
                    <!-- 1. Total Orientés FP -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Orientés FP</span>
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

                    <!-- 3. Choix de Concours -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Choix Concours</span>
                                <div class="kpi-icon-wrapper kpi-icon-warning shadow-sm">
                                    <i class="bx bx-select-multiple"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: #b45309;">{{ number_format($choixConcoursCount, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>{{ $allConcours->count() }} concours</span>
                                <span class="badge badge-subtle-warning">Étape 1</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Dossiers Prêts (2/2) -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Dossiers Prêts</span>
                                <div class="kpi-icon-wrapper kpi-icon-secondary shadow-sm">
                                    <i class="bx bx-folder-check"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-secondary mb-1">{{ number_format($dossierCompletCount, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>R1: {{ $dossierR1Count }} | R2: {{ $dossierR2Count }}</span>
                                <span class="badge badge-subtle-secondary">2/2 validés</span>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Dossiers Déposés & Admis -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Admis Concours</span>
                                <div class="kpi-icon-wrapper kpi-icon-success shadow-sm">
                                    <i class="bx bx-trophy"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-success mb-1">{{ number_format($candidatsAdmis, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>Déposés: <strong>{{ $dossiersDeposesCount }}</strong></span>
                                <span class="badge badge-solid-success">{{ $candidatsAdmis }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Taux de Réussite / Admission -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-color: #93c5fd;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-primary small fw-bold">Taux de Réussite</span>
                                <div class="kpi-icon-wrapper bg-primary text-white shadow-sm">
                                    <i class="bx bx-line-chart"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-primary mb-1">{{ $tauxAdmission }}%</h3>
                            <div class="progress progress-thin bg-white mb-1">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, $tauxAdmission) }}%"></div>
                            </div>
                            <div class="text-muted small text-end" style="font-size: 10px;">
                                {{ $candidatsAdmis }} admis / {{ $dossiersDeposesCount }} déposés
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pipeline & Tunnel d'avancement Fonction Publique -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-git-merge text-primary fs-4 me-2"></i>
                                <h6 class="mb-0 fw-bold text-dark">Tunnel d'avancement &bull; Parcours Fonction Publique & Concours</h6>
                            </div>
                            <span class="badge bg-light text-secondary border">Flux temps réel</span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between gap-1 overflow-auto pb-2 text-center">
                            
                            <div class="funnel-step flex-fill">
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">1. Orientés FP</span>
                                <h5 class="fw-bold text-dark mb-1">{{ $totalCandidats }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">100% orientés</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill">
                                <span class="badge bg-info bg-opacity-10 text-info mb-2">2. RDV 1 Entretien</span>
                                <h5 class="fw-bold text-info mb-1">{{ $rdv1Count }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">{{ $totalCandidats > 0 ? round(($rdv1Count / $totalCandidats) * 100) : 0 }}% effectués</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2">3. RDV 2 Bilan</span>
                                <h5 class="fw-bold text-secondary mb-1">{{ $rdv2Count }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">{{ $totalCandidats > 0 ? round(($rdv2Count / $totalCandidats) * 100) : 0 }}% bilans</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill">
                                <span class="badge bg-warning bg-opacity-10 text-dark mb-2">4. RDV 3 Décision</span>
                                <h5 class="fw-bold text-warning mb-1">{{ $rdv3Valides }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">{{ $rdv3Eligibles }} en attente</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill">
                                <span class="badge bg-dark bg-opacity-10 text-dark mb-2">5. Choix Concours</span>
                                <h5 class="fw-bold text-dark mb-1">{{ $choixConcoursCount }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">{{ $choixConcoursCount }} orientés</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill">
                                <span class="badge bg-info bg-opacity-10 text-info mb-2">6. Prépa Concours</span>
                                <h5 class="fw-bold text-info mb-1">{{ $prepaPresentsCount }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">{{ $prepaConcoursCount }} inscrits</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2">7. Dossier Prêt</span>
                                <h5 class="fw-bold text-secondary mb-1">{{ $dossierCompletCount }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">2/2 rencontres</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill">
                                <span class="badge bg-warning bg-opacity-10 text-dark mb-2">8. Dossier Déposé</span>
                                <h5 class="fw-bold text-dark mb-1">{{ $dossiersDeposesCount }}</h5>
                                <small class="text-muted d-block" style="font-size: 10px;">Choix final</small>
                            </div>

                            <div class="funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>

                            <div class="funnel-step flex-fill" style="border-color: #10b981; background: #f0fdf4;">
                                <span class="badge bg-success mb-2">9. Admis FP</span>
                                <h5 class="fw-bold text-success mb-1">{{ $candidatsAdmis }}</h5>
                                <small class="text-success fw-semibold d-block" style="font-size: 10px;">{{ $tauxAdmission }}% admis</small>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Grille détaillée : Modules & Démographie -->
                <div class="row g-4 mb-4">
                    <!-- Modules de Préparation Concours -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-chalkboard text-primary fs-4 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark">Étapes de Préparation aux Concours</h6>
                                    </div>
                                    <span class="badge bg-primary">{{ $choixConcoursCount }} Candidats actifs</span>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-3">
                                    <!-- 1. Choix du concours -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-select-multiple"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">Choix Concours</span>
                                                </div>
                                                <span class="badge bg-primary fs-6">{{ $choixConcoursCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">Candidats ayant validé leur choix de concours.</p>
                                            <a href="{{ route('concours.choix') }}" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="bx bx-list-ul me-1"></i> Voir la liste
                                            </a>
                                        </div>
                                    </div>

                                    <!-- 2. Préparation aux cours concours -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-info text-white rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-book-reader"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">Prépa Concours</span>
                                                </div>
                                                <span class="badge bg-info fs-6">{{ $prepaPresentsCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">Présents aux cours de préparation et révisions.</p>
                                            <a href="{{ route('concours.prepa') }}" class="btn btn-outline-info btn-sm w-100">
                                                <i class="bx bx-list-ul me-1"></i> Voir la liste
                                            </a>
                                        </div>
                                    </div>

                                    <!-- 3. Préparation du dossier de candidature (2 rencontres) -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-warning text-dark rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-folder"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">Prépa Dossier (2 R.)</span>
                                                </div>
                                                <span class="badge bg-warning text-dark fs-6">{{ $dossierCompletCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">R1: {{ $dossierR1Count }} &bull; R2: {{ $dossierR2Count }} &bull; 2/2 validés: {{ $dossierCompletCount }}</p>
                                            <a href="{{ route('concours.dossier') }}" class="btn btn-outline-warning btn-sm w-100 text-dark">
                                                <i class="bx bx-list-ul me-1"></i> Voir la liste
                                            </a>
                                        </div>
                                    </div>

                                    <!-- 4. Formations Professionnelles -->
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-success text-white rounded-circle me-2 d-flex align-items-center justify-content-center shadow-sm">
                                                        <i class="bx bx-award"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">Dépôts & Résultats</span>
                                                </div>
                                                <span class="badge bg-success fs-6">{{ $candidatsAdmis }} Admis</span>
                                            </div>
                                            <p class="text-muted small mb-2">Dépôts effectués: {{ $dossiersDeposesCount }} &bull; Admis: {{ $candidatsAdmis }}</p>
                                            <a href="{{ route('concours.inscrits') }}" class="btn btn-outline-success btn-sm w-100">
                                                <i class="bx bx-list-ul me-1"></i> Voir les inscrits
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Répartition Démographie & Résultats -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-pie-chart-alt-2 text-primary fs-4 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark">Démographie & Résultats aux concours</h6>
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

                                    <!-- Synthèse des candidatures déposées -->
                                    <div class="col-sm-6">
                                        <h6 class="fw-semibold text-muted small text-uppercase mb-3">Synthèse des Résultats Concours</h6>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="fw-semibold text-dark small">
                                                <i class="bx bx-folder text-primary me-1"></i> Dossiers déposés
                                            </span>
                                            <span class="badge bg-primary rounded-pill">{{ $dossiersDeposesCount }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="fw-semibold text-success small">
                                                <i class="bx bx-trophy text-success me-1"></i> Lauréats Admis
                                            </span>
                                            <span class="badge bg-success rounded-pill">{{ $candidatsAdmis }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="fw-semibold text-warning small">
                                                <i class="bx bx-time text-warning me-1"></i> Résultats en attente
                                            </span>
                                            <span class="badge bg-warning text-dark rounded-pill">{{ $candidatsEnAttente }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Statut Résultat Concours -->
                                <hr class="my-4">
                                <div class="row text-center g-3">
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #16a34a !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-success mb-1">
                                                <i class="bx bx-trophy fs-5"></i>
                                                <span class="small fw-bold">Admis Concours</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $candidatsAdmis }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #f59e0b !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 mb-1" style="color: #b45309;">
                                                <i class="bx bx-time-five fs-5"></i>
                                                <span class="small fw-bold">En attente</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $candidatsEnAttente }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #dc2626 !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-danger mb-1">
                                                <i class="bx bx-x-circle fs-5"></i>
                                                <span class="small fw-bold">Ajournés</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $candidatsAjournes }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau récapitulatif par Concours -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-graduation text-primary fs-4 me-2"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Récapitulatif par Concours de la Fonction Publique</h6>
                                    <small class="text-muted">Détail chiffré des candidats, préparations, dossiers prêts, dépôts et taux de réussite par concours</small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('concours.choix') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-select-multiple me-1"></i> Choix concours
                                </a>
                                <a href="{{ route('concours.inscrits') }}" class="btn btn-outline-success btn-sm">
                                    <i class="bx bx-trophy me-1"></i> Lauréats & Inscrits
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="datatable-concours" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Intitulé du Concours</th>
                                        <th class="text-center">Total Candidats</th>
                                        <th class="text-center">Prépa (Présents)</th>
                                        <th class="text-center">Dossiers Prêts</th>
                                        <th class="text-center">Dossiers Déposés</th>
                                        <th class="text-center">Admis</th>
                                        <th class="text-center">Ajournés</th>
                                        <th class="text-center" style="width: 170px;">Taux de Réussite</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($concoursStats as $cStat)
                                        @php
                                            $tauxConcours = $cStat->total_deposes > 0 ? round(($cStat->total_admis / $cStat->total_deposes) * 100, 1) : 0;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; min-width: 38px; font-size: 14px;">
                                                        <i class="bx bxs-graduation"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark fs-6">{{ $cStat->intitule_concours }}</div>
                                                        @if($cStat->type_concours)
                                                            <small class="text-muted"><i class="bx bx-tag me-1 text-secondary"></i>{{ $cStat->type_concours }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-secondary px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-user me-1 align-middle"></i> {{ $cStat->total_candidats }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-primary px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-book-reader me-1 align-middle"></i> {{ $cStat->total_prepa }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-warning px-3 py-2 fs-6 shadow-sm" style="background-color: #f59e0b !important; color: #0f172a !important;">
                                                    <i class="bx bx-folder-check me-1 align-middle"></i> {{ $cStat->total_dossiers_prets }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-secondary px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-send me-1 align-middle"></i> {{ $cStat->total_deposes }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-success px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-trophy me-1 align-middle"></i> {{ $cStat->total_admis }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-solid-danger px-3 py-2 fs-6 shadow-sm">
                                                    <i class="bx bx-x-circle me-1 align-middle"></i> {{ $cStat->total_ajournes }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="fw-bold small text-dark">{{ $tauxConcours }}%</span>
                                                    <div class="progress progress-thin flex-grow-1" style="max-width: 80px; height: 8px;">
                                                        <div class="progress-bar {{ $tauxConcours >= 50 ? 'bg-success' : ($tauxConcours > 0 ? 'bg-warning' : 'bg-secondary') }}" 
                                                             style="width: {{ $tauxConcours }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('concours.inscrits') }}?concours={{ urlencode($cStat->intitule_concours) }}" class="btn btn-sm btn-outline-primary shadow-sm fw-semibold">
                                                    <i class="bx bx-folder-open me-1"></i> Voir lauréats
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5 text-muted">
                                                <i class="bx bxs-graduation fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <p class="mb-0 fw-bold">Aucun concours enregistré pour le moment</p>
                                                <small class="text-muted">Les choix de concours des candidats apparaîtront ici avec leurs statistiques.</small>
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
                                    <h6 class="mb-0 fw-bold text-dark">Indicateurs & Statistiques directes par candidat (Fonction Publique)</h6>
                                    <small class="text-muted">Visualisation complète du parcours d'orientation et de concours de chaque adhérent</small>
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
                                        <th class="border-0 text-center" style="min-width: 200px;">
                                            <i class="bx bx-user-check text-primary me-1"></i> Profilage (RDV 1, 2, 3)
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 220px;">
                                            <i class="bx bxs-graduation text-primary me-1"></i> Parcours Concours
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 140px;">
                                            <i class="bx bx-send text-primary me-1"></i> Dépôt Choix Final
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 160px;">
                                            <i class="bx bx-trophy text-primary me-1"></i> Résultat & Statut
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
                                            // Suivi concours
                                            $suivi = $candidat->concourSuivi;
                                            
                                            // Prépa concours statut
                                            $prepaStatut = $suivi ? $suivi->prepa_statut : null;
                                            
                                            // Rencontres dossier (0, 1 ou 2)
                                            $dossierR1 = $suivi && !empty($suivi->dossier_r1_date);
                                            $dossierR2 = $suivi && !empty($suivi->dossier_r2_date);
                                            $dossierCount = ($dossierR1 ? 1 : 0) + ($dossierR2 ? 1 : 0);
                                            
                                            // Dépôt choix final
                                            $isDepose = $suivi && $suivi->choix_final_statut === 'depose';
                                            
                                            // Résultat
                                            $resultat = $suivi ? $suivi->resultat_statut : null;
                                            $isAdmis = $resultat === 'admis';
                                            $isAjourne = $resultat === 'ajourne';
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

                                            <!-- 2. Profilage (RDV 1, 2, 3 en pilules) -->
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
                                                        <span class="pill-indicator badge-subtle-success" title="RDV 3 : Validé Fonction Publique">
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

                                            <!-- 3. Parcours Concours (Choix, Prépa, Dossier) -->
                                            <td class="text-center">
                                                <div class="d-flex flex-column align-items-center justify-content-center gap-1">
                                                    @if ($suivi && $suivi->intitule_concours)
                                                        <span class="badge badge-subtle-primary px-2 py-1 text-truncate" style="max-width: 200px;" title="{{ $suivi->intitule_concours }}">
                                                            <i class="bx bxs-graduation me-1"></i> {{ $suivi->intitule_concours }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-subtle-secondary px-2 py-1">
                                                            Concours non choisi
                                                        </span>
                                                    @endif

                                                    <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap mt-1">
                                                        <!-- Prépa -->
                                                        @if ($prepaStatut === 'present')
                                                            <span class="pill-indicator badge-subtle-success" title="Prépa concours : Présent">
                                                                Prépa: Présent
                                                            </span>
                                                        @elseif ($prepaStatut === 'absent')
                                                            <span class="pill-indicator badge-subtle-danger" title="Prépa concours : Absent">
                                                                Prépa: Absent
                                                            </span>
                                                        @elseif ($prepaStatut === 'abandon')
                                                            <span class="pill-indicator badge-subtle-warning" title="Prépa concours : Abandon">
                                                                Prépa: Abandon
                                                            </span>
                                                        @else
                                                            <span class="pill-indicator badge-subtle-secondary" title="Prépa concours : Non inscrit">
                                                                Prépa: 0
                                                            </span>
                                                        @endif

                                                        <!-- Dossier rencontres -->
                                                        <span class="pill-indicator {{ $dossierCount == 2 ? 'badge-subtle-success' : ($dossierCount == 1 ? 'badge-subtle-warning' : 'badge-subtle-secondary') }}" title="Rencontres préparation du dossier ({{ $dossierCount }}/2)">
                                                            Dossier: {{ $dossierCount }}/2
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- 4. Dépôt Choix Final -->
                                            <td class="text-center">
                                                @if ($isDepose)
                                                    <span class="badge bg-success px-2 py-1 shadow-sm">
                                                        <i class="bx bx-check-circle me-1"></i> Dossier Déposé
                                                    </span>
                                                    @if($suivi->choix_final_date)
                                                        <small class="text-muted d-block mt-1" style="font-size: 10px;">
                                                            {{ \Carbon\Carbon::parse($suivi->choix_final_date)->format('d/m/Y') }}
                                                        </small>
                                                    @endif
                                                @elseif ($dossierCount == 2)
                                                    <span class="badge bg-warning text-dark px-2 py-1">
                                                        <i class="bx bx-time me-1"></i> Prêt pour dépôt
                                                    </span>
                                                @else
                                                    <span class="badge badge-subtle-secondary px-2 py-1">
                                                        Non déposé
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 5. Résultat & Statut -->
                                            <td class="text-center">
                                                @if ($isAdmis)
                                                    <span class="badge bg-success px-3 py-1 shadow-sm fs-7">
                                                        <i class="bx bx-trophy me-1"></i> Admis Concours
                                                    </span>
                                                    @if($suivi->structure_affectation)
                                                        <small class="text-dark fw-semibold d-block mt-1" style="font-size: 11px;">
                                                            <i class="bx bx-building me-1"></i>{{ $suivi->structure_affectation }}
                                                        </small>
                                                    @endif
                                                @elseif ($isAjourne)
                                                    <span class="badge bg-danger px-2 py-1 shadow-sm">
                                                        <i class="bx bx-x-circle me-1"></i> Ajourné
                                                    </span>
                                                @elseif ($isDepose)
                                                    <span class="badge bg-warning text-dark px-2 py-1">
                                                        <i class="bx bx-time-five me-1"></i> En Attente Résultat
                                                    </span>
                                                @elseif ($suivi && $suivi->intitule_concours)
                                                    <span class="badge bg-info px-2 py-1">
                                                        <i class="bx bx-book me-1"></i> En Préparation
                                                    </span>
                                                @elseif ($candidat->profilage_decision == 1)
                                                    <span class="badge bg-primary px-2 py-1">
                                                        <i class="bx bx-check-shield me-1"></i> Profilé FP
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary px-2 py-1">
                                                        En Profilage
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 6. Actions -->
                                            <td class="text-end pe-3">
                                                <div class="d-flex align-items-center justify-content-end gap-1 flex-nowrap">
                                                    @if ($isAdmis)
                                                        <a href="{{ route('monitored-evaluation.post_monitored.adherent', $candidat->id) }}" 
                                                           class="btn btn-success btn-sm shadow-sm text-nowrap" 
                                                           title="Suivre l'adhérent post-insertion">
                                                            <i class="bx bx-check-double me-1"></i> Suivre
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->id) }}" 
                                                       class="btn btn-outline-primary btn-sm shadow-sm text-nowrap" 
                                                       title="Consulter toute la synthèse du parcours de ce candidat">
                                                        <i class="bx bx-folder-open me-1"></i> Dossier
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
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

@push('js-push')
    <script>
        $(document).ready(function() {
            // Initialisation de DataTable pour les statistiques par concours
            if ($('#datatable-concours').length && !$.fn.DataTable.isDataTable('#datatable-concours')) {
                $('#datatable-concours').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
                    },
                    order: [[1, 'desc']],
                    pageLength: 10,
                    responsive: true
                });
            }

            // Initialisation de DataTable pour la liste individuelle des candidats
            if ($('#datatable--barm').length && !$.fn.DataTable.isDataTable('#datatable--barm')) {
                $('#datatable--barm').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
                        emptyTable: "Aucun candidat trouvé pour les critères sélectionnés"
                    },
                    order: [[0, 'asc']],
                    pageLength: 25,
                    responsive: true
                });
            }

            // Gestion synchronisée des onglets
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam === 'liste') {
                const listeTabTrigger = document.querySelector('#tab-liste-btn');
                if (listeTabTrigger) {
                    const tab = new bootstrap.Tab(listeTabTrigger);
                    tab.show();
                }
            }
        });
    </script>
@endpush