@extends('front.layouts.app')
@section('content')
    <div class="about-us-banner mb-160 md-mb-100">
        <div class="about-three-rapper position-relative">
            <img src="images/shape/shape-2.png" alt="" class="shape shape-12">
            <img src="images/shape/shape-3.png" alt="" class="shape shape-13">
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center flex-column text-center">
                    <div class="d-flex align-items-center justify-content-center mt-240 md-mt-100">
                        <h1 class="mb-30">Candidater aux meilleurs offres d'emploi.</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="job-details mb-160 md-mb-80">
        <div class="job-details-rapper">
            <div class="container">
                <div class="row g-5 d-flex align-items-start justify-content-center">
                    <div class="col-lg-4">
                        <div class="job-details-left d-flex flex-column justify-content-center">
                            <div class="left-1">
                                <img src="{{asset('front/images/logotest.png')}}" alt="">
                                <strong>{{ $job->user->fullName() }}</strong>
                                <p class="mt-30">Dramatically envisioneer interactive leader ship through functionalized .
                                </p>
                            </div>
                            {{-- <div class="left-1 pt-40">
                                <p class="mb-20">Job Posted</p>
                                <span>3 Jobs</span>
                            </div>
                            <div class="left-1 pt-40">
                                <p class="mb-20">Number Of Employee</p>
                                <span style="font-size:18px">50-100</span>
                            </div>--}}
                            <div class="left-1 pt-40">
                                <p class="mb-20">Téléphone</p>
                                <span style="font-size:18px">{{ $job->phone_number }}</span>
                            </div>
                            <div class="left-1 pt-40">
                                <p class="mb-20">Email</p>
                                <span style="font-size:18px">{{ $job->email }}</span>
                            </div>
                            <div class="left-1 pt-40">
                                <p class="mb-20">Lieu du travail</p>
                                <span style="font-size:18px">{{$job->location}}</span>
                            </div>
                            <div class="left-1 pt-30">
                                <p class="mb-20">Reference</p>
                                <span style="font-size:18px">{{$job->reference}}</span>
                            </div>
                             <div class="left-1 pt-40">
                                <p class="mb-20">Type de contract</p>
                                <span style="font-size:18px">{{$job->job_type}}</span>
                            </div>
                            <div class="left-1 pt-40">
                                <p class="mb-20">Nombre de poste</p>
                                <span style="font-size:18px">{{$job->number}}</span>
                            </div> 
                            <div class="left-1 pt-30">
                                <p class="mb-20">Date de cloture</p>
                                <span style="font-size:18px">{{$job->end_date}}</span>
                            </div>
                            <div class="left-1 pt-40">
                                <p class="mb-20">Diplôme</p>
                                <span>
                                    @foreach (json_decode($job->educations, true) as $educations)
                                        <span style="font-size:18px">{{ $educations }}</span><br><br>
                                    @endforeach
                                </span>
                            </div>
                            <div class="left-1 pt-10">
                                <p class="mb-20">Sexe</p>
                                <span>
                                        @foreach (json_decode($job->genders, true) as $genders)
                                            <span style="font-size:18px">{{ $genders }}</span>
                                        @endforeach
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="job-details-right">
                            <div class="job-list-1 md-pt-40">
                                <div class="list-company pb-20 g-5 d-flex align-items-center justify-content-between">
                                    <img src="{{asset('front/images/logotest.png')}}" alt="">
                                    {{-- <span>$5000<small>/Month</small></span> --}}
                                </div>
                                <div class="job-list-name d-flex pt-20 align-items-center justify-content-between">
                                    <div class="d-flex flex-column align-items-start justify-content-start">
                                        <h4>{{ $job->title }}</h4>
                                        <div class="mt-20">
                                            <span><i class="bi bi-geo-alt"></i></span>
                                            <span>{{ $job->location}}</span>
                                            <span><i class="bi bi-clock"></i></span>
                                            <span>{{ $job->job_type }}</span>
                                        </div>
                                    </div>
                                    <div class="job-apply d-flex align-items-center justify-content-center">
                                        <a class="" href="{{url('/login')}}">Postuler</a>
                                    </div>
                                </div>
                            </div>
                            <div class="job-list-details d-flex flex-column pt-60">
                                <h4 class="">Description du poste</h4>
                                <p>{!! $job->description !!}</p>
                                
                                <h4>Compétences:</h4>
                                    <ul>
                                        @foreach (json_decode($job->skills, true) as $skill)
                                            <li>{{ $skill['value'] }}</li>
                                        @endforeach
                                    </ul>


                                <div class="btn-group me-auto">
                                @if ($skills !== null)
                                    @foreach ($skills as $skill)
                                        <a href="#" class="btn btn-primary">{{ $skill['value'] }}</a>
                                    @endforeach
                                @endif
                                </div>
                                <div class="job-social-link d-flex align-items-center justify-content-between mt-60">
                                    <a href="{{url('/login')}}" class="apply-btn">Postuler</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   {{--<section class="recent-job mb-160 md-mb-80">
        <div class="recent-job-rapper">
            <div class="container">
                <div class="feature-job-title">
                    <h3 class="heading-3 mb-80">Offres Récentes</h3>
                </div>
                <div class="recent-job-slider " id="recent-job-slider">

                    <div class="recent-job-item">
                        <div class="row pt-30 px-0 g-5">
                            <div class="col">
                                <div class="job-1 d-flex flex-column">
                                    <div class="job-company">
                                        <div class="company-name">
                                            <img src="images/slider/slider-1.png" alt="">
                                            <span>Remote</span>
                                        </div>
                                        <div class="company-taq">
                                            <i class="bi bi-bookmark"></i>
                                        </div>
                                    </div>
                                    <div class="job-title">
                                        <h3>Sr. UX/UI Designer</h3>
                                    </div>
                                    <div class="job-type">
                                        <span><i class="bi bi-geo-alt"></i></span>
                                        <span>United States</span>
                                        <span><i class="bi bi-clock"></i></span>
                                        <span>Full-Time</span>
                                    </div>
                                    <div class="job-sallary pt-20">
                                        <span><strong>$5000</strong>/Month</span>
                                        <a href="" class="">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>--}}

@endsection
