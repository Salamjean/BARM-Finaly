<div class="theme-main-menu sticky-menu theme-menu-one">
    <div class="inner-content">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex logo order-lg-0"><a href="" class="d-block"><img src="{{asset(setting('app_logo'))}}" alt=""
                        style="height:auto; width: 74px;"></a></div>
            <div class="right-wiget d-lg-flex align-items-center order-lg-3 ">
                @auth
                    <div class="sign-up"><a class="custom-btn  bouton_color" href="{{ route('dashboard') }}">Tableau de bord</a></div>
                @endauth
                @guest
                    <div class="sign-up"><a class="custom-btn  bouton_color" href="{{ url('/login') }}">Connexion</a></div>
                @endguest
            </div>
            <!-- ================================================
                            nav bar start
     ================================================ -->
            <div class="left-wiget">
                <nav class="navbar navbar-expand-lg order-lg-2">
                    <button class="navbar-toggler d-block d-lg-none" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ url()->current() == route('acceuil') ? 'active' : '' }}" href="{{route('acceuil')}}">
                                    Accueil
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ url()->current() == route('about') ? 'active' : '' }}" href="{{ route('about') }}">Le BARM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ url()->current() == route('offres') ? 'active' : '' }}" href="{{ route('offres') }}">Offres d'emploi</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link {{ url()->current() == route('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>
                        @guest
                            <div class="right-wiget d-flex align-items-center order-lg-3 d-lg-none ">
                                <div class="people"><a href=""><img src="images/icon/user.svg" alt=""></a>
                                </div>
                                <div class="sign-up"><a class="custom-btn bouton_color"
                                        href="{{ url('/login') }}">Connexion</a>
                                </div>
                            </div>
                        @endguest
                        @auth
                            <div class="right-wiget d-flex align-items-center order-lg-3 d-lg-none ">
                                <div class="people"><a href=""><img src="images/icon/user.svg" alt=""></a>
                                </div>
                                <div class="sign-up"><a class="custom-btn bouton_color"
                                        href="{{ route('dashboard') }}">Tableau de bord</a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </nav>
            </div>
            <!-- //header nav  -->
            <!-- ================================================
      nav bar start
     ================================================ -->
        </div>
    </div>
</div>
