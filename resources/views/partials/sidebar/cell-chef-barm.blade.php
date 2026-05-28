@if (can('chef-barm|c2d|memdef'))

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

    <li class="menu-item {{ routeActive('search.index') }}">

        <a href="{{ route('search.index') }}" class="menu-link">
            <i class='bx bxs-search'></i>&nbsp;&nbsp;
            <div>Recherche</div>
        </a>
    </li>

    <li class="menu-item">
        <div class="menu-link text-primary">
            <div>Auto Emploi</div>
        </div>
    </li>

    <li
        class="menu-item {{ routeActive(['adherent.create', 'adherent.steps', 'adherent.pending', 'adherent.list', 'adherent.resignations', 'adherent.deaths']) }}">
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
    <li
        class="menu-item {{ routeActive(['sessioncollectives.create', 'sessioncollectives.index', 'sessioncollectives.show', 'sessioncollectives.edit', 'candidaturevalidated', 'candidaturepresent', 'listecandidature', 'candidaturevalidated', 'listecandidatureprovisoire']) }}">
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
                    <div>Liste des candidats présents aux sessions</div>
                </a>
            </li>
        </ul>
    </li>

    <li
        class="menu-item {{ routeActive(['profilage.profilage', 'profilage.index_profilage', 'profilage.create_profilage', 'profilage.candidat_profilage', 'profilage.end_candidat_profile']) }}">
        <a href="{{ route('profilage.profilage') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-cross'></i>
            <div>Profilages</div>
        </a>
    </li>

    <li class="menu-item {{ routeActive(['cohort.personal.training']) }}">
        <a href="{{ route('cohort.personal.training') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-layer'></i>
            <div>Formations</div>
        </a>
    </li>

    <li
        class="menu-item {{ routeActive(['commissions.cohorte', 'commissions.create', 'commissions.index', 'commissions.candidat_commission']) }}">
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
    

    <li
        class="menu-item {{ routeActive(['monitored-evaluation.disbursement.cohorts', 'monitored-evaluation.disbursement.cohort', 'monitored-evaluation.disbursement.adherent']) }}">
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
    <li
        class="menu-item {{ routeActive(['monitored-evaluation.post_monitored.cohorts', 'monitored-evaluation.post_monitored.cohort', 'monitored-evaluation.post_monitored.adherent']) }}">
        <a href="{{ route('monitored-evaluation.post_monitored.cohorts') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-folder-open'></i>
            <div class="d-flex justify-content-between">
                <div>Suivi post-financement</div>
            </div>
        </a>
    </li>



    <li class="menu-item">
        <div class="menu-link text-primary">
            <div>Entreprise privée</div>
        </div>
    </li>
    <li
        class="menu-item {{ routeActive(['candidatentreprises.index', 'candidatentreprises.show', 'candidatentreprises.mise_a_disposition']) }}">
        <a href="{{ route('candidatentreprises.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-briefcase'></i>
            <div>Mise à disposition</div>
        </a>
    </li>

    <li class="menu-item {{ routeActive(['monitored-evaluation.post_monitored.candidats_ep']) }}">
        <a href="{{ route('monitored-evaluation.post_monitored.candidats_ep') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-folder-open'></i>
            <div class="d-flex justify-content-between">
                <div>Suivi post-insertion</div>
            </div>
        </a>
    </li>

    <li class="menu-item">
        <div class="menu-link text-primary">
            <div>Fonction publique</div>
        </div>
    </li>
    <li
        class="menu-item {{ routeActive(['inscriptionconcours.candidatsadmis', 'inscriptionconcours.candidatsajournes']) }}">
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

    <li class="menu-item {{ routeActive(['monitored-evaluation.post_monitored.candidats_fp']) }}">
            <a href="{{ route('monitored-evaluation.post_monitored.candidats_fp') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-folder-open'></i>
                <div class="d-flex justify-content-between">
                    <div>Suivi post-insertion</div>
                </div>
            </a>
        </li>

@endif