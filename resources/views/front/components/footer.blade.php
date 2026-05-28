<section class="subscribe-one pb-80">
    <div class="container">
        <div class="row g-5 d-flex align-items-center">
            <div class="col-lg-6">
                <div class="subscriber-content-left">
                    <h2 class="">Abonnez-vous à notre<br> Newsletter</h2>
                </div>
            </div>
            <div class="col-lg-6 ms-auto">
                <div class="subscriber-content-right">
                    <form class="" method="get" action="{{ route('mail.subscribe') }}">
                        <input type="email" name="email" class="" placeholder="Votre adresse e-mail" />
                        <button type="submit" class="custom_btn ms-auto bouton_color">S'abonner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="footer-one pt-80 pb-80" style="background-color: rgb(210 110 5)">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-8 col-xl-8">
                <div class="row">
                    <div class="col-lg-8 col-xl-8">
                        <div class="footer-one_1">
                            <img src="{{asset(setting('app_logo'))}}" alt="" class="pb-30" style="height:auto; width: 74px;">
                            <p class="">Le BARM intervient dans la reconversion des militaires et gendarmes en fin de carrière.Le BARM a été créé par Arrêté
                            N°0656 du 03 mai 2018 du Ministre d’Etat, Ministre de la Défense, pour coordonner toutes les activités liées à la
                            préparation, l’organisation, l’évaluation et le suivi des projets de reconversion des Militaires.</p>
                            <div class="social_group pt-40">
                                <ul>
                                    <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href=""><i class="fab fa-twitter"></i></a></li>
                                    <li><a href=""><i class="fab fa-instagram"></i></a></li>
                                    <li><a href=""><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 col-xl-4 ms-auto">
                        <div class="footer-one_2">
                            <h4 class="mb-10 md-mt-30">Quick Links</h4>
                            <ul>
                                <li><a href="">Home</a></li>
                                <li><a href="">Popular</a></li>
                                <li><a href="">Best Offer</a></li>
                                <li><a href="">Destinations</a></li>
                                <li><a href="">Changelog</a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-4 col-xl-4">
                <div class="row">
                    <div class="col-lg-6 col-xl-6">
                        <div class="footer-one_2">
                            <h4 class="mb-10 md-mt-30">Liens</h4>
                            <ul>
                                <li><a href="{{route('acceuil')}}">Accueil</a></li>
                                <li><a href="{{ route('about') }}">Presentation</a></li>
                                <li><a href="{{ route('offres') }}">Offres d'emploi</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="copy-right text-center pt-60">
                <h5 class="">Tous droits réservés ©2024 KKS-Technologies</h5>
            </div>
        </div>
    </div>
</div>

@include('partials.script.sweetalert')
