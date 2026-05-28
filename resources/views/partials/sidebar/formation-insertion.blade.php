{{-- SIDEBAR POUR CELLULE FORMATION ET INSERTION --}}
@if (can('conseiller-auto-emploi|conseiller-entreprise-prive|conseiller-fonction-public|conseiller-en-reconversion') ||
        can('chef-cellule-formation-et-insertion'))

    {{-- Adhérent --}}
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
            <li class="menu-item {{ routeItem('adherent.create', '0') }}">
                <a href="{{ route('adherent.create') }}" class="menu-link">
                    <div>Faire une inscription</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('adherent.steps') }}">
                <a href="{{ route('adherent.steps') }}" class="menu-link">
                    <div>Candidature en cours </div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('adherent.pending') }}">
                <a href="{{ route('adherent.pending') }}" class="menu-link">
                    <div>En attente d'approbation </div>
                </a>
            </li>
            @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))
                <li class="menu-item {{ routeItem('adherent.list.pending_cohort') }}">
                    <a href="{{ route('adherent.list.pending_cohort') }}" class="menu-link">
                        <div>Adhérents sans cohorte </div>
                    </a>
                </li>
            @endif
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
                    <div>Liste des préinscriptions</div>
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

    {{-- Recherche --}}
    @if (can('conseiller-entreprise-prive') ||
            can('point-focal') ||
            can('conseiller-fonction-public') ||
            can('conseiller-auto-emploi') ||
            can('chef-cellule-formation-et-insertion'))
        <li class="menu-item {{ routeActive('search.index') }}">
            <a href="{{ route('search.index') }}" class="menu-link">
                <i class='bx bxs-search'></i>&nbsp;&nbsp;
                <div>Recherche</div>
            </a>
        </li>
    @endif

    {{-- Lettre de recommandation --}}
    <li class="menu-item {{ routeActive(['lettresrecommandations.index', 'lettresrecommandations.create']) }}">
        <a href="{{ route('lettresrecommandations.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-folder-open'></i>
            <div class="d-flex justify-content-between">
                <div>Lettre de recommandation</div>
            </div>
        </a>
    </li>

    {{-- Candidatures spontannées --}}
    <li
        class="menu-item {{ routeActive(['candidatentreprises.candidats', 'candidatentreprises.show_candidatentreprise', 'candidatentreprises.create_candidatentreprise']) }}">
        <a href="{{ route('candidatentreprises.candidats') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-fast-forward'></i>
            <div>Candidatures spontannées</div>
        </a>
    </li>

    {{-- Offres d'emplois --}}
    <li
        class="menu-item {{ routeActive(['offreemplois.index', 'offreemplois.create', 'offreemplois.show', 'offreemplois.update']) }}">
        <a href="{{ route('offreemplois.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-fast-forward'></i>
            <div>Offres d'emplois</div>
        </a>
    </li>

    {{-- SECTION AUTO EMPLOI (COLLAPSIBLE) --}}
    <li class="menu-item section-collapsible">
        <a href="javascript:void(0);" class="menu-link section-header">
            <i class='menu-icon tf-icons bx bx-chevron-right section-icon'></i>
            <div class="text-primary fw-bold">Auto Emploi</div>
        </a>
        <ul class="menu-sub section-content" style="display: none;">
            {{-- Cohorte --}}
            <li class="menu-item {{ routeActive(['cohort.create', 'cohort.index']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bx-layer'></i>
                    <div>Cohorte</div>
                </a>
                <ul class="menu-sub">
                    @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                        <li class="menu-item {{ routeItem('cohort.create') }}">
                            <a href="{{ route('cohort.create') }}" class="menu-link">
                                <div>Ajouter</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item {{ routeItem('cohort.index') }}">
                        <a href="{{ route('cohort.index') }}" class="menu-link">
                            <div>Liste</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Sessions Collectives --}}
            <li
                class="menu-item {{ routeActive(['sessioncollectives.create', 'sessioncollectives.index', 'sessioncollectives.show', 'sessioncollectives.edit', 'candidaturevalidated','candidaturevalidated', 'listecandidatureprovisoire']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-universal-access'></i>
                    <div>Sessions Collectives</div>
                </a>
                <ul class="menu-sub">
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
            <li
                class="menu-item {{ routeActive(['profilage.profilage', 'profilage.index_profilage', 'profilage.create_profilage', 'profilage.candidat_profilage', 'profilage.end_candidat_profile', 'listecandidaturerefuser', 'listecandidature', 'profilage.candidats_absents', 'profilage.candidats_refuses']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bx-briefcase'></i>
                    <div>Profilages</div>
                </a>
                <ul class="menu-sub">
                    {{-- <li class="menu-item {{ routeItem('profilage.profilage') }}">
                        <a href="{{ route('profilage.profilage') }}" class="menu-link">
                            <div>Liste des sessions organisées</div>
                        </a>
                    </li>
                    --}}
                    <li class="menu-item {{ routeItem('listecandidature') }}">
                        <a href="{{ route('listecandidature') }}" class="menu-link">
                            <div>Liste des candidats profilés</div>
                        </a>
                    </li>
                    @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                        {{-- <li class="menu-item {{ routeItem('listecandidaturerefuser') }}">
                            <a href="{{ route('listecandidaturerefuser') }}" class="menu-link">
                                <div>Liste des candidats non profilés</div>
                            </a>
                        </li> --}}
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
                    @endif
                </ul>
            </li>

            

            {{-- Formations --}}
            <li class="menu-item {{ routeActive(['cohort.personal.training']) }}">
                <a href="{{ route('cohort.personal.training') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-layer'></i>
                    <div>Formations</div>
                </a>
            </li>

            {{-- Plan d'affaire --}}
            @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                <li class="menu-item {{ routeActive(['pre_commission.pending', 'pre_commission.in_progress']) }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class='menu-icon tf-icons bx bxs-timer'></i>
                        <div class="d-flex justify-content-between">
                            <div>Plan d'affaire</div>
                            @if ($focal_point_area_count > 0)
                                <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                                    style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                                    {{ $focal_point_area_count }}
                                </span>
                            @endif
                        </div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ routeItem('pre_commission.pending') }}">
                            <a href="{{ route('pre_commission.pending') }}" class="menu-link">
                                <div>En attente (point focal)</div>
                            </a>
                        </li>
                        <li class="menu-item {{ routeItem('pre_commission.in_progress') }}">
                            <a href="{{ route('pre_commission.in_progress') }}" class="menu-link">
                                <div>En attente (commission) </div>
                            </a>
                        </li>
                        <li class="menu-item {{ routeItem('pre_commission.validated') }}">
                            <a href="{{ route('pre_commission.validated') }}" class="menu-link">
                                <div>Validés</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- Commission d'approbation --}}
            <li
                class="menu-item {{ routeActive(['commissions.cohorte', 'commissions.create', 'commissions.index', 'commissions.candidat_commission']) }}">
                <a href="{{ route('commissions.cohorte') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-calendar-check'></i>
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

            {{-- Ouverture de compte --}}
            @if (can('chef-cellule-formation-et-insertion|conseiller-auto-emploi'))
                <li
                    class="menu-item {{ routeActive(['monitored-evaluation.account_opening.cohorts', 'monitored-evaluation.account_opening.cohort.plug_removal']) }}">
                    <a href="{{ route('monitored-evaluation.account_opening.cohorts') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bx-lock-open-alt'></i>
                        <div class="d-flex justify-content-between">
                            <div class="me-2">Ouverture de compte</div>
                            @if ($account_opening_pending_count > 0)
                                <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                                    style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                                    {{ $account_opening_pending_count }}
                                </span>
                            @endif
                        </div>
                    </a>
                </li>
            @endif

            {{-- Decaissements --}}
            <li
                class="menu-item {{ routeActive(['monitored-evaluation.disbursement.cohorts', 'monitored-evaluation.disbursement.cohort', 'monitored-evaluation.disbursement.adherent']) }}">
                <a href="{{ route('monitored-evaluation.disbursement.cohorts') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-credit-card'></i>
                    <div class="d-flex justify-content-between">
                        <div>Decaissements</div>
                        @if (disbursementPendingCountByUser() > 0)
                            <span class="ms-2 bg-primary text-white fw-bold rounded px-2"
                                style="font-size: 11px; height: 18px; line-height: 18px; display: inline-block; vertical-align: middle;">
                                {{ disbursementPendingCountByUser() }}
                            </span>
                        @endif
                    </div>
                </a>
            </li>

            {{-- Suivi post-financement --}}
            <li
                class="menu-item {{ routeActive(['monitored-evaluation.post_monitored.cohorts', 'monitored-evaluation.post_monitored.cohort', 'monitored-evaluation.post_monitored.adherent']) }}">
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
            @if (can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                <li class="menu-item {{ routeActive(['candidatentreprises.suivie_ep_candidats']) }}">
                    <a href="{{ route('candidatentreprises.suivie_ep_candidats') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-school'></i>
                        <div>Suivie des candidats</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ routeActive(['entretiens.index', 'entretiens.create', 'entretiens.presence', 'entretiens.candidats']) }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class='menu-icon tf-icons bx bxs-comment'></i>
                        <div>Entretien candidat</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('entretiens/index/collectif') ? 'active' : '' }}">
                            <a href="{{ route('entretiens.index', 'collectif') }}" class="menu-link">
                                <div>Entretiens collectif</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('entretiens/index/perso') ? 'active' : '' }}">
                            <a href="{{ route('entretiens.index', 'perso') }}" class="menu-link">
                                <div>Entretiens individuel</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ routeActive(['bilancompetences.candidats']) }}">
                    <a href="{{ route('bilancompetences.candidats') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-graduation'></i>
                        <div>Bilan de compétence</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ routeActive(['entreprises.index', 'entreprises.create', 'entreprises.show', 'entreprises.edit']) }}">
                    <a href="{{ route('entreprises.index') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-school'></i>
                        <div>Entreprises</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ routeActive(['formations.index', 'formations.create', 'formations.presence']) }}">
                    <a href="{{ route('formations.index') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-file-doc'></i>
                        <div>Formations</div>
                    </a>
                </li>

                <li class="menu-item {{ routeActive(['cvlms.candidats', 'cvlms.index', 'cvlms.create']) }}">
                    <a href="{{ route('cvlms.candidats') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bx-user-circle'></i>
                        <div>CV et LM</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ routeActive(['prepaentretiens.index', 'prepaentretiens.candidats', 'prepaentretiens.create']) }}">
                    <a href="{{ route('prepaentretiens.candidats') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxl-kubernetes'></i>
                        <div>Prepa-entretien</div>
                    </a>
                </li>
            @endif

            {{-- Mise à disposition --}}
            <li
                class="menu-item {{ routeActive(['candidatentreprises.index', 'candidatentreprises.show', 'candidatentreprises.mise_a_disposition']) }}">
                <a href="{{ route('candidatentreprises.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-briefcase'></i>
                    <div>Mise à disposition</div>
                </a>
            </li>

            {{-- Suivi post-insertion EP --}}
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

    {{-- SECTION FONCTION PUBLIC (COLLAPSIBLE) --}}
    <li class="menu-item section-collapsible">
        <a href="javascript:void(0);" class="menu-link section-header">
            <i class='menu-icon tf-icons bx bx-chevron-right section-icon'></i>
            <div class="text-primary fw-bold">Fonction public</div>
        </a>
        <ul class="menu-sub section-content" style="display: none;">
            @if (can('conseiller-fonction-public') || can('chef-cellule-formation-et-insertion'))
                <li class="menu-item {{ routeActive(['candidatentreprises.suivie_fp_candidats']) }}">
                    <a href="{{ route('candidatentreprises.suivie_fp_candidats') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-school'></i>
                        <div>Suivie des candidats</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ routeActive(['entretiens.indexfp', 'entretiens.createfp', 'entretiens.presence', 'entretiens.candidats']) }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class='menu-icon tf-icons bx bxs-comment'></i>
                        <div>Entretien candidat</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('entretiens/indexfp/collectif') ? 'active' : '' }}">
                            <a href="{{ route('entretiens.indexfp', 'collectif') }}" class="menu-link">
                                <div>Entretiens collectif</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('entretiens/indexfp/perso') ? 'active' : '' }}">
                            <a href="{{ route('entretiens.indexfp', 'perso') }}" class="menu-link">
                                <div>Entretiens individuel</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ routeActive(['bilancompetences.candidatsfp']) }}">
                    <a href="{{ route('bilancompetences.candidatsfp') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-graduation'></i>
                        <div>Bilan de compétence</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ routeActive(['soumissiondossiers.candidats', 'soumissiondossiers.index', 'soumissiondossiers.create']) }}">
                    <a href="{{ route('soumissiondossiers.candidats') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-file-doc'></i>
                        <div>Dépots de dossiers</div>
                    </a>
                </li>

                <li class="menu-item {{ routeActive(['soumissiondossiers.choixconcours']) }}">
                    <a href="{{ route('soumissiondossiers.choixconcours') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-file-doc'></i>
                        <div>Choix final</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ routeActive(['inscriptionconcours.candidats', 'inscriptionconcours.index', 'inscriptionconcours.create']) }}">
                    <a href="{{ route('inscriptionconcours.candidats') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bxl-kubernetes'></i>
                        <div>Inscription à un concours</div>
                    </a>
                </li>
            @endif

            {{-- Resultats aux concours --}}
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

            {{-- Suivi post-insertion FP --}}
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
