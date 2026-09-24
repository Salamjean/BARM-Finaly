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
                width: 52px;
                height: 52px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 26px;
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
        </style>
    @endpush

    <div class="container-fluid py-2">
        <!-- En-tête & Fil d'ariane -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div class="border-start border-primary border-4 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-bar-chart-alt-2 text-primary fs-3 me-2"></i>
                        <div>
                            <div class="text-muted small fw-medium">Fonction Publique &bull; Tableau de bord</div>
                            <h4 class="mb-0 text-primary fw-bold">Suivi des Candidats &bull; Synthèse Statistique</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 no-print">
                <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" onclick="window.print()">
                    <i class="bx bx-printer me-1"></i> Imprimer
                </button>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" onclick="exportToPDF('stats-suivi-candidats-fp')">
                    <i class="bx bx-download me-1"></i> Exporter en PDF
                </button>
            </div>
        </div>

        <!-- Filtres dynamiques -->
        <div class="card border-0 shadow-sm mb-4 no-print">
            <div class="card-body p-3">
                <form action="{{ route('candidatentreprises.suivie_fp_candidats') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-4 col-sm-6">
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
                        <label class="form-label small fw-semibold text-muted mb-1">Date Début</label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label small fw-semibold text-muted mb-1">Date Fin</label>
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 col-sm-12 d-flex gap-1">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 shadow-sm">
                            <i class="bx bx-filter-alt me-1"></i> Filtrer
                        </button>
                        @if($selectedCohort || $dateFrom || $dateTo)
                            <a href="{{ route('candidatentreprises.suivie_fp_candidats') }}" class="btn btn-outline-secondary btn-sm" title="Réinitialiser">
                                <i class="bx bx-reset"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- 6 KPI Principaux FP -->
        <div class="row g-3 mb-4">
            <!-- 1. Total Orientés FP -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stat-kpi-card p-3 h-100 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Orientés FP</span>
                        <div class="kpi-icon-wrapper bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-user-pin"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ number_format($totalCandidats, 0, ',', ' ') }}</h3>
                    <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                        <span><i class="bx bx-male text-primary"></i> {{ $totalHommes }}</span>
                        <span><i class="bx bx-female text-danger"></i> {{ $totalFemmes }}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Profilés Validés -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stat-kpi-card p-3 h-100 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Profilés Validés</span>
                        <div class="kpi-icon-wrapper bg-info bg-opacity-10 text-info">
                            <i class="bx bx-check-shield"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-info mb-1">{{ number_format($rdv3Valides, 0, ',', ' ') }}</h3>
                    <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                        <span>En attente : <strong>{{ $rdv3Eligibles }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- 3. Dossiers Soumis -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stat-kpi-card p-3 h-100 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Dossiers Soumis</span>
                        <div class="kpi-icon-wrapper bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-folder-open"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-warning mb-1">{{ number_format($dossiersSoumis, 0, ',', ' ') }}</h3>
                    <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                        <span>Dossiers de concours</span>
                    </div>
                </div>
            </div>

            <!-- 4. Concours Inscrits -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stat-kpi-card p-3 h-100 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Inscrits Concours</span>
                        <div class="kpi-icon-wrapper bg-secondary bg-opacity-10 text-secondary">
                            <i class="bx bx-edit-alt"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-secondary mb-1">{{ number_format($concoursInscrits, 0, ',', ' ') }}</h3>
                    <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                        <span>Inscriptions effectives</span>
                    </div>
                </div>
            </div>

            <!-- 5. Candidats Admis -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stat-kpi-card p-3 h-100 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Admis Concours</span>
                        <div class="kpi-icon-wrapper bg-success bg-opacity-10 text-success">
                            <i class="bx bx-trophy"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-success mb-1">{{ number_format($candidatsAdmis, 0, ',', ' ') }}</h3>
                    <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                        <span>Lauréats admis</span>
                    </div>
                </div>
            </div>

            <!-- 6. Taux d'Admission -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                @php
                    $tauxAdmission = $concoursInscrits > 0 ? round(($candidatsAdmis / $concoursInscrits) * 100, 1) : 0;
                @endphp
                <div class="stat-kpi-card p-3 h-100 shadow-sm" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-primary small fw-bold">Taux Réussite</span>
                        <div class="kpi-icon-wrapper bg-primary text-white">
                            <i class="bx bx-line-chart"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-primary mb-1">{{ $tauxAdmission }}%</h3>
                    <div class="progress progress-thin bg-white mb-1">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, $tauxAdmission) }}%"></div>
                    </div>
                    <div class="text-muted small text-end" style="font-size: 10px;">
                        Par rapport aux inscrits
                    </div>
                </div>
            </div>
        </div>

        <!-- Pipeline Fonction Publique -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header card-header-gradient py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-git-merge text-primary fs-4 me-2"></i>
                        <h6 class="mb-0 fw-bold text-dark">Tunnel d'avancement &bull; Parcours Fonction Publique</h6>
                    </div>
                    <span class="badge bg-light text-secondary border">Flux temps réel</span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-2 align-items-center text-center">
                    <div class="col-lg col-md-4 col-6">
                        <div class="funnel-step h-100">
                            <span class="badge bg-primary bg-opacity-10 text-primary mb-2">1. Orientation FP</span>
                            <h4 class="fw-bold text-dark mb-1">{{ $totalCandidats }}</h4>
                            <small class="text-muted d-block">100% orientés</small>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>
                    <div class="col-lg col-md-4 col-6">
                        <div class="funnel-step h-100">
                            <span class="badge bg-info bg-opacity-10 text-info mb-2">2. RDV 1 Entretien</span>
                            <h4 class="fw-bold text-info mb-1">{{ $rdv1Count }}</h4>
                            <small class="text-muted d-block">{{ $totalCandidats > 0 ? round(($rdv1Count / $totalCandidats) * 100) : 0 }}% effectués</small>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>
                    <div class="col-lg col-md-4 col-6">
                        <div class="funnel-step h-100">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2">3. RDV 2 Bilan</span>
                            <h4 class="fw-bold text-secondary mb-1">{{ $rdv2Count }}</h4>
                            <small class="text-muted d-block">{{ $totalCandidats > 0 ? round(($rdv2Count / $totalCandidats) * 100) : 0 }}% bilans</small>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>
                    <div class="col-lg col-md-4 col-6">
                        <div class="funnel-step h-100">
                            <span class="badge bg-warning bg-opacity-10 text-dark mb-2">4. RDV 3 Décision</span>
                            <h4 class="fw-bold text-warning mb-1">{{ $rdv3Valides }}</h4>
                            <small class="text-muted d-block">{{ $rdv3Eligibles }} en attente</small>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>
                    <div class="col-lg col-md-4 col-6">
                        <div class="funnel-step h-100">
                            <span class="badge bg-dark bg-opacity-10 text-dark mb-2">5. Inscrits Concours</span>
                            <h4 class="fw-bold text-dark mb-1">{{ $concoursInscrits }}</h4>
                            <small class="text-muted d-block">{{ $dossiersSoumis }} dossiers</small>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block funnel-arrow"><i class="bx bx-right-arrow-alt"></i></div>
                    <div class="col-lg col-md-4 col-6">
                        <div class="funnel-step h-100" style="border-color: #10b981; background: #f0fdf4;">
                            <span class="badge bg-success mb-2">6. Admis Concours</span>
                            <h4 class="fw-bold text-success mb-1">{{ $candidatsAdmis }}</h4>
                            <small class="text-success fw-semibold d-block">{{ $tauxAdmission }}% admis</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection