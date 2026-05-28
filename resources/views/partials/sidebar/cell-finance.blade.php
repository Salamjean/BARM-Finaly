@if (can('responsable-des-moyens-generaux'))
    <li
        class="menu-item {{ routeActive(['consommables.create', 'consommables.create', 'consommables.show', 'consommables.edit', 'entreestock.index', 'entreestock.create', 'entreestock.show', 'entreestock.edit', 'entreestock.create', 'entreestock.show', 'entreestock.edit', 'besoins.index', 'besoins.create']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-spreadsheet'></i>
            <div>Gestion de stock</div>
        </a>
        <ul class="menu-sub">


            <li class="menu-item {{ route('consommables.index') }}">
                <a href="{{ route('consommables.index') }}" class="menu-link">
                    <div>Consommables</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('entreestock.index') }}">
                <a href="{{ route('entreestock.index') }}" class="menu-link">
                    <div>Entrée de stock</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('besoins.index') }}">
                <a href="{{ route('besoins.index') }}" class="menu-link">
                    <div>Demande de consommable</div>
                </a>
            </li>
        </ul>
    </li>
@endif

@if (can('responsable-gestionnaire-des-ressources-humaines'))


    <li class="menu-item {{ routeActive('personalbarm.index') }}">

        <a href="{{ route('personalbarm.index') }}" class="menu-link">
            <i class='bx bxs-group'></i>&nbsp;&nbsp;
            <div>Personnels</div>
        </a>
    </li>

    <li
        class="menu-item {{ url()->current() == route('demande.PersonelLeave') || url()->current() == route('certificat.PersonelList') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon bx bx-book-bookmark"></i>
            <span class="menu-header-text">Gestion Administrative</span>
            @if ($leave_pending > 0)
                <div>
                    <div class="notifier new">
                        <div class="badge">{{ $leave_pending }}</div>
                    </div>
                </div>
            @endif
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ url()->current() == route('demande.PersonelLeave') ? 'active' : '' }}">
                <a href="{{ route('demande.PersonelLeave') }}" class="menu-link">
                    <div data-i18n="Demandes">&nbsp;&nbsp; Demandes</div>
                    @if ($leave_pending > 0)
                        <div>
                            <div class="notifiere newe">
                                <div class="badgee">{{ $leave_pending }}</div>
                            </div>
                        </div>
                    @endif
                </a>
            </li>
            <li class="menu-item {{ url()->current() == route('certificat.PersonelList') ? 'active' : '' }}">
                <a href="{{ route('certificat.PersonelList') }}" class="menu-link">
                    <div data-i18n="Certificats">&nbsp;&nbsp; Certificats</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('personnel.death.create') }}">
                <a href="{{ route('personnel.death.create') }}" class="menu-link">
                    <div>Déclaration de décès</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{ routeActive(['info.info-create', 'info.histo']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-check-shield'></i>
            <div data-i18n="Informations">Informations</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem('info.info-create') }}">
                <a href="{{ route('info.info-create') }}" class="menu-link">
                    <div data-i18n="Ajouter une info">Ajouter une info</div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('info.histo') }}">
                <a href="{{ route('info.histo') }}" class="menu-link">
                    <div data-i18n="Historique">Historique</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item {{ routeActive('pointing.index') }}">
        <a href="{{ route('pointing.index') }}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-time-five'></i>
            <div>Pointage</div>
        </a>
    </li>

    <li class="menu-item {{ routeActive(['trash.personalbarm']) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-trash'></i>
            <div>Corbeille</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ routeItem('trash.personalbarm') }}">
                <a href="{{ route('trash.personalbarm') }}" class="menu-link">
                    <div>Personnels</div>
                </a>
            </li>
        </ul>
    </li>
@endif
