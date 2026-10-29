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
                padding: 16px 12px;
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
                padding: 3px 8px;
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
                        <i class="bx bx-briefcase-alt-2 text-primary fs-3 me-2"></i>
                        <div>
                            <div class="text-muted small fw-medium">Auto-Emploi &bull; Espace Conseiller</div>
                            <h4 class="mb-0 text-primary fw-bold">Suivi des Candidats</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 no-print">
                <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" onclick="window.print()">
                    <i class="bx bx-printer me-1"></i> Imprimer
                </button>
                <a href="{{ route('export.pdf.suivi_ae_candidats', request()->query()) }}" class="btn btn-danger btn-sm shadow-sm text-white" title="Télécharger la liste complète officielle en PDF">
                    <i class="bx bxs-file-pdf me-1"></i> Exporter en PDF
                </a>
            </div>
        </div>

        <!-- Filtres dynamiques -->
        <div class="card border-0 shadow-sm mb-4 no-print">
            <div class="card-body p-3">
                <form action="{{ route('candidatentreprises.suivie_ae_candidats') }}" method="GET" class="row g-2 align-items-end">
                    <input type="hidden" name="tab" id="inputActiveTab" value="{{ $activeTab }}">
                    
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label small fw-semibold text-muted mb-1">Cohorte</label>
                        <select name="cohort_id" class="form-select form-select-sm">
                            <option value="">Toutes les cohortes</option>
                            @foreach ($cohortes as $cohorte)
                                <option value="{{ $cohorte->id }}" {{ $selectedCohort == $cohorte->id ? 'selected' : '' }}>
                                    {{ $cohorte->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label class="form-label small fw-semibold text-muted mb-1">Partenaire Technique</label>
                        <select name="partner_technical_id" class="form-select form-select-sm">
                            <option value="">Tous les partenaires techniques</option>
                            @foreach ($technicalPartners as $partenaire)
                                @php
                                    $pName = !empty($partenaire->user?->username) 
                                        ? $partenaire->user->username 
                                        : (!empty(trim($partenaire->user?->fullName() ?? '')) 
                                            ? $partenaire->user->fullName() 
                                            : ($partenaire->nom ?? 'Partenaire #' . $partenaire->id));
                                @endphp
                                <option value="{{ $partenaire->id }}" {{ $selectedPartnerTech == $partenaire->id ? 'selected' : '' }}>
                                    {{ $pName }}
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
                        @if($selectedCohort || $selectedPartnerTech || $selectedPartnerFin || $dateFrom || $dateTo)
                            <a href="{{ route('candidatentreprises.suivie_ae_candidats', ['tab' => $activeTab]) }}" class="btn btn-outline-secondary btn-sm" title="Réinitialiser">
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
            <!-- ONGLET 1 : STATISTIQUES GLOBALES & SYNTHÈSE CHIFFRÉE AUTO-EMPLOI -->
            <!-- ========================================================================= -->
            <div class="tab-pane fade {{ $activeTab === 'stats' ? 'show active' : '' }}" id="tab-stats" role="tabpanel" aria-labelledby="tab-stats-btn">

                <!-- 6 KPI Principaux -->
                <div class="row g-3 mb-4">
                    <!-- 1. Total Orientés Auto-Emploi -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Orientés Auto-Emploi</span>
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

                    <!-- 2. Plans d'Affaires Validés -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Plans d'Affaires</span>
                                <div class="kpi-icon-wrapper kpi-icon-info shadow-sm">
                                    <i class="bx bx-file"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-info mb-1">{{ number_format($paValidesCount, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>Soumis: <strong>{{ $paSoumisCount }}</strong></span>
                                <span class="badge badge-subtle-info">{{ $tauxValidationPA }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Commissions & Avis Favorables -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Commissions Validées</span>
                                <div class="kpi-icon-wrapper kpi-icon-warning shadow-sm">
                                    <i class="bx bx-check-shield"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: #b45309;">{{ number_format($commissionAcceptedCount, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>Différés: {{ $commissionDeferredCount }}</span>
                                <span class="badge badge-subtle-warning">{{ $tauxCommission }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Comptes Ouverts / Bancarisés -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Comptes Ouverts</span>
                                <div class="kpi-icon-wrapper kpi-icon-secondary shadow-sm">
                                    <i class="bx bx-lock-open-alt"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-secondary mb-1">{{ number_format($compteOuvertCount, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>En attente: <strong>{{ $compteEnAttenteCount }}</strong></span>
                                <span class="badge badge-subtle-secondary">{{ $tauxBancarisation }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Comité Crédit & Autorisations -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Comité & 10%</span>
                                <div class="kpi-icon-wrapper kpi-icon-success shadow-sm">
                                    <i class="bx bx-badge-check"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-success mb-1">{{ number_format($authorizationCount, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>Comité: <strong>{{ $creditCommitteeCount }}</strong></span>
                                <span class="badge badge-solid-success">{{ $authorizationCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Décaissements & Montant Décaissé -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-color: #93c5fd;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-primary small fw-bold">Financés (Décaissements)</span>
                                <div class="kpi-icon-wrapper bg-primary text-white shadow-sm">
                                    <i class="bx bx-money"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-primary mb-1">{{ number_format($disbursementCandidatesCount, 0, ',', ' ') }}</h3>
                            <div class="progress progress-thin bg-white mb-1">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, $tauxFinancement) }}%"></div>
                            </div>
                            <div class="text-dark fw-bold small text-end" style="font-size: 11px;">
                                Total: {{ number_format($totalMontantDecaisse, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deux blocs d'analyse côte à côte -->
                <div class="row g-4 mb-4">
                    <!-- Bloc 1 : Modules d'accompagnement & Démographie -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-pie-chart-alt-2 text-primary fs-4 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark">Démographie & Accompagnement initial</h6>
                                    </div>
                                    <span class="badge bg-light text-secondary border">Indicateurs</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4 mb-3">
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

                                    <!-- Accompagnement initial -->
                                    <div class="col-sm-6">
                                        <h6 class="fw-semibold text-muted small text-uppercase mb-3">Sessions & Affectations</h6>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="fw-semibold text-dark small">
                                                <i class="bx bxs-universal-access text-primary me-1"></i> Sessions collectives
                                            </span>
                                            <span class="badge bg-primary rounded-pill">{{ $sessionCount }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="fw-semibold text-dark small">
                                                <i class="bx bx-briefcase text-info me-1"></i> Affectés Partenaire Tech.
                                            </span>
                                            <span class="badge bg-info rounded-pill">{{ $assignedPartnerTechCount }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="fw-semibold text-dark small">
                                                <i class="bx bx-folder-open text-success me-1"></i> Suivi Post-Financement
                                            </span>
                                            <span class="badge bg-success rounded-pill">{{ $postMonitoredCount }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row text-center g-2 pt-2">
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 bg-light">
                                            <small class="text-muted d-block">Taux PA</small>
                                            <h5 class="fw-bold text-dark mb-0">{{ $tauxValidationPA }}%</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 bg-light">
                                            <small class="text-muted d-block">Taux Bancarisation</small>
                                            <h5 class="fw-bold text-dark mb-0">{{ $tauxBancarisation }}%</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 bg-light">
                                            <small class="text-muted d-block">Taux Financement</small>
                                            <h5 class="fw-bold text-primary mb-0">{{ $tauxFinancement }}%</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bloc 2 : Détails des Décisions & Financements -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-analyse text-primary fs-4 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark">Décisions Commission & Volume Financement</h6>
                                    </div>
                                    <span class="badge bg-light text-secondary border">Synthèse</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row text-center g-3 mb-4">
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #16a34a !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-success mb-1">
                                                <i class="bx bx-check-circle fs-5"></i>
                                                <span class="small fw-bold">Acceptés / Avis fav.</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $commissionAcceptedCount }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #f59e0b !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 mb-1" style="color: #b45309;">
                                                <i class="bx bx-time-five fs-5"></i>
                                                <span class="small fw-bold">Différés</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $commissionDeferredCount }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm" style="border-top: 4px solid #dc2626 !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-danger mb-1">
                                                <i class="bx bx-x-circle fs-5"></i>
                                                <span class="small fw-bold">Rejetés / Refusés</span>
                                            </div>
                                            <h3 class="fw-bold text-dark mb-0">{{ $commissionRefusedCount }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div>
                                        <div class="fw-bold text-dark">Montant global décaissé</div>
                                        <small class="text-muted">Cumul des tranches décaissées pour l'ensemble des projets</small>
                                    </div>
                                    <div class="text-end">
                                        <h4 class="fw-bold text-primary mb-0">{{ number_format($totalMontantDecaisse, 0, ',', ' ') }} FCFA</h4>
                                        <small class="text-success fw-semibold"><i class="bx bx-check-double"></i> {{ $disbursementCandidatesCount }} bénéficiaire(s)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau récapitulatif par Partenaire Technique -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-buildings text-primary fs-4 me-2"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Récapitulatif par Partenaire Technique</h6>
                                    <small class="text-muted">Indicateurs de conversion, nombre de projets validés et montants décaissés par structure</small>
                                </div>
                            </div>
                            <span class="badge bg-primary px-3 py-1">
                                {{ $partnersStats->count() }} structure(s)
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Partenaire Technique</th>
                                        <th class="text-center">Candidats</th>
                                        <th class="text-center">PA Soumis</th>
                                        <th class="text-center">PA Validés</th>
                                        <th class="text-center">Avis Favorables</th>
                                        <th class="text-center">Comptes Ouverts</th>
                                        <th class="text-center">Financés</th>
                                        <th class="text-end">Montant Décaissé</th>
                                        <th class="text-center pe-4">Taux Financement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($partnersStats as $stat)
                                        @php
                                            $partnerObj = $stat->partnerTechnical;
                                            $pName = !empty($partnerObj?->user?->username) 
                                                ? $partnerObj->user->username 
                                                : (!empty(trim($partnerObj?->user?->fullName() ?? '')) 
                                                    ? $partnerObj->user->fullName() 
                                                    : ($partnerObj->nom ?? 'Partenaire #' . $stat->partner_technical_id));
                                            $pFinRate = $stat->total_candidats > 0 ? round(($stat->total_decaissements_candidats / $stat->total_candidats) * 100, 1) : 0;
                                        @endphp
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">
                                                <i class="bx bx-buildings text-primary me-2"></i>
                                                {{ $pName }}
                                            </td>
                                            <td class="text-center fw-semibold">
                                                <span class="badge bg-light text-dark border">{{ $stat->total_candidats }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-subtle-secondary">{{ $stat->total_pa }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-subtle-info">{{ $stat->total_pa_valides }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-subtle-warning">{{ $stat->total_favorable }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-subtle-secondary">{{ $stat->total_comptes }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-subtle-success fw-bold">{{ $stat->total_decaissements_candidats }}</span>
                                            </td>
                                            <td class="text-end fw-bold text-primary">
                                                {{ number_format($stat->montant_total_decaisse, 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="text-center pe-4">
                                                <span class="badge badge-solid-primary">{{ $pFinRate }}%</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5 text-muted">
                                                <i class="bx bx-buildings fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <p class="mb-0 fw-bold">Aucune affectation à un partenaire technique pour les critères sélectionnés</p>
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
                                    <h6 class="mb-0 fw-bold text-dark">Indicateurs & Parcours direct par candidat (Auto-Emploi)</h6>
                                    <small class="text-muted">Visualisation complète des étapes (PA, Commission, Compte, Comité, Décaissement) sans ouvrir le dossier</small>
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
                                        <th class="border-0 text-center" style="min-width: 170px;">
                                            <i class="bx bx-buildings text-primary me-1"></i> Partenaire & Cohorte
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 140px;">
                                            <i class="bx bx-file text-primary me-1"></i> Plan d'Affaire (PA)
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 140px;">
                                            <i class="bx bx-check-shield text-primary me-1"></i> Commission
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 150px;">
                                            <i class="bx bx-lock-open-alt text-primary me-1"></i> Compte Bancaire
                                        </th>
                                        <th class="border-0 text-center" style="min-width: 170px;">
                                            <i class="bx bx-money text-primary me-1"></i> Comité & Décaissement
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($candidats as $candidat)
                                        @php
                                            $partnerTechName = !empty($candidat->partnerTechnical?->user?->username) 
                                                ? $candidat->partnerTechnical->user->username 
                                                : (!empty(trim($candidat->partnerTechnical?->user?->fullName() ?? '')) 
                                                    ? $candidat->partnerTechnical->user->fullName() 
                                                    : ($candidat->partnerTechnical->nom ?? null));
                                            
                                            $partnerFinName = !empty($candidat->partnerFinancial?->user?->username) 
                                                ? $candidat->partnerFinancial->user->username 
                                                : (!empty(trim($candidat->partnerFinancial?->user?->fullName() ?? '')) 
                                                    ? $candidat->partnerFinancial->user->fullName() 
                                                    : ($candidat->partnerFinancial->nom ?? null));

                                            // Compte bancaire
                                            $monitoredPayment = $candidat->selfEmploymentMonitoredPayment;
                                            $isAccountOpen = $monitoredPayment && ($monitoredPayment->account_opening == 1 || $monitoredPayment->account_opening === true);

                                            // Décaissements
                                            $disbursements = $monitoredPayment ? $monitoredPayment->disbursements : collect();
                                            $totalDecaisseCand = $disbursements->sum('amount_disbursement') ?? 0;
                                            $hasDisbursement = $candidat->disbursement == '1' || $totalDecaisseCand > 0;
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

                                            <!-- 2. Partenaire Technique & Cohorte -->
                                            <td class="text-center">
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    @if ($partnerTechName)
                                                        <span class="badge badge-subtle-info text-truncate" style="max-width: 160px;" title="{{ $partnerTechName }}">
                                                            <i class="bx bx-buildings me-1"></i>{{ $partnerTechName }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-subtle-secondary">Non affecté</span>
                                                    @endif

                                                    @if ($candidat->cohort)
                                                        <span class="badge bg-light text-muted border" style="font-size: 10px;">
                                                            {{ $candidat->cohort->title }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- 3. Plan d'Affaire (PA) -->
                                            <td class="text-center">
                                                @if ($candidat->pa == '1' && $candidat->pa_decision == '1')
                                                    <span class="pill-indicator badge-subtle-success">
                                                        <i class="bx bx-check-circle me-1"></i>Validé
                                                    </span>
                                                @elseif ($candidat->pa == '1' && $candidat->pa_decision == '2')
                                                    <span class="pill-indicator badge-subtle-danger">
                                                        <i class="bx bx-x-circle me-1"></i>Différé / Refusé
                                                    </span>
                                                @elseif ($candidat->pa == '1')
                                                    <span class="pill-indicator badge-subtle-warning">
                                                        <i class="bx bx-time me-1"></i>En attente
                                                    </span>
                                                @else
                                                    <span class="pill-indicator badge-subtle-secondary">
                                                        Non initié
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 4. Commission -->
                                            <td class="text-center">
                                                @php
                                                    $commissionAccepted = $candidat->favorable_opinion || ($candidat->commissionCandidat != null);
                                                    $lastComm = $candidat->commissionCandidats->sortByDesc('created_at')->first();
                                                @endphp
                                                @if ($commissionAccepted)
                                                    <span class="pill-indicator badge-subtle-success">
                                                        <i class="bx bx-check-shield me-1"></i>Avis favorable
                                                    </span>
                                                @elseif ($lastComm && $lastComm->decision == 'deferred')
                                                    <span class="pill-indicator badge-subtle-warning">
                                                        Différé
                                                    </span>
                                                @elseif ($lastComm && $lastComm->decision == 'refused')
                                                    <span class="pill-indicator badge-subtle-danger">
                                                        Refusé
                                                    </span>
                                                @else
                                                    <span class="pill-indicator badge-subtle-secondary">
                                                        En attente
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 5. Compte Bancaire -->
                                            <td class="text-center">
                                                @if ($isAccountOpen)
                                                    <div class="d-flex flex-column align-items-center gap-1">
                                                        <span class="pill-indicator badge-subtle-success">
                                                            <i class="bx bx-check me-1"></i>Ouvert (Bancarisé)
                                                        </span>
                                                        @if ($partnerFinName)
                                                            <small class="text-muted" style="font-size: 10px;">{{ $partnerFinName }}</small>
                                                        @endif
                                                    </div>
                                                @elseif ($commissionAccepted)
                                                    <span class="pill-indicator badge-subtle-warning">
                                                        En cours d'ouverture
                                                    </span>
                                                @else
                                                    <span class="pill-indicator badge-subtle-secondary">
                                                        Non ouvert
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- 6. Comité & Décaissement -->
                                            <td class="text-center">
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    @if ($hasDisbursement)
                                                        <span class="pill-indicator badge-subtle-success fw-bold">
                                                            <i class="bx bx-check-double me-1"></i>Décaissé
                                                        </span>
                                                        @if ($totalDecaisseCand > 0)
                                                            <span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size: 10px;">
                                                                {{ number_format($totalDecaisseCand, 0, ',', ' ') }} FCFA
                                                            </span>
                                                        @endif
                                                    @elseif ($candidat->credit_committee || $candidat->creditCommittee)
                                                        <span class="pill-indicator badge-subtle-info">
                                                            Comité validé
                                                        </span>
                                                    @else
                                                        <span class="pill-indicator badge-subtle-secondary">
                                                            En attente
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="bx bx-user-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <p class="mb-0 fw-bold">Aucun candidat trouvé pour les filtres sélectionnés</p>
                                                <small class="text-muted">Modifiez les filtres de cohorte ou de partenaire pour afficher les adhérents correspondants.</small>
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

@push('js-push')
    <script>
        $(document).ready(function() {
            // Initialisation de DataTable si présent
            if ($.fn.DataTable && $('#datatable--barm').length) {
                $('#datatable--barm').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                    },
                    pageLength: 25,
                    ordering: true,
                    responsive: true
                });
            }
        });
    </script>
@endpush
