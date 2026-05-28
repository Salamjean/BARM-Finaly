@extends('layouts.app', ['title' => $title])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Formation ></span> {{ $title }}
                </h4>

                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">Formation du bénéficiaire sur son choix de projet </h5>
                    </div>
                    <div class="row"><br></div>
                    <div class="card-body p-4">
                        <form class="row g-3"
                            action="{{ route('adherent.candidature.choice-final.training', $candidature->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-1">
                                    @include('partials.adherent', ['candidature' => $candidature])
                                </div>
                                <div class="col-md-11">
                                    <label for="beneficiaire" class="form-label">Bénéficiaires</label>
                                    <input value="{{ $candidature->user->fullName() }}" class="form-control" disabled />
                                </div>
                                <div class="col-md-12">
                                    <label for="beneficiaire" class="form-label">Orientation</label>
                                    <input value="{{ statusCandidature($candidature->orientation, 'orientation') }}"
                                        class="form-control" disabled />
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <label class="form-check-label">&bull; &nbsp; <i>La formation du bénéficiaire est-elle
                                            envisagée ?</i></label>
                                    <div class="col mt-2">
                                        <div class="form-check form-check-inline">
                                            <input name="formation"
                                                class="form-check-input @error('formation') is-invalid @enderror"
                                                type="radio" value="Oui" id="form_oui" required
                                                @if (old('formation') == 'Oui') checked @endif />
                                            <label class="form-check-label" for="form_oui">Oui</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="formation"
                                                class="form-check-input @error('formation') is-invalid @enderror"
                                                type="radio" value="Non" id="form_non"
                                                @if (old('formation') == 'Non')  @endif />
                                            <label class="form-check-label" for="form_non">Non</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="no-formation" style="display: none">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label for="observation" class="form-label">Observation</label>
                                        <div class="input-group">
                                            <textarea class="form-control @error('observation') is-invalid @enderror" id="observation" placeholder="Observation"
                                                name="observation" rows="5">{{ old('observation') }}</textarea>
                                            @error('observation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="formation-details" style="display: none">
                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <label for="date_debut" class="form-label">Date début<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="date"
                                                class="form-control @error('date_debut') is-invalid @enderror"
                                                id="date_debut" name="date_debut"
                                                value="{{ old('date_debut') ?? date('Y-m-d') }}">
                                            @error('date_debut')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_fin" class="form-label">Date fin</label>
                                        <div class="input-group">
                                            <input type="date"
                                                class="form-control @error('date_fin') is-invalid @enderror" id="date_fin"
                                                name="date_fin" value="{{ old('date_fin') }}">
                                            @error('date_fin')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="lieu_form" class="form-label">Lieu de la formation<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('lieu_form') is-invalid @enderror"
                                            id="lieu_form" placeholder="Préciser" name="lieu_form"
                                            value="{{ old('lieu_form') }}" />
                                        @error('lieu_form')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="periode" class="form-label">Durée</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="periode" name="periode"
                                                value="{{ old('periode') }}" placeholder="Nombre de jours" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label for="observation" class="form-label">Observation</label>
                                        <div class="input-group">
                                            <textarea class="form-control @error('observation') is-invalid @enderror" id="observation" placeholder="Préciser"
                                                name="observation" rows="5">{{ old('observation') }}</textarea>
                                            @error('observation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                        <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                        <a href="{{ route('beneficiaire.listBeneficiaire') }}" type="reset"
                                            class="btn btn-secondary px-4">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js-push')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const ouiRadio = document.getElementById('form_oui');
                const nonRadio = document.getElementById('form_non');
                const formationDetails = document.querySelector('.formation-details');
                const noFormation = document.querySelector('.no-formation');

                function toggleFormationDetails(show) {
                    formationDetails.style.display = show ? 'block' : 'none';
                }

                function togglenoFormation(show) {
                    noFormation.style.display = show ? 'block' : 'none';
                }

                function toggleFormationOptions() {
                    if (ouiRadio.checked) {
                        toggleFormationDetails(true);
                        togglenoFormation(false);
                    } else if (nonRadio.checked) {
                        togglenoFormation(true);
                        toggleFormationDetails(false);
                    }
                }

                toggleFormationOptions();

                ouiRadio.addEventListener('change', toggleFormationOptions);
                nonRadio.addEventListener('change', toggleFormationOptions);
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const date_debutInput = document.getElementById('date_debut');
                const date_finInput = document.getElementById('date_fin');
                const periodeInput = document.getElementById('periode');

                function calculateDays(startDate, endDate) {
                    const oneDay = 24 * 60 * 60 * 1000;
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const diffDays = Math.round(Math.abs((start - end) / oneDay));
                    return diffDays;
                }

                function updateperiode() {
                    const startDate = date_debutInput.value;
                    const endDate = date_finInput.value;
                    if (startDate && endDate) {
                        const days = calculateDays(startDate, endDate);
                        periodeInput.value = days + ' jours';
                    } else {
                        periodeInput.value = '';
                    }
                }

                date_debutInput.addEventListener('change', updateperiode);
                date_finInput.addEventListener('change', updateperiode);

                updateperiode();
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const radioButtons = document.querySelectorAll('input[name="orientation"]');

                radioButtons.forEach(function(radio) {
                    radio.addEventListener('change', function() {

                        document.querySelectorAll('.form-check-inline').forEach(function(element) {
                            element.style.display = 'none';
                        });


                        this.parentElement.style.display = 'inline-block';
                    });
                });

                radioButtons.forEach(function(radio) {
                    if (!radio.checked) {
                        radio.parentElement.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection
