{{-- SIDEBAR POUR CHEF BARM ET MINISTERE DE LA DÉFENSE --}}
@if (can('chef-barm|c2d|memdef'))

    {{-- Plan budgetaire --}}
    <li class="menu-item {{ routeActive(['budget-plans.index', 'budget-plans.create', 'budget-plans.edit']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-stats'></i>
            <div>Plan budgetaire </div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem('budget-plans.index') }}">
                <a href="{{ route('budget-plans.index') }}" class="menu-link">
                    <div>Liste</div>
                </a>
            </li>
            @if(can('chef-barm|c2d'))
            <li class="menu-item {{ routeItem('budget-plans.monitoring.index') }}">
                <a href="{{ route('budget-plans.monitoring.index') }}" class="menu-link">
                    <div>Suivi</div>
                </a>
            </li>
            @endif
        </ul>
    </li>

    {{-- Recherche --}}
    <li class="menu-item {{ routeActive('search.index') }}">
        <a href="{{ route('search.index') }}" class="menu-link">
            <i class='bx bxs-search'></i>&nbsp;&nbsp;
            <div>Recherche</div>
        </a>
    </li>

    {{-- SECTION AUTO EMPLOI (COLLAPSIBLE) --}}
    <li class="menu-item section-collapsible">
        <a href="javascript:void(0);" class="menu-link section-header">
            <i class='menu-icon tf-icons bx bx-chevron-right section-icon'></i>
            <div class="text-primary fw-bold">Auto Emploi</div>
        </a>
        <ul class="menu-sub section-content" style="display: none;">
            {{-- Adhérent --}}
            <li class="menu-item {{ routeActive(['adherent.create', 'adherent.steps', 'adherent.pending', 'adherent.list', 'adherent.resignations', 'adherent.deaths']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bx-user'></i>
                    <div>Adhérent</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ routeItem('retired.index') }}">
                        <a href="{{ route('retired.index') }}" class="menu-link">
                            <div>Liste des retraités</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('adherent.list') }}">
                        <a href="{{ route('adherent.list') }}" class="menu-link">
                            <div>Liste des adhérents </div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('adherent.deaths') }}">
                        <a href="{{ route('adherent.deaths') }}" class="menu-link">
                            <div>Liste des décès </div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('adherent.resignations') }}">
                        <a href="{{ route('adherent.resignations') }}" class="menu-link">
                            <div>Liste des abandons </div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeActive(['retired-preregistrations.index', 'retired-preregistrations.show']) }}">
                        <a href="{{ route('retired-preregistrations.index') }}" class="menu-link">
                            <div>Préinscriptions</div>
                            @php
                                $pendingCount = \App\Models\RetiredPreregistration::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge bg-warning text-dark ms-2">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Cohorte --}}
            <li class="menu-item {{ routeActive(['cohort.create', 'cohort.index']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bx-layer'></i>
                    <div>Cohorte</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ routeItem('cohort.index') }}">
                        <a href="{{ route('cohort.index') }}" class="menu-link">
                            <div>Liste</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Sessions Collectives --}}
            <li class="menu-item {{ routeActive(['sessioncollectives.create', 'sessioncollectives.index', 'sessioncollectives.show', 'sessioncollectives.edit', 'candidaturevalidated', 'candidaturepresent', 'listecandidature', 'candidaturevalidated', 'listecandidatureprovisoire']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bx-group'></i>
                    <div>Sessions Collectives</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ routeItem('listecandidature') }}">
                        <a href="{{ route('listecandidature') }}" class="menu-link">
                            <div>Liste des candidats profilés</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('sessioncollectives.index') }}">
                        <a href="{{ route('sessioncollectives.index') }}" class="menu-link">
                            <div>Liste des sessions organisées</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('candidaturepresent') }}">
                        <a href="{{ route('candidaturepresent') }}" class="menu-link">
                            <div>Liste des candidats present aux sessions</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Profilages --}}
            <li class="menu-item {{ routeActive(['profilage.profilage', 'profilage.index_profilage', 'profilage.create_profilage', 'profilage.candidat_profilage', 'profilage.end_candidat_profile', 'listecandidaturerefuser', 'listecandidature', 'profilage.candidats_absents', 'profilage.candidats_refuses']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bx-cross'></i>
                    <div>Profilages</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ routeItem('profilage.profilage') }}">
                        <a href="{{ route('profilage.profilage') }}" class="menu-link">
                            <div>Sessions organisées</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('listecandidature') }}">
                        <a href="{{ route('listecandidature') }}" class="menu-link">
                            <div>Liste des candidats profilés</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('listecandidaturerefuser') }}">
                        <a href="{{ route('listecandidaturerefuser') }}" class="menu-link">
                            <div>Liste des candidats non profilés</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('profilage.candidats_absents') }}">
                        <a href="{{ route('profilage.candidats_absents') }}" class="menu-link">
                            <div>Liste des candidats non profilés (<span class="text-danger">absents</span>)</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeItem('profilage.candidats_refuses') }}">
                        <a href="{{ route('profilage.candidats_refuses') }}" class="menu-link">
                            <div>Liste des candidats profilés réservés au BARM (<span class="text-danger">refusés</span>)</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Formations --}}
            <li class="menu-item {{ routeActive(['cohort.personal.training']) }}">
                <a href="{{ route('cohort.personal.training') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-layer'></i>
                    <div>Formations</div>
                </a>
            </li>

            {{-- Commission d'approbation --}}
            <li class="menu-item {{ routeActive(['commissions.cohorte', 'commissions.create', 'commissions.index', 'commissions.candidat_commission']) }}">
                <a href="{{ route('commissions.cohorte') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-notepad'></i>
                    <div class="d-flex justify-content-between">
                        <div>Commission d'approbation</div>
                        @if ($adherents_commission_pending_count > 0)
                            <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                                style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                                {{ $adherents_commission_pending_count }}
                            </span>
                        @endif
                    </div>
                </a>
            </li>

            {{-- PV Comité crédit --}}
            <li class="menu-item {{ routeActive(['monitored-evaluation.credit_committee.index', 'monitored-evaluation.credit_committee.show', 'monitored-evaluation.credit_committee.adherent']) }}">
                <a href="{{ route('monitored-evaluation.credit_committee.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-buildings'></i>
                    <div class="d-flex justify-content-between">
                        <div>PV Comité crédit</div>
                        @if (disbursementPendingCountByUser('pv_credit') > 0)
                            <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                                style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                                {{ disbursementPendingCountByUser('pv_credit') }}
                            </span>
                        @endif
                    </div>
                </a>
            </li>

            {{-- Decaissements --}}
            <li class="menu-item {{ routeActive(['monitored-evaluation.disbursement.cohorts', 'monitored-evaluation.disbursement.cohort', 'monitored-evaluation.disbursement.adherent']) }}">
                <a href="{{ route('monitored-evaluation.disbursement.cohorts') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-credit-card'></i>
                    <div class="d-flex justify-content-between">
                        <div>Decaissements</div>
                        @if (disbursementPendingCountByUser('disbursement') > 0)
                            <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                                style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                                {{ disbursementPendingCountByUser('disbursement') }}
                            </span>
                        @endif
                    </div>
                </a>
            </li>

            {{-- Suivi post-financement --}}
            <li class="menu-item {{ routeActive(['monitored-evaluation.post_monitored.cohorts', 'monitored-evaluation.post_monitored.cohort', 'monitored-evaluation.post_monitored.adherent']) }}">
                <a href="{{ route('monitored-evaluation.post_monitored.cohorts') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-folder-open'></i>
                    <div class="d-flex justify-content-between">
                        <div>Suivi post-financement</div>
                    </div>
                </a>
            </li>
        </ul>
    </li>

    {{-- SECTION ENTREPRISE PRIVÉE (COLLAPSIBLE) --}}
    <li class="menu-item section-collapsible">
        <a href="javascript:void(0);" class="menu-link section-header">
            <i class='menu-icon tf-icons bx bx-chevron-right section-icon'></i>
            <div class="text-primary fw-bold">Entreprise privée</div>
        </a>
        <ul class="menu-sub section-content" style="display: none;">
            {{-- Mise à disposition --}}
            <li class="menu-item {{ routeActive(['candidatentreprises.index', 'candidatentreprises.show', 'candidatentreprises.mise_a_disposition']) }}">
                <a href="{{ route('candidatentreprises.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-briefcase'></i>
                    <div>Mise à disposition</div>
                </a>
            </li>

            {{-- Suivi post-insertion --}}
            <li class="menu-item {{ routeActive(['monitored-evaluation.post_monitored.candidats_ep']) }}">
                <a href="{{ route('monitored-evaluation.post_monitored.candidats_ep') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-folder-open'></i>
                    <div class="d-flex justify-content-between">
                        <div>Suivi post-insertion</div>
                    </div>
                </a>
            </li>
        </ul>
    </li>

    {{-- SECTION FONCTION PUBLIQUE (COLLAPSIBLE) --}}
    <li class="menu-item section-collapsible">
        <a href="javascript:void(0);" class="menu-link section-header">
            <i class='menu-icon tf-icons bx bx-chevron-right section-icon'></i>
            <div class="text-primary fw-bold">Fonction publique</div>
        </a>
        <ul class="menu-sub section-content" style="display: none;">
            {{-- Resultats aux concours --}}
            <li class="menu-item {{ routeActive(['inscriptionconcours.candidatsadmis', 'inscriptionconcours.candidatsajournes']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-comment'></i>
                    <div>Resultats aux concours</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ routeActive('inscriptionconcours.candidatsadmis') }}">
                        <a href="{{ route('inscriptionconcours.candidatsadmis') }}" class="menu-link">
                            <div>Liste des admis</div>
                        </a>
                    </li>
                    <li class="menu-item {{ routeActive('inscriptionconcours.candidatsajournes') }}">
                        <a href="{{ route('inscriptionconcours.candidatsajournes') }}" class="menu-link">
                            <div>Liste des ajournés</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Suivi post-insertion --}}
            <li class="menu-item {{ routeActive(['monitored-evaluation.post_monitored.candidats_fp']) }}">
                <a href="{{ route('monitored-evaluation.post_monitored.candidats_fp') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-folder-open'></i>
                    <div class="d-flex justify-content-between">
                        <div>Suivi post-insertion</div>
                    </div>
                </a>
            </li>
        </ul>
    </li>

@endif
