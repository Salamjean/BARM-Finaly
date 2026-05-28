
@if (request('roles')!= 'candidat' || request('roles') == $selectedRole)
    @include('layouts.inc.marquee')
@endif

<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme navbar-elevated"
    @if (role() == 'candidat') style="background-color:#ECAD00 !important;" @endif id="layout-navbar">
    <div class="container-xxl">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                @if (role() != 'candidat')
                    <i class="bx bx-menu bx-sm"></i>
                @endif
            </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            @if (role() == 'candidat')
                <a href="{{ route('dashboard') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <a href="{{ route('dashboard') }}" class="app-brand-link">
                            <img src="{{ asset(setting('app_logo')) }}" alt="" width="50" height="50"
                                srcset="">
                        </a>
                    </span>
                    <span class="app-brand-text demo menu-text fw-bold ms-2 text-white">BARM</span>
                </a>
            @endif
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <small class="fw-bold">{{ Auth::user()->username }}</small>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets/img/avatars/avatar.png') }}" alt class="rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('assets/img/avatars/avatar.png') }}" alt
                                                class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span
                                            class="fw-medium d-block lh-1">{{ Auth::user()->fullName() }}</span>
                                        <small>{{ roleFr(Auth::user()->roles->first()->name) }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        @if (role() != 'candidat')
                            <li>
                                <a class="dropdown-item" href="{{ route('profil.edit') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">Mon profile</span>
                                </a>
                            </li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Se déconnecter</span></a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
            <input type="text" class="form-control search-input border-0" placeholder="Recherche..."
                aria-label="Recherche...">
            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
        </div>
    </div>
</nav>
