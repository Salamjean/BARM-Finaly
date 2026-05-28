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
                    <div class="d-flex align-items-center justify-content-center mt-60">
                        <form class="form-3 d-flex align-items-center justify-content-between" method="GET" action="{{ route('offres.search')}}">
                            <div class="item_1"><img src="images/icon/search.svg" alt=""></div>
                            <div class="placeholder m-5">
                                <input type="text" id="username" name="title" placeholder="Offre" data-value="" required>
                            </div>
                            <div class="location d-flex">
                                <img src="images/icon/map.svg" alt="">
                                
                                <select class="nice-select " name="location">
                                    <option value="0" data-display="Location.." selected disabled>Lieu..</option>
                                    @foreach( CITIES as $city)
                                    <option value="{{$city}}">{{$city}}</option>  
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="button">
                                <button type="submit"  class="bouton_color custom-btn"><span>Rechercher</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================================
    			 banner section end
    			 ===========================  -->
    <!-- =========================================
    			.FEATURED JOBS   6
    			============================================= -->
    <section class="feature-job-list mb-160 md-mb-80">
        <div class="feature-job-list-rapper">
            <div class="container">
                <div class="row d-flex align-items-start justify-content-center px-0 gx-5">
                    <div class="col-lg-4 md-pb-30" data-aos="zoom-in">
                        <div class="left-list d-flex flex-column">
                            <div class="job-type"><span>Type d'emploi</span></div>
                            <div class="job-select pt-20 pb-60" id="titles">
                                <select class="form-select" id="titleSelect" aria-label="Default select example">
                                    <option selected disabled>Selectionner.....</option>
                                    @foreach($jobs as $job)
                                    <option value="{{$job->title}}" data-content="{{ $job->content }}">{{$job->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div id="content">Contenu de l'offre ici

                            </div> -->
                                <!-- @foreach($jobs as $job)
                            <div id="jobTitles">
                                <div class="job-title">{{ $job->title }}</div>
                            </div>
                                @endforeach -->
                            <div class="experience pt-60 pb-60 d-flex flex-column">
                            {{--<strong>Niveau d'experience</strong>
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck1">
                                        <label class="form-check-label" for="flexCheck1">
                                            Expert
                                        </label>
                                    </div>
                                    <div class="right-side d-flex align-items-center justify-content-center"><span></span>
                                    </div>
                                </div>
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck2">
                                        <label class="form-check-label" for="flexCheck2">
                                            Internship
                                        </label>
                                    </div>
                                    <div class="right-side d-flex align-items-center justify-content-center"><span></span>
                                    </div>
                                </div>
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck3">
                                        <label class="form-check-label" for="flexCheck3">
                                            Senior
                                        </label>
                                    </div>
                                    <div class="right-side d-flex align-items-center justify-content-center"><span></span>
                                    </div>
                                </div>
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck4">
                                        <label class="form-check-label" for="flexCheck4">
                                            Junior
                                        </label>
                                    </div>
                                   
                                    <div class="right-side d-flex align-items-center justify-content-center"><span></span>
                                    </div>
                                </div>
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck5">
                                        <label class="form-check-label" for="flexCheck5">
                                            Regular
                                        </label>
                                    </div>
                                    <div class="right-side d-flex align-items-center justify-content-center"><span>56</span>
                                    </div>
                                </div>
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck6">
                                        <label class="form-check-label" for="flexCheck6">
                                            Internship
                                        </label>
                                    </div>
                                    <div class="right-side d-flex align-items-center justify-content-center"><span>33</span>
                                    </div>
                                </div>--}}
                                <!-- <div class="experience pt-60 pb-60 d-flex flex-column"> -->
                                <strong>Niveau d'experience</strong>
                                @foreach($jobs as $job)
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck1">
                                        @foreach (json_decode($job->educations, true) as $educations)
                                        <label class="form-check-label" for="flexCheck1">
                                        {{ $educations }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="experience d-flex flex-column">
                                <strong>Type de contrat</strong>
                                @foreach($jobs as $job)
                                <div class="left-side pb-20 d-flex align-items-center justify-content-between">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheck11">
                                        <label class="form-check-label" for="flexCheck11">
                                            {{$job->job_type}}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="right-job-list">
                            <div class="job-list-heading  pb-40 d-flex align-items-center justify-content-between">
                                <strong>Offres disponibles</strong>
                                {{--<div class="sort-list d-flex align-items-center justify-content-around">
                                    <strong>Trier</strong>
                                    <div class="job-item job-title">
                                        <select class="form-select " aria-label="Default select example" name="title">
                                            <option value="categories......" selected disabled>categories......</option>
                                            @foreach($jobs as $job)
                                            <option value="{{$job->title}}">{{$job->title}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>--}}
                            </div>
                            @foreach ($jobs as $job)
                            <div id="content">
                                <div class="job-list-1 mb-40">
                                    <div class="list-company pb-20 d-flex align-items-center justify-content-between">
                                        <img src="{{asset('front/images/logotest.png') }}" alt="">
                                        <!-- <span>$5000<small>/Month</small></span> -->
                                    </div>
                                    <div class="job-list-name d-flex pt-20 align-items-center justify-content-between">
                                        <div class="d-flex flex-column align-items-start justify-content-start">
                                            <h4>{{ $job->title }}</h4>
                                            <div class="mt-20">
                                                <span><i class="bi bi-geo-alt"></i></span>
                                                <span>{{ $job->location }}</span>
                                                <span><i class="bi bi-clock"></i></span>
                                                <span>{{ $job->job_type }}</span>
                                            </div>
                                        </div>
                                        <div class="job-apply">
                                            <a class="" href="{{route('single_offre',$job->id)}}">Voir l'offre</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script>

$(document).ready(function() {
    $('#titleSelect').on('change', function() {
        var content = $(this).find(':selected').data('content');
        $('#content').html('Contenu pour le titre: ' + content);
    });
});

</script>