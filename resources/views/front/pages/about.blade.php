@extends('front.layouts.app')
@section('content')
    <div class="about-us-banner mb-160 md-mb-100">
        <div class="about-three-rapper position-relative">
            <img src="images/shape/shape-2.png" alt="" class="shape shape-12">
            <img src="images/shape/shape-3.png" alt="" class="shape shape-13">
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center flex-column text-center mb-60">
                    <div class="d-flex align-items-center justify-content-center mt-240 md-mt-100">
                        <h1 class="mb-30">PRESENTATION</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =========================================
        .about us start 5
        ============================================= -->
    <section class="why-choose-us mb-160 md-mb-120">
        <div class="container">
            <div class="why-choose-us-rapper position-relative">
                <!-- >>>shapes -->
                <img src="{{ asset('front/images/shape/shape-5.png') }}" alt="" class="shape shape-5">
                <img src="{{ asset('front/images/shape/shape-5.png') }}" alt="" class="shape shape-6">
                <img src="{{ asset('front/images/shape/shape-5.png') }}" alt="" class="shape shape-7">
                <div class="row d-flex align-items-center justify-content-center">
                    <!-- shapes/// -->
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-xl-5 left-choose-content">
                            <div class="choose-us-heading">
                                <span class="span-one">A propos de nous</span>
                                <h2 class="text-justify mb-20 mt-20 heading" style="font-size: 38px;line-height: 48px;">
                                    Bureau d’Accompagnement à la
                                    Reconversion des Militaires <span>(BARM)</span></h2>
                                <p class="">Le BARM intervient dans la reconversion des militaires et gendarmes en
                                    fin de carrière.Le BARM a été créé par Arrêté N°0656 du 03 mai 2018 du Ministre
                                    d’Etat, Ministre de la Défense, pour coordonner toutes les activités liées à la
                                    préparation, l’organisation, l’évaluation et le suivi des projets de
                                    reconversion des Militaires.</p>
                                <!-- <ul class="mb-30 mt-30">
                                                    <li><span><i class="bi bi-shield-check"></i></span><a href="">Payment Gateway
                                                            Secure</a></li>
                                                    <li><span><i class="bi bi-file-earmark-arrow-up"></i></span><a href="">Quick
                                                            Delivery & Fast Load</a></li>
                                                    <li><span><i class="bi bi-clock"></i></span><a href="">Work Per Hour &
                                                            Screenshots</a></li>
                                                </ul> -->
                                <a href="" class="custom-btn bouton_color">Voir plus</a>
                            </div>
                        </div>
                        <div class="col-xl-6 offset-xl-1 lg-mt-80 md-mt-80">
                            <div class="right-choose-content position-relative">
                                <img src="{{ asset('front/images/barmphoto.jfif') }}" alt="" class="img-fluid"
                                    style="height: 600px;">
                                <span style="background: rgba(210, 110, 5, 1) !important;"></span>
                                <span style="background: #FFFFFF !important;"></span>
                                <span style="background: rgba(1, 128, 78, 1) !important;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =========================================
            .about us end
        ============================================= -->
    <div class="staticties mb-80 md-mb-80 parallax"
        style="background-image: url({{ asset('front/images/paralax_option.jpg') }}); height: 277px;">
        <div class="container">
            <div class="row d-flex align-items-center pt-80 pb-80">
                <div class="col-lg-3 md-mb-50">
                    <div class="statistics-1 d-flex align-items-center flex-column">
                        <div class="top" style="color:#d26e05 !important"><span class="counter">14.6</span>K</div>
                        <div class="bottom" style="color:#d26e05 !important; font-weight: 700;"><span
                                class="">Personnes
                                accompagnées</span></div>
                    </div>
                </div>
                <div class="col-lg-3 md-mb-50">
                    <div class="statistics-1 d-flex align-items-center flex-column">
                        <div class="top" style="color:#d26e05 !important"><span class="counter">12.6</span>K</div>
                        <div class="bottom" style="color:#d26e05 !important; font-weight: 700;"><span
                                class="">Projects
                                réalisés</span></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="statistics-1 d-flex align-items-center flex-column">
                        <div class="top" style="color:#d26e05 !important"><span class="counter">14.7</span>K</div>
                        <div class="bottom" style="color:#d26e05 !important; font-weight: 700;"><span
                                class="">Personnes
                                réinsérées</span></div>
                    </div>
                </div>
                <div class="col-lg-3 md-mb-50">
                    <div class="statistics-1 d-flex align-items-center flex-column">
                        <div class="top" style="color:#d26e05 !important"><span class="counter">25</span>+</div>
                        <div class="bottom" style="color:#d26e05 !important; font-weight: 700;"><span
                                class="">Partenaires</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="about-us mb-160 md-mb-80">
        <div class="container">
            <div class="about-us-rapper position-relative">
                <img src="images/shape/shape-5.png" alt="" class="shape shape-5">
                <img src="images/shape/shape-6.png" alt="" class="shape shape-6">
                <img src="images/shape/shape-6.png" alt="" class="shape shape-7">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-6 col-xl-6">
                        <div class="left-about left-about-us position-relative">
                            <img src="{{ asset('front/images/banner/banner-14.png') }}" alt="" class="">
                            <img src="{{ $dg->image ?? '' }}" alt="" class=""
                                style="height:681px !important;">
                            <!-- <img src="images/screen/screen-14.png" alt="" class="">
        <img src="images/screen/screen-24.png" alt="" class="">
        <img src="images/screen/screen-9.png" alt="" class=""> -->
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-5 offset-lg-1 offset-xl-1 md-mt-80">
                        <div class="right-about-two">
                            <span class="span-two">Mots du Directeur Général</span>
                            <p class="mt-20 mb-30">Marquer son existence, sa capacité à répondre à des besoins spécifiques
                                par des approches innovantes, éprouvées et
                                pointues exprime la capacité d’une organisation à se mettre à la hauteur des attentes de ses
                                partenaires, de ses
                                usagers. A cet effet, toute une palette d’outils nous est mise à disposition par les
                                technologies de l’information et de
                                la communication. Notre entreprise, le BUREAU D’ACCOMPAGNEMENT A LA RECONVERSION DES
                                MILITAIRES (BARM) qui l’a si bien compris a
                                entrepris de vous offrir, chers internautes, une nouvelle expérience numérique en mettant à
                                votre disposition ce site
                                web qui porte l’ambition de vous ouvrir grandement nos portes, de partager nos actions et
                                nos initiatives pour
                                contribuer à relever les défis…</p>
                            <!-- <a href="About_Us.html">More Details</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="watch_Our_video mt-260 md-mt-80">
        <div class="container">
            <div class="row">
                <div class="our_video_rapper">
                    <div class="video-top d-flex align-items-start justify-content-evenly flex-column">
                        <span>Regardez notre vidéo</span>
                        <h5 class="mt-20">Trouvez l'emploi de vos rêves</h5>
                    </div>
                    <div class="video-icon d-flex align-items-center justify-content-center">
                        <a class="watch-video" href="{{ asset('front/images/videobarm.mp4') }}"><i
                                class="bi bi-play-circle"></i></a>
                    </div>
                    <img src="{{ asset('front/images/barm_member.jpg') }}" alt="" class=""
                        style="height:550px !important; width:1320px !important;">
                </div>
            </div>
        </div>
    </section>
    <section class="our_team mt-80 md-mt-80 pb-80">
        <div class="container">
            <div class="team-heading text-justify pt-80 mb-80">
                <span class="span-two">Notre équipe</span>
                <h3 class="mt-20 mb-20">ÉQUIPE DIRIGEANTE</h3>
            </div>
            <div class="our_team_slider" id="our_team_slider">
                @foreach ($teams as $team)
                    <div class="our_team_item">
                        <div class="row">
                            <div class="col">
                                <div class="card ">
                                    <img src="{{ asset($team->image) }}" alt="">
                                    <div class="social_group">
                                        <ul>
                                            @if ($team->facebook)
                                                <li><a href="{{ $team->facebook }}" target="_blank"><i
                                                            class="fab fa-facebook-f"></i></a></li>
                                            @endif
                                            @if ($team->x)
                                                <li><a href="{{ $team->x }}" target="_blank"><i
                                                            class="fab fa-twitter"></i></a></li>
                                            @endif
                                            @if ($team->insta)
                                                <li><a href="{{ $team->insta }}" target="_blank"><i
                                                            class="fab fa-instagram"></i></a></li>
                                            @endif
                                            @if ($team->linkedin)
                                                <li><a href="{{ $team->linkedin }}" target="_blank"><i
                                                            class="fab fa-linkedin"></i></a></li>
                                            @endif

                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <h5>{{ $team->name }}</h5>
                                        <span>{{ $team->job }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="Partner mt-80">
        <div class="container">
            <div class="partner-text">
                <h3 class="heading text-center">Nos <span>Partenaires</span></h3>
            </div>
            <div class="row">
                <div class="main-content pt-60 pb-160 md-pb-80">
                    <div id="partner_slider" class="">
                        @foreach ($partners as $partner)
                            <div class="item"><img src="{{ asset($partner->image) }}" alt=""
                                    style="height:200px !important; width:200px !important"></div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
