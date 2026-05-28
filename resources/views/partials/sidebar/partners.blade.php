{{-- SIDEBAR POUR PARTNERS (TECHNICAL, FINANCIAL, EMPLOYMENT) --}}

{{-- PARTNER TECHNICAL --}}
@if (can('partner-technical'))
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

    <li class="menu-item {{ routeActive(['listepartenersession']) }}">
        <a href="{{ route('listepartenersession') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-group'></i>
            <div>Sessions Collectives</div>
        </a>
    </li>

    {{-- Sessions Collectives & Profilages --}}
    <li class="menu-item {{ routeActive(['profilage.partenaire_candidat_profilage','profilage.partenaire_cohort']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-group'></i>
            <div>Prolifages</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem('profilage.partenaire_candidat_profilage') }}">
                <a href="{{ route('profilage.partenaire_candidat_profilage') }}" class="menu-link">
                    <div>En attente</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('profilage.histories') }}">
                <a href="{{ route('profilage.histories') }}" class="menu-link">
                    <div>Historique</div>
                </a>
            </li>
        </ul>
    </li>

    {{-- Formations --}}
    <li class="menu-item {{ routeActive(['cohort.partner.index']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-layer'></i>
            <div>Formations</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem('cohort.partner.index') }}">
                <a href="{{ route('cohort.partner.index') }}" class="menu-link">
                    <div>Liste</div>
                </a>
            </li>
        </ul>
    </li>

    {{-- Collecte de données --}}
    <li class="menu-item {{ routeActive(['cohort.data_collect.list']) }}">
        <a href="{{ route('cohort.data_collect.list') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-data"></i>
            <div>Collecte de données</div>
        </a>
    </li>

    {{-- Plan d'affaire --}}
    <li class="menu-item {{ routeActive(['cohort.pa.list_pending', 'cohort.pa.cohorts']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bxs-file-pdf'></i>
            <div>Plan d&apos;affaire</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem(['cohort.pa.list_pending']) }}">
                <a href="{{ route('cohort.pa.list_pending') }}" class="menu-link">
                    <div>En attente</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem(['cohort.pa.cohorts']) }}">
                <a href="{{ route('cohort.pa.cohorts') }}" class="menu-link">
                    <div>Historique</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem(['cohort.pa.refused']) }}">
                <a href="{{ route('cohort.pa.refused') }}" class="menu-link">
                    <div>Différé</div>
                </a>
            </li>
        </ul>
    </li>

    {{-- Commission d'approbation --}}
    <li class="menu-item {{ routeActive(['commissions.cohorte']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bxs-timer'></i>
            <div class="d-flex justify-content-between">
                <div>Commission d'approbation</div>
            </div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem('commissions.jury_members') }}">
                <a href="{{ route('commissions.jury_members') }}" class="menu-link">
                    <div>Membres du jury</div>
                </a>
            </li>
        </ul>
    </li>

    {{-- PV Comité credit --}}
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
                    <div class=" mx-2 rounded-circle bg-white px-2 text-black">
                        {{ disbursementPendingCountByUser('disbursement') }}</div>
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
@endif

{{-- PARTNER FINANCIAL --}}
@if (can('partner-financial'))
    {{-- Commission d'approbation --}}
    <li class="menu-item {{ routeActive(['commissions.jury_members']) }}">
        <a href="{{ route('commissions.jury_members') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-folder-open'></i>
            <div class="d-flex justify-content-between">
                <div>Commission d'approbation</div>
            </div>
        </a>
    </li>

    {{-- Ouverture du compte --}}
    <li class="menu-item {{ routeActive(['monitored-evaluation.account_opening.cohorts.authorization', 'mmonitored-evaluation.account_opening.cohort.authorization_approved']) }}">
        <a href="{{ route('monitored-evaluation.account_opening.cohorts.authorization') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-briefcase'></i>
            <div class="d-flex justify-content-between" style="position: relative;">
                <div>Ouverture du compte</div>
                @if ($authorization_approved_pending_count > 0)
                    <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                        style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                        {{ $authorization_approved_pending_count }}
                    </span>
                @endif
            </div>
        </a>
    </li>

    {{-- PV Comité credit --}}
    <li class="menu-item {{ routeActive(['monitored-evaluation.credit_committee.index', 'monitored-evaluation.credit_committee.show', 'monitored-evaluation.credit_committee.adherent']) }}">
        <a href="{{ route('monitored-evaluation.credit_committee.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-buildings'></i>
            <div class="d-flex justify-content-between">
                <div>PV Comité credit</div>
                @if (disbursementPendingCountByUser('pv_credit') > 0)
                    <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                        style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                        {{ disbursementPendingCountByUser('pv_credit') }}
                    </span>
                @endif
            </div>
        </a>
    </li>

    {{-- Autorisation --}}
    <li class="menu-item {{ routeActive(['monitored-evaluation.ten_percent.index']) }}">
        <a href="{{ route('monitored-evaluation.ten_percent.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-credit-card'></i>
            <div class="d-flex justify-content-between">
                <div>Autorisation</div>
                @if (disbursementPendingCountByUser('ten_percent') > 0)
                    <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                        style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                        {{ disbursementPendingCountByUser('ten_percent') }}
                    </span>
                @endif
            </div>
        </a>
    </li>

    {{-- Decaissements --}}
    <li class="menu-item {{ routeActive(['monitored-evaluation.disbursement.cohorts', 'monitored-evaluation.disbursement.cohort', 'monitored-evaluation.disbursement.adherent']) }}">
        <a href="{{ route('monitored-evaluation.disbursement.cohorts') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-lock-open'></i>
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
@endif

{{-- PARTNER EMPLOYMENT --}}
@if (can('partner-employment'))
    {{-- Offres d'emploies --}}
    <li class="menu-item {{ routeActive(['job.index', 'job.create']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-briefcase'></i>
            <div>Offres d'emploies</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem('job.create') }}">
                <a href="{{ route('job.create') }}" class="menu-link">
                    <div>Ajouter </div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('job.index') }}">
                <a href="{{ route('job.index') }}" class="menu-link">
                    <div>Voir </div>
                </a>
            </li>
        </ul>
    </li>
@endif
