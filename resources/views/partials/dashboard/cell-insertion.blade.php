<div class="container pt-3">
    <!-- Indicateur de chargement -->
    <div id="loadingIndicator" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>

    <!-- Onglets pour organiser les graphiques par orientation -->

    <ul class="nav nav-tabs mb-4" id="orientationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                type="button">
                Vue générale
            </button>
        </li>
        @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="auto-emploi-tab" data-bs-toggle="tab" data-bs-target="#auto-emploi"
                    type="button">
                    Auto-emploi
                </button>
            </li>
        @endif
        
        @if (can('chef-cellule-formation-et-insertion|conseiller-entreprise-prive'))
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="entreprise-tab" data-bs-toggle="tab" data-bs-target="#entreprise"
                    type="button">
                    Entreprise privée
                </button>
            </li>
        @endif
        @if (can('chef-cellule-formation-et-insertion|conseiller-fonction-public'))
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="fonction-tab" data-bs-toggle="tab" data-bs-target="#fonction"
                    type="button">
                    Fonction publique
                </button>
            </li>
        @endif
    </ul>

    <div class="tab-content" id="orientationTabContent">
        <!-- Vue générale -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Répartition par condition administrative</h5>
                            <div style="height: 300px;">
                                <canvas id="adherentsByCondition"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Répartition par orientation</h5>
                            <div style="height: 300px;">
                                <canvas id="adherentsByOrientation"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Répartition par condition financière</h5>
                            <div style="height: 300px;">
                                <canvas id="adherentsByConditionFinanciere"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto-emploi -->
        @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
            <div class="tab-pane fade" id="auto-emploi" role="tabpanel">

                <!-- Barre d'en-tête & Raccourcis Suivi Auto-Emploi -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 p-3 bg-white rounded-3 shadow-sm border">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm">
                            <i class="bx bx-briefcase-alt-2 fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Auto-Emploi &bull; Suivi des Candidats</h5>
                            <small class="text-muted">Tableau de bord consolidé, suivi des plans d'affaires, commissions, comptes et décaissements</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('candidatentreprises.suivie_ae_candidats') }}" class="btn btn-primary btn-sm shadow-sm">
                            <i class="bx bx-filter-alt me-1"></i> Suivi détaillé & Filtres avancés
                        </a>
                        <a href="{{ route('monitored-evaluation.account_opening.cohorts') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bx bx-lock-open-alt me-1"></i> Ouverture de compte
                        </a>
                        <a href="{{ route('monitored-evaluation.credit_committee.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bx bxs-buildings me-1"></i> PV Comité crédit
                        </a>
                        <a href="{{ route('monitored-evaluation.disbursement.cohorts') }}" class="btn btn-outline-success btn-sm">
                            <i class="bx bxs-credit-card me-1"></i> Décaissements
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Décisions de commission</h5>
                                <div style="height: 300px;">
                                    <canvas id="adherentsByCommission"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Répartition par partenaire technique</h5>
                                <div style="height: 300px;">
                                    <canvas id="adherentsByPartner"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">Répartition par types d'arme</h5>
                                    @php
                                        $totalArmesAuto = array_sum(is_array($adherents_by_type_armes_auto_emploi) ? $adherents_by_type_armes_auto_emploi : (is_object($adherents_by_type_armes_auto_emploi) ? $adherents_by_type_armes_auto_emploi->toArray() : []));
                                    @endphp
                                    <span class="badge bg-label-primary px-3 py-1 fs-6">{{ $totalArmesAuto }} candidat(s)</span>
                                </div>
                                <div style="height: 290px;">
                                    <canvas id="armeeAutoEmploi"></canvas>
                                </div>
                                <div class="mt-3 pt-2 border-top">
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        @php
                                            $armeBadgeStyles = [
                                                'Terre' => ['bg' => '#f3e8ff', 'text' => '#7e22ce', 'border' => '#c084fc'],
                                                'Gendarmerie Nationale' => ['bg' => '#dcfce7', 'text' => '#15803d', 'border' => '#86efac'],
                                                'Air' => ['bg' => '#ede9fe', 'text' => '#6d28d9', 'border' => '#a78bfa'],
                                                'Marine Nationale' => ['bg' => '#e0f2fe', 'text' => '#0369a1', 'border' => '#7dd3fc'],
                                                'Force Spéciale' => ['bg' => '#fce7f3', 'text' => '#be185d', 'border' => '#f472b6'],
                                                'Autre' => ['bg' => '#fef3c7', 'text' => '#b45309', 'border' => '#fcd34d'],
                                            ];
                                        @endphp
                                        @foreach ($adherents_by_type_armes_auto_emploi as $arme => $count)
                                            @php
                                                $style = $armeBadgeStyles[$arme] ?? ['bg' => '#f1f5f9', 'text' => '#334155', 'border' => '#cbd5e1'];
                                                $pct = $totalArmesAuto > 0 ? round(($count / $totalArmesAuto) * 100, 1) : 0;
                                            @endphp
                                            <div class="px-2 py-1 rounded border d-flex align-items-center gap-1 shadow-xs" style="background-color: {{ $style['bg'] }}; border-color: {{ $style['border'] }} !important;">
                                                <span class="fw-semibold small" style="color: {{ $style['text'] }};">{{ $arme }} :</span>
                                                <span class="badge bg-white fw-bold shadow-xs px-2" style="color: {{ $style['text'] }}; font-size: 12px;">{{ $count }}</span>
                                                <small class="text-muted" style="font-size: 10px;">({{ $pct }}%)</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">Répartition par grades</h5>
                                    @php
                                        $totalGradesAuto = array_sum(is_array($adherents_by_grades_auto_emploi) ? $adherents_by_grades_auto_emploi : (is_object($adherents_by_grades_auto_emploi) ? $adherents_by_grades_auto_emploi->toArray() : []));
                                    @endphp
                                    <span class="badge bg-label-primary px-3 py-1 fs-6">{{ $totalGradesAuto }} candidat(s)</span>
                                </div>
                                <div style="height: 290px;">
                                    <canvas id="gradeAutoEmploi"></canvas>
                                </div>
                                <div class="mt-3 pt-2 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-bold text-muted text-uppercase" style="font-size: 11px;">Effectifs chiffrés par grade :</small>
                                    </div>
                                    <div class="d-flex flex-wrap gap-1" style="max-height: 85px; overflow-y: auto;">
                                        @foreach ($adherents_by_grades_auto_emploi as $grade => $count)
                                            <span class="badge {{ $count > 50 ? 'bg-primary' : ($count > 10 ? 'bg-secondary' : 'bg-light text-dark border') }} d-inline-flex align-items-center gap-1 py-1 px-2" style="font-size: 11px;">
                                                <span>{{ $grade }} :</span>
                                                <strong class="{{ $count <= 10 ? 'text-primary' : 'text-white' }}">{{ $count }}</strong>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Nombre de bénéficiaires financés par partenaire</h5>
                                    <span class="badge bg-primary fs-5">{{ array_sum($disbursements_count_by_partner ?? []) }}</span>
                                </div>
                                <div style="height: 300px;">
                                    <canvas id="disbursementsCountByPartner"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Montant total des décaissements éffectués par partenaire</h5>
                                    <span class="badge bg-success fs-5">{{ amount(array_sum($disbursements_amount_by_partner ?? [])) }} FCFA</span>
                                </div>
                                <div style="height: 300px;">
                                    <canvas id="disbursementsAmountByPartner"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (can('chef-cellule-formation-et-insertion|conseiller-entreprise-prive'))
            <div class="tab-pane fade" id="entreprise" role="tabpanel">
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
                        width: 48px;
                        height: 48px;
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
                        padding: 14px;
                        transition: all 0.2s ease;
                        min-width: 130px;
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
                    .kpi-icon-primary { background: #e0f2fe !important; color: #0369a1 !important; }
                    .kpi-icon-info { background: #eff6ff !important; color: #1d4ed8 !important; }
                    .kpi-icon-warning { background: #fef3c7 !important; color: #b45309 !important; }
                    .kpi-icon-secondary { background: #f1f5f9 !important; color: #334155 !important; }
                    .kpi-icon-success { background: #dcfce7 !important; color: #15803d !important; }
                    .kpi-icon-danger { background: #fee2e2 !important; color: #b91c1c !important; }
                    .badge-solid-primary { background-color: #0284c7 !important; color: #ffffff !important; font-weight: 700; }
                    .badge-solid-success { background-color: #16a34a !important; color: #ffffff !important; font-weight: 700; }
                    .badge-solid-warning { background-color: #f59e0b !important; color: #0f172a !important; font-weight: 700; }
                    .badge-solid-danger { background-color: #dc2626 !important; color: #ffffff !important; font-weight: 700; }
                    .badge-solid-secondary { background-color: #475569 !important; color: #ffffff !important; font-weight: 700; }
                    .pill-indicator {
                        font-size: 11px;
                        padding: 2px 7px;
                        border-radius: 6px;
                        display: inline-block;
                        font-weight: 600;
                    }
                </style>

                @php
                    $totalArmes = is_array($adherents_by_type_armes_entreprise_privee) 
                        ? array_sum($adherents_by_type_armes_entreprise_privee) 
                        : ($adherents_by_type_armes_entreprise_privee ? $adherents_by_type_armes_entreprise_privee->sum() : 0);

                    $totalGrades = is_array($adherents_by_grades_entreprise_privee) 
                        ? array_sum($adherents_by_grades_entreprise_privee) 
                        : ($adherents_by_grades_entreprise_privee ? $adherents_by_grades_entreprise_privee->sum() : 0);

                    $totalCandidats = $ep_totalCandidats ?? 0;
                    $totalHommes = $ep_totalHommes ?? 0;
                    $totalFemmes = $ep_totalFemmes ?? 0;
                    $rdv1Count = $ep_rdv1Count ?? 0;
                    $rdv1Absents = $ep_rdv1Absents ?? 0;
                    $rdv2Count = $ep_rdv2Count ?? 0;
                    $rdv3Valides = $ep_rdv3Valides ?? 0;
                    $rdv3Eligibles = $ep_rdv3Eligibles ?? 0;
                    $cvlmCount = $ep_cvlmCount ?? 0;
                    $prepaCount = $ep_prepaCount ?? 0;
                    $treCount = $ep_treCount ?? 0;
                    $formationCount = $ep_formationCount ?? 0;
                    $beneficiairesPrepa = $ep_beneficiairesPrepa ?? 0;
                    $madTotal = $ep_madTotal ?? 0;
                    $madAcceptes = $ep_madAcceptes ?? 0;
                    $madPending = $ep_madPending ?? 0;
                    $madRejected = $ep_madRejected ?? 0;
                    $madCandidatsUniques = $ep_madCandidatsUniques ?? 0;
                    $enPosteCount = $ep_enPosteCount ?? 0;
                    $tauxInsertion = $ep_tauxInsertion ?? 0;
                    $tauxRecrutementMAD = $ep_tauxRecrutementMAD ?? 0;
                    $tauxProfilage = $ep_tauxProfilage ?? 0;
                    $entreprisesStats = $ep_entreprisesStats ?? collect();
                    $contratsStats = $ep_contratsStats ?? collect();
                    $candidats = $ep_candidats ?? collect();
                @endphp

                <!-- Barre d'en-tête & Raccourcis Suivi Entreprise Privée -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 p-3 bg-white rounded-3 shadow-sm border">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm">
                            <i class="bx bx-briefcase fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Entreprise Privée &bull; Suivi des Candidats</h5>
                            <small class="text-muted">Tableau de bord consolidé, indicateurs chiffrés et progression du parcours d'insertion</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('candidatentreprises.suivie_ep_candidats') }}" class="btn btn-primary btn-sm shadow-sm">
                            <i class="bx bx-filter-alt me-1"></i> Suivi détaillé & Filtres avancés
                        </a>
                        <a href="{{ route('candidatentreprises.envoi') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bx bx-conversation me-1"></i> Entretien d’embauche
                        </a>
                        <a href="{{ route('candidatentreprises.integres') }}" class="btn btn-outline-success btn-sm">
                            <i class="bx bx-check-double me-1"></i> Intégrés en poste
                        </a>
                    </div>
                </div>

                <!-- 1. INFORMATIONS SUR LES GRAPHIQUES MISES SOUS FORME DE CHIFFRES (TYPES D'ARME & GRADES) -->
                <div class="row g-4 mb-4">
                    <!-- Répartition par types d'arme sous forme de chiffres -->
                    <div class="col-xl-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-shield-quarter text-primary fs-4 me-2"></i>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">Répartition par types d'arme (Chiffres)</h6>
                                            <small class="text-muted">Effectifs chiffrés des candidats orientés Entreprise Privée</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm">{{ $totalArmes }} candidat(s)</span>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    @php
                                        $armeConfig = [
                                            'Terre' => ['border' => '#16a34a', 'bg' => '#f0fdf4', 'text' => '#15803d', 'icon' => 'bx-shield'],
                                            'Air' => ['border' => '#0284c7', 'bg' => '#f0f9ff', 'text' => '#0369a1', 'icon' => 'bx-paper-plane'],
                                            'Marine Nationale' => ['border' => '#2563eb', 'bg' => '#eff6ff', 'text' => '#1d4ed8', 'icon' => 'bx-water'],
                                            'Gendarmerie Nationale' => ['border' => '#7c3aed', 'bg' => '#f5f3ff', 'text' => '#6d28d9', 'icon' => 'bx-badge-check'],
                                            'Force Spéciale' => ['border' => '#dc2626', 'bg' => '#fef2f2', 'text' => '#b91c1c', 'icon' => 'bx-target-lock'],
                                            'Autre' => ['border' => '#64748b', 'bg' => '#f8fafc', 'text' => '#475569', 'icon' => 'bx-dots-horizontal-rounded'],
                                        ];
                                    @endphp
                                    @forelse ($adherents_by_type_armes_entreprise_privee as $arme => $count)
                                        @php
                                            $cfg = $armeConfig[$arme] ?? ['border' => '#0284c7', 'bg' => '#f8fafc', 'text' => '#0f172a', 'icon' => 'bx-shield'];
                                            $pct = $totalArmes > 0 ? round(($count / $totalArmes) * 100, 1) : 0;
                                        @endphp
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-3 rounded-3 border h-100 shadow-sm" style="background: {{ $cfg['bg'] }}; border-left: 4px solid {{ $cfg['border'] }} !important;">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span class="small fw-semibold text-muted text-truncate" title="{{ $arme }}">{{ $arme }}</span>
                                                    <i class="bx {{ $cfg['icon'] }} fs-5" style="color: {{ $cfg['text'] }};"></i>
                                                </div>
                                                <div class="d-flex align-items-baseline justify-content-between">
                                                    <h4 class="fw-bold mb-0" style="color: {{ $cfg['text'] }};">{{ $count }}</h4>
                                                    <span class="badge rounded-pill bg-white text-dark border small" style="font-size: 11px;">{{ $pct }}%</span>
                                                </div>
                                                <div class="progress progress-thin mt-2 bg-white">
                                                    <div class="progress-bar" style="width: {{ $pct }}%; background-color: {{ $cfg['border'] }};"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-4 text-muted">
                                            <i class="bx bx-info-circle fs-3 d-block mb-1"></i>
                                            Aucune donnée par type d'arme disponible
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Répartition par grades sous forme de chiffres -->
                    <div class="col-xl-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header card-header-gradient py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-medal text-primary fs-4 me-2"></i>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">Répartition par grades (Chiffres)</h6>
                                            <small class="text-muted">Tableau chiffré des effectifs par grade militaire</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm">{{ $totalGrades }} candidat(s)</span>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                    <table class="table table-sm table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th class="ps-2">Grade militaire</th>
                                                <th class="text-center" style="width: 100px;">Effectif</th>
                                                <th class="text-end pe-2" style="width: 130px;">Part (%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($adherents_by_grades_entreprise_privee as $grade => $count)
                                                @php
                                                    $pctGrade = $totalGrades > 0 ? round(($count / $totalGrades) * 100, 1) : 0;
                                                @endphp
                                                <tr>
                                                    <td class="ps-2 fw-semibold text-dark">
                                                        <i class="bx bx-chevron-right text-primary me-1"></i> {{ $grade }}
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary rounded-pill px-2 py-1 fs-6">{{ $count }}</span>
                                                    </td>
                                                    <td class="text-end pe-2">
                                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                                            <span class="small fw-bold text-muted">{{ $pctGrade }}%</span>
                                                            <div class="progress progress-thin" style="width: 50px;">
                                                                <div class="progress-bar bg-primary" style="width: {{ $pctGrade }}%;"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-4 text-muted">
                                                        <i class="bx bx-info-circle fs-3 d-block mb-1"></i>
                                                        Aucune donnée par grade disponible
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

                <!-- 2. CONTENU DE « SUIVI DES CANDIDATS » : 6 KPI PRINCIPAUX -->
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

                    <!-- 4. Mis en Relation -->
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="stat-kpi-card p-3 h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold">Mises en Relation</span>
                                <div class="kpi-icon-wrapper kpi-icon-secondary shadow-sm">
                                    <i class="bx bx-send"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-secondary mb-1">{{ number_format($madTotal, 0, ',', ' ') }}</h3>
                            <div class="d-flex align-items-center justify-content-between text-muted small" style="font-size: 11px;">
                                <span>{{ $madCandidatsUniques }} candidats</span>
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
                                Taux acceptation: <strong>{{ $tauxRecrutementMAD }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. TUNNEL D'AVANCEMENT & CONVERSION DU PARCOURS CANDIDAT -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-git-merge text-primary fs-4 me-2"></i>
                                <h6 class="mb-0 fw-bold text-dark">Tunnel d'avancement & Conversion du parcours candidat (Entreprise Privée)</h6>
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

                            <!-- Étape 5 : Mise en relation -->
                            <div class="col-lg col-md-4 col-6">
                                <div class="funnel-step h-100">
                                    <span class="badge badge-subtle-dark mb-2">5. Mis en relation</span>
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

                <!-- 4. MODULES DE PRÉPARATION & FORMATION + DÉMOGRAPHIE & CONTRATS -->
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
                                            <p class="text-muted small mb-2">Candidats ayant rédigé ou optimisé leur CV et LM.</p>
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
                                            <p class="text-muted small mb-2">Simulations et préparation aux entretiens.</p>
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
                                            <p class="text-muted small mb-2">Ateliers TRE et techniques de recherche.</p>
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
                                                    <span class="fw-semibold text-dark">Formations Pro</span>
                                                </div>
                                                <span class="badge bg-success fs-6">{{ $formationCount }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">Formations qualifiantes et compétences métiers.</p>
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

                                <!-- Statut Mises en relation -->
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
                                                <span class="small fw-bold">En attente</span>
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

                <!-- 5. TABLEAU RÉCAPITULATIF PAR ENTREPRISE PARTENAIRE -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-gradient py-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-buildings text-primary fs-4 me-2"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Récapitulatif par Entreprise Partenaire</h6>
                                    <small class="text-muted">Détail chiffré des mises en relation, acceptations et taux de conversion par structure</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="width:100%">
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
                                                <p class="mb-0 fw-bold">Aucune mise en relation enregistrée pour le moment</p>
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
        @endif

        <!-- Fonction publique -->
        @if (can('chef-cellule-formation-et-insertion|conseiller-fonction-public'))
            <div class="tab-pane fade" id="fonction" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">Répartition par types d'arme</h5>
                                    @php
                                        $totalArmesFonction = array_sum(is_array($adherents_by_type_armes_fonction_publique) ? $adherents_by_type_armes_fonction_publique : (is_object($adherents_by_type_armes_fonction_publique) ? $adherents_by_type_armes_fonction_publique->toArray() : []));
                                    @endphp
                                    <span class="badge bg-label-primary px-3 py-1 fs-6">{{ $totalArmesFonction }} candidat(s)</span>
                                </div>
                                <div style="height: 290px;">
                                    <canvas id="armeeFonction"></canvas>
                                </div>
                                <div class="mt-3 pt-2 border-top">
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        @php
                                            $armeBadgeStylesFonction = [
                                                'Terre' => ['bg' => '#f3e8ff', 'text' => '#7e22ce', 'border' => '#c084fc'],
                                                'Gendarmerie Nationale' => ['bg' => '#dcfce7', 'text' => '#15803d', 'border' => '#86efac'],
                                                'Air' => ['bg' => '#ede9fe', 'text' => '#6d28d9', 'border' => '#a78bfa'],
                                                'Marine Nationale' => ['bg' => '#e0f2fe', 'text' => '#0369a1', 'border' => '#7dd3fc'],
                                                'Force Spéciale' => ['bg' => '#fce7f3', 'text' => '#be185d', 'border' => '#f472b6'],
                                                'Autre' => ['bg' => '#fef3c7', 'text' => '#b45309', 'border' => '#fcd34d'],
                                            ];
                                        @endphp
                                        @foreach ($adherents_by_type_armes_fonction_publique as $arme => $count)
                                            @php
                                                $style = $armeBadgeStylesFonction[$arme] ?? ['bg' => '#f1f5f9', 'text' => '#334155', 'border' => '#cbd5e1'];
                                                $pct = $totalArmesFonction > 0 ? round(($count / $totalArmesFonction) * 100, 1) : 0;
                                            @endphp
                                            <div class="px-2 py-1 rounded border d-flex align-items-center gap-1 shadow-xs" style="background-color: {{ $style['bg'] }}; border-color: {{ $style['border'] }} !important;">
                                                <span class="fw-semibold small" style="color: {{ $style['text'] }};">{{ $arme }} :</span>
                                                <span class="badge bg-white fw-bold shadow-xs px-2" style="color: {{ $style['text'] }}; font-size: 12px;">{{ $count }}</span>
                                                <small class="text-muted" style="font-size: 10px;">({{ $pct }}%)</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">Répartition par grades</h5>
                                    @php
                                        $totalGradesFonction = array_sum(is_array($adherents_by_grades_fonction_publique) ? $adherents_by_grades_fonction_publique : (is_object($adherents_by_grades_fonction_publique) ? $adherents_by_grades_fonction_publique->toArray() : []));
                                    @endphp
                                    <span class="badge bg-label-primary px-3 py-1 fs-6">{{ $totalGradesFonction }} candidat(s)</span>
                                </div>
                                <div style="height: 290px;">
                                    <canvas id="gradeFonction"></canvas>
                                </div>
                                <div class="mt-3 pt-2 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-bold text-muted text-uppercase" style="font-size: 11px;">Effectifs chiffrés par grade :</small>
                                    </div>
                                    <div class="d-flex flex-wrap gap-1" style="max-height: 85px; overflow-y: auto;">
                                        @foreach ($adherents_by_grades_fonction_publique as $grade => $count)
                                            <span class="badge {{ $count > 50 ? 'bg-primary' : ($count > 10 ? 'bg-secondary' : 'bg-light text-dark border') }} d-inline-flex align-items-center gap-1 py-1 px-2" style="font-size: 11px;">
                                                <span>{{ $grade }} :</span>
                                                <strong class="{{ $count <= 10 ? 'text-primary' : 'text-white' }}">{{ $count }}</strong>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('js-push')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script>
        // Configuration globale pour Chart.js
        Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
        Chart.defaults.plugins.legend.labels.usePointStyle = true;

        // Palette de couleurs moderne
        const colors = {
            primary: ['#6366f1', '#ec4899', '#f59e0b', '#8b5cf6', '#10b981', '#3b82f6'],
            secondary: ['#c084fc', '#fcd34d', '#f9a8d4', '#86efac', '#93c5fd', '#e9d5ff'],
            gradients: []
        };

        // Plugin pour afficher les valeurs chiffrées au bout des barres (grades, etc.)
        const barDataLabelsPlugin = {
            id: 'barDataLabelsPlugin',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;
                ctx.save();
                chart.getDatasetMeta(0).data.forEach((bar, index) => {
                    const val = chart.data.datasets[0].data[index];
                    if (val !== undefined && val !== null) {
                        ctx.font = 'bold 11px sans-serif';
                        ctx.fillStyle = '#1e293b';
                        if (chart.config.options.indexAxis === 'y') {
                            ctx.textAlign = 'left';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(val, bar.x + 6, bar.y);
                        } else {
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.fillText(val, bar.x, bar.y - 4);
                        }
                    }
                });
                ctx.restore();
            }
        };

        // Fonction pour créer des graphiques avec animation
        function createChart(elementId, type, data, options = {}, extraPlugins = []) {
            const ctx = document.getElementById(elementId);
            if (!ctx) return;

            const defaultOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: type === 'pie' || type === 'doughnut' ? 'right' : 'top',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            };

            // Fusionner les options
            const finalOptions = {
                ...defaultOptions,
                ...options
            };

            return new Chart(ctx.getContext('2d'), {
                type: type,
                data: data,
                options: finalOptions,
                plugins: extraPlugins
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Graphique des conditions
            const adherentsByCondition = @json($adherents_by_condition);
            createChart('adherentsByCondition', 'bar', {
                labels: Object.keys(adherentsByCondition),
                datasets: [{
                    label: 'Nombre d\'adhérents',
                    data: Object.values(adherentsByCondition),
                    backgroundColor: colors.primary,
                    borderWidth: 0,
                    borderRadius: 8
                }]
            }, {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribution par condition administrative',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            });

            // Graphique des orientations
            const adherentsByOrientation = @json($adherents_by_orientation);
            createChart('adherentsByOrientation', 'doughnut', {
                labels: Object.keys(adherentsByOrientation).map(label => {
                    return label.split('-').map(word =>
                        word.charAt(0).toUpperCase() + word.slice(1)
                    ).join(' ');
                }),
                datasets: [{
                    data: Object.values(adherentsByOrientation),
                    backgroundColor: colors.primary.slice(0, 3),
                    borderWidth: 0
                }]
            }, {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartition par orientation professionnelle',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                }
            });

            // Graphique des conditions financières
            const adherentsByConditionFinanciere = @json($adherents_by_condition_financiere ?? []);
            createChart('adherentsByConditionFinanciere', 'bar', {
                labels: Object.keys(adherentsByConditionFinanciere),
                datasets: [{
                    label: 'Nombre d\'adhérents',
                    data: Object.values(adherentsByConditionFinanciere),
                    backgroundColor: colors.primary,
                    borderWidth: 0,
                    borderRadius: 8
                }]
            }, {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribution par condition financière',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            });

            @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                // Graphique des commissions
                const adherentsByCommission = @json($adherents_by_commissions_auto_emploi);
                const commissionLabels = {
                    'accepted': 'Accepté',
                    'refused': 'Refusé',
                    'deferred': 'Différé',
                    'resignation': 'Démission'
                };
                createChart('adherentsByCommission', 'pie', {
                    labels: Object.keys(adherentsByCommission).map(key => commissionLabels[key] || key),
                    datasets: [{
                        data: Object.values(adherentsByCommission),
                        backgroundColor: colors.primary.slice(0, 4),
                        borderWidth: 0
                    }]
                });

                // Graphique des partenaires
                const partnersCount = @json($adherents_by_partners_technicial_count);
                createChart('adherentsByPartner', 'bar', {
                    labels: Object.keys(partnersCount),
                    datasets: [{
                        label: 'Nombre de candidatures',
                        data: Object.values(partnersCount),
                        backgroundColor: colors.primary[0],
                        borderWidth: 0,
                        borderRadius: 8
                    }]
                }, {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });

                // Graphiques Auto-emploi
                const armeeAutoEmploi = @json($adherents_by_type_armes_auto_emploi);
                const armeeAutoLabels = Object.keys(armeeAutoEmploi).map(key => `${key} (${armeeAutoEmploi[key]})`);
                const totalArmeeAuto = Object.values(armeeAutoEmploi).reduce((a, b) => a + Number(b), 0);

                createChart('armeeAutoEmploi', 'polarArea', {
                    labels: armeeAutoLabels,
                    datasets: [{
                        data: Object.values(armeeAutoEmploi),
                        backgroundColor: colors.secondary,
                        borderWidth: 1,
                        borderColor: '#ffffff'
                    }]
                }, {
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                padding: 10,
                                font: {
                                    size: 11,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = Number(context.raw) || 0;
                                    const pct = totalArmeeAuto > 0 ? ((val / totalArmeeAuto) * 100).toFixed(1) : 0;
                                    return ` Effectif : ${val} (${pct}%)`;
                                }
                            }
                        }
                    }
                });

                const gradeAutoEmploi = @json($adherents_by_grades_auto_emploi);
                const gradeAutoValues = Object.values(gradeAutoEmploi).map(v => Number(v));
                const maxGradeAutoVal = gradeAutoValues.length > 0 ? Math.max(...gradeAutoValues) : 0;

                createChart('gradeAutoEmploi', 'bar', {
                    labels: Object.keys(gradeAutoEmploi),
                    datasets: [{
                        label: 'Effectifs',
                        data: gradeAutoValues,
                        backgroundColor: colors.primary[1],
                        borderWidth: 0,
                        borderRadius: 6
                    }]
                }, {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            suggestedMax: maxGradeAutoVal > 0 ? Math.ceil(maxGradeAutoVal * 1.15) : 10,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }, [barDataLabelsPlugin]);

                // Graphique: Nombre de décaissements terminés par partenaire technique
                const disbursementsCount = @json($disbursements_count_by_partner ?? []);
                createChart('disbursementsCountByPartner', 'bar', {
                    labels: Object.keys(disbursementsCount),
                    datasets: [{
                        label: 'Nombre de décaissements terminés',
                        data: Object.values(disbursementsCount),
                        backgroundColor: Object.keys(disbursementsCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(disbursementsCount).length;
                            return `hsla(${hue}, 80%, 50%, 0.5)`;
                        }),
                        borderColor: Object.keys(disbursementsCount).map((_, index) => {
                            const hue = (index * 360) / Object.keys(disbursementsCount).length;
                            return `hsla(${hue}, 80%, 40%, 1)`;
                        }),
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                }, {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });

                // Graphique: Montant total des décaissements terminés par partenaire technique
                const disbursementsAmount = @json($disbursements_amount_by_partner ?? []);
                createChart('disbursementsAmountByPartner', 'bar', {
                    labels: Object.keys(disbursementsAmount),
                    datasets: [{
                        label: 'Montant total (FCFA)',
                        data: Object.values(disbursementsAmount),
                        backgroundColor: Object.keys(disbursementsAmount).map((_, index) => {
                            const hue = 120 + (index * 240) / Object.keys(disbursementsAmount).length;
                            return `hsla(${hue}, 70%, 50%, 0.6)`;
                        }),
                        borderColor: Object.keys(disbursementsAmount).map((_, index) => {
                            const hue = 120 + (index * 240) / Object.keys(disbursementsAmount).length;
                            return `hsla(${hue}, 70%, 35%, 1)`;
                        }),
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                }, {
                    indexAxis: 'y',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.x !== null) {
                                        label += new Intl.NumberFormat('fr-FR', {
                                            style: 'currency',
                                            currency: 'XOF',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }).format(context.parsed.x);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('fr-FR', {
                                        style: 'currency',
                                        currency: 'XOF',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }).format(value);
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });
            @endif



            @if (can('chef-cellule-formation-et-insertion|conseiller-fonction-public'))
                // Graphiques Fonction publique
                const armeeFonction = @json($adherents_by_type_armes_fonction_publique);
                const armeeFonctionLabels = Object.keys(armeeFonction).map(key => `${key} (${armeeFonction[key]})`);
                const totalArmeeFonction = Object.values(armeeFonction).reduce((a, b) => a + Number(b), 0);

                createChart('armeeFonction', 'polarArea', {
                    labels: armeeFonctionLabels,
                    datasets: [{
                        data: Object.values(armeeFonction),
                        backgroundColor: colors.secondary,
                        borderWidth: 1,
                        borderColor: '#ffffff'
                    }]
                }, {
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                padding: 10,
                                font: {
                                    size: 11,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = Number(context.raw) || 0;
                                    const pct = totalArmeeFonction > 0 ? ((val / totalArmeeFonction) * 100).toFixed(1) : 0;
                                    return ` Effectif : ${val} (${pct}%)`;
                                }
                            }
                        }
                    }
                });

                const gradeFonction = @json($adherents_by_grades_fonction_publique);
                const gradeFonctionValues = Object.values(gradeFonction).map(v => Number(v));
                const maxGradeFonctionVal = gradeFonctionValues.length > 0 ? Math.max(...gradeFonctionValues) : 0;

                createChart('gradeFonction', 'bar', {
                    labels: Object.keys(gradeFonction),
                    datasets: [{
                        label: 'Effectifs',
                        data: gradeFonctionValues,
                        backgroundColor: colors.primary[2],
                        borderWidth: 0,
                        borderRadius: 6
                    }]
                }, {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: maxGradeFonctionVal > 0 ? Math.ceil(maxGradeFonctionVal * 1.15) : 10,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }, [barDataLabelsPlugin]);

                
            @endif
        });
    </script>
@endpush
