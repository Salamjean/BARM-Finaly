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
                            <a href="{{ route('adherent.step', ['1', $user->id ?? 0]) }}" class="step-trigger">
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
                            <a href="{{ ($submission->step ?? $step) >= 2 ? route('adherent.step', ['2', $user->id]) : '#' }}"
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
                            <a href="{{ ($submission->step ?? $step) >= 3 ? route('adherent.step', ['3', $user->id]) : '#' }}"
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
                            <a href="{{ ($submission->step ?? $step) >= 4 ? route('adherent.step', ['4', $user->id]) : '#' }}"
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
                            <a href="{{ ($submission->step ?? $step) >= 5 ? route('adherent.step', ['5', $user->id]) : '#' }}"
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
                            <a href="{{ ($submission->step ?? $step) >= 6 ? route('adherent.step', ['6', $user->id]) : '#' }}"
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
                            <a href="{{ ($submission->step ?? $step) >= 7 ? route('adherent.step', ['7', $user->id]) : '#' }}"
                                class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="fa-solid fa-folder-open"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Pièces Jointes</span>

                                </span>
                            </a>
                        </div>
                        @if ($step !== 'completed')
                            <div class="line"></div>
                            <div class="step {{ $step == 'pending' ? 'active' : '' }}">
                                <a href="{{ ($submission->step ?? $step) >= 'pending' ? route('adherent.step', ['pending', $user->id]) : '#' }}"
                                    class="step-trigger">
                                    <span class="bs-stepper-circle">
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Phase d'approbation</span>

                                    </span>
                                </a>
                            </div>
                        @endif

                    </div>
                    <div
                        class="bs-stepper-content {{ $step === 'pending' ? 'd-flex justify-content-center align-items-center' : '' }}">
                        @if ($step === 'pending')
                            @if (can('point-focal'))
                                <div id="wizard-property-listing-form bg-danger">
                                    <div class="fs-2 badge-dark ">
                                        En cours d'approbation
                                    </div>
                                    <div>
                                        
                                    </div>
                                </div>
                            @else
                                <form id="formSubmit" action="{{ route('adherent.approved', $user->id) }}" method="post"
                                    class="">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <div class="text-center"></div>
                                        <div class="d-flex justify-content-center align-items-center"
                                        style="flex-direction: column;">
                                        <i class='bx bx-checkbox-checked fa-10x'></i>
                                        <button type="submit" class="my-2 btn btn-success">Approver la candidature</button>
                                    </div>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div id="wizard-property-listing-form bg-danger">
                                @include('dashboard.adherent.form.step' . $step - 1)
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="content-backdrop fade"></div>
        </div>
    @endif

    @push('js-push')
        @include('partials.script.loading')

        <script>
            $(document).ready(function() {
                $("#formSubmit").submit(function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Etes vous sure d\'approuver la candidature?',
                        icon: 'warning',
                        iconColor: '#E68200',
                        showCancelButton: true,
                        confirmButtonColor: '#6900AF',
                        cancelButtonColor: '#363636',
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let timerInterval
                            Swal.fire({
                                title: 'Veuillez patienter!',
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                willClose: () => {
                                    $("#formSubmit")[0].submit();
                                    clearInterval(timerInterval)
                                }
                            })
                        }
                    })
                });
            });
        </script>
    @endpush
@endsection
