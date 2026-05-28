@extends('layouts.app')

@push('css-push')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
@endpush
@section('content')
    @if ($step !== 'completed')
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Inscription BARM /</span>Etat Civil
                </h4>
                <div id="wizard-property-listing" class="bs-stepper vertical mt-2">
                    <div class="bs-stepper-header">
                        <div class="step {{ $step == 1 ? 'active' : '' }}">
                            <a href="{{ route('inscription.step', '1') }}" class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class='bx bx-user'></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Etat Civil</span>
                                    <span class="bs-stepper-subtitle">Informations personnelles</span>
                                </span>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="step {{ $step == 2 ? 'active' : '' }}">
                            <a href="{{ $submission->step >= 2 ? route('inscription.step', '2') : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class='bx bx-home'></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Situation Matrimoniale</span>
                                    <span class="bs-stepper-subtitle">Position familiale</span>
                                </span>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="step {{ $step == 3 ? 'active' : '' }}">
                            <a href="{{ $submission->step >= 3 ? route('inscription.step', '3') : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class='bx bx-star'></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Situation professionnelle</span>
                                    <span class="bs-stepper-subtitle">Emploi et expériences</span>
                                </span>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="step {{ $step == 4 ? 'active' : '' }}">
                            <a href="{{ $submission->step >= 4 ? route('inscription.step', '4') : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class='bx bx-map'></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Projet Professionnel</span>
                                    <span class="bs-stepper-subtitle">Projets envisagés</span>
                                </span>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="step {{ $step == 5 ? 'active' : '' }}">
                            <a href="{{ $submission->step >= 5 ? route('inscription.step', '5') : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="fa-solid fa-chart-simple"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Condition de départ</span>
                                    <span class="bs-stepper-subtitle">administratives, financières & dis...</span>
                                </span>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="step {{ $step == 6 ? 'active' : '' }}">
                            <a href="{{ $submission->step >= 6 ? route('inscription.step', '6') : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="fa-solid fa-house-medical-flag"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Accident/Maladie</span>

                                </span>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="step {{ $step == 7 ? 'active' : '' }}">
                            <a href="{{ $submission->step >= 7 ? route('inscription.step', '7') : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="fa-solid fa-folder-open"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Pièces Jointes</span>

                                </span>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="step {{ $step == 'pending' ? 'active' : '' }}">
                            <a href="{{ $submission->step >= 'pending' ? route('inscription.step', 'pending') : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="fa-solid fa-clock"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Phase d&apos;approbation</span>

                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div id="wizard-property-listing-form">
                            @if ($step === 'pending')
                                @include('dashboard.inscription.form.approval')
                            @elseif ($step === 'completed')
                            @else
                                @include('dashboard.inscription.form.step' . $step - 1)
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-backdrop fade"></div>
        </div>
    @endif
@endsection
