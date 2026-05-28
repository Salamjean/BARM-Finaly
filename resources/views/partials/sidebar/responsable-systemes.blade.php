{{-- SIDEBAR POUR RESPONSABLE DES SYSTÈMES DE L'INFORMATION --}}
@if (can('responsable-des-systemes-de-l-information'))

    {{-- Personnels --}}
    <li class="menu-item {{ routeActive('personnel.index') }}">
        <a href="{{ route('personnel.index') }}" class="menu-link">
            <i class='bx bxs-group'></i>&nbsp;&nbsp;
            <div>Personnels</div>
        </a>
    </li>

    {{-- Partnaires --}}
    <li class="menu-item {{ routeItem('partenaire.index') }}">
        <a href="{{ route('partenaire.index') }}" class="menu-link">
            <i class='bx bxs-parking'></i>&nbsp;&nbsp;
            <div>Partnaires</div>
        </a>
    </li>

    {{-- Recherche --}}
    <li class="menu-item {{ routeActive('search.index') }}">
        <a href="{{ route('search.index') }}" class="menu-link">
            <i class='bx bxs-search'></i>&nbsp;&nbsp;
            <div>Recherche</div>
        </a>
    </li>

@endif
