@extends('layouts.app')

@section('content')
    @php
        $other_data = regions();

    @endphp
    <div class="container pt-2">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Candidatures/</span> {{ $title }}
        </h4>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('adherent.choice.final.store', $user->id) }}" method="post" id="formSubmit1">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 pb-4">
                                    <label class="form-label">Stabilisation du choix : </label>
                                    <select name="choice" class="form-select" id="choice" required>
                                        <option value="" selected disabled>Choix definitif de l&apos;adhérent
                                        </option>
                                        <option value="choice_one">Choix 1 </option>
                                        @if ($user->candidate->domaine_2c)
                                            <option value="choice_two">Choix 2</option>
                                        @endif
                                        <option value="other" id="other_choice">Autre </option>
                                    </select>
                                </div>
                                <div class="col-md-3 pb-4">
                                    <label class="form-label">Date du profilage : </label>
                                    <input type="date" class="form-control" name="date_profilage" id="date_profilage_main" required>
                                </div>
                                <input type="text" name="candidature_id" value="{{ $candidature->id }}" hidden>
                                @if ($user->candidate->orientation == 'auto-emploi')
                                    <div class="col-md-3 pb-4">
                                        <div>
                                            <label class="form-label">Partenaire technique : </label>
                                            <input type="text" class="form-control"
                                                value=" {{ $partenaire->user->username }}" disabled/>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-3 pb-4" id="partner_div" style="display:none;">
                                    <label class="form-label">Partenaire financier : </label>
                                    <select class="form-control @error('partner_id') is-invalid @enderror"
                                        aria-label="Default select example" name="partner_financial"
                                        id="partner_financial_id" required>
                                        <option value="" selected disabled>Partenaire financier</option>
                                        @foreach ($partner_financials as $partner_financial)
                                            <option value="{{ $partner_financial->id }}">
                                                {{ $partner_financial->user->username }}
                                            </option>
                                        @endforeach
                                        <option value="other">Autre</option>
                                    </select>
                                    @error('partner_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 pb-4" id="other_partner_div" style="display:none;">
                                    <label class="form-label">Precisez : </label>
                                    <input type="text" class="form-control" name="other_partner_financial" />
                                </div>
                                <div class="col-md-2 pb-4 pt-4">
                                    <button type="submit" id="button" class="btn btn-dark" disabled>
                                        Confirmer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class=" col-md-12 card shadow-none my-0">
                        <div class=" card-header pb-0">
                            <h5 class="pb-0 border-bottom">PROJET PROFESSIONNEL</h5>
                        </div>
                        <div id="choice_1">
                            <div class="card-body row ">
                                <div class="col-md-12">
                                    <li class="pb-1 text-warning">CHOIX 1</li>
                                </div>

                                @if ($user->candidate->domaine_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Domaine : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->domaine_1c }}" readonly />
                                    </div>
                                @endif
                                @if ($user->candidate->specialisation_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Spécialisation : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->specialisation_1c }}" readonly />
                                    </div>
                                @endif

                                @if ($user->candidate->region_retraite_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Région de projet : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->region_retraite_1c }}" readonly />
                                    </div>
                                @endif

                                @if ($user->candidate->department_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Département : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->department_1c }}" readonly />
                                    </div>
                                @endif

                                @if ($user->candidate->locality_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Localité de projet : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->locality_1c }}" readonly />
                                    </div>
                                @endif

                                @if ($user->candidate->adress_geo_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Adresse géographique : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->adress_geo_1c }}" readonly />
                                    </div>
                                @endif

                                @if ($user->candidate->formation_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Formation souhaitée : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->formation_1c }}" readonly />
                                    </div>
                                @endif

                                @if ($user->candidate->autres_form_1c)
                                    <div class="col-md-6">
                                        <label class="form-label">Autres solicitations : </label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->candidate->autres_form_1c }}" readonly />
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div id="choice_2">
                            @if ($user->candidate->domaine_2c)
                                <div class="card-body row">
                                    @if ($user->candidate->domaine_2c)
                                        <div class="col-md-12 pt-4">
                                            <li class="pb-1 text-warning">CHOIX 2</li>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Domaine : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->domaine_2c }}" readonly />
                                        </div>
                                    @endif
                                    @if ($user->candidate->specialisation_2c)
                                        <div class="col-md-6">
                                            <label class="form-label">Spécialisation : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->specialisation_2c }}" readonly />
                                        </div>
                                    @endif

                                    @if ($user->candidate->region_retraite_2c)
                                        <div class="col-md-6">
                                            <label class="form-label">Région de projet : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->region_retraite_2c }}" readonly />
                                        </div>
                                    @endif

                                    @if ($user->candidate->department_2c)
                                        <div class="col-md-6">
                                            <label class="form-label">Département : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->department_2c }}" readonly />
                                        </div>
                                    @endif

                                    @if ($user->candidate->locality_2c)
                                        <div class="col-md-6">
                                            <label class="form-label">Localité de projet : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->locality_2c }}" readonly />
                                        </div>
                                    @endif

                                    @if ($user->candidate->adress_geo_2c)
                                        <div class="col-md-6">
                                            <label class="form-label">Adresse géographique : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->adress_geo_2c }}" readonly />
                                        </div>
                                    @endif

                                    @if ($user->candidate->formation_2c)
                                        <div class="col-md-6">
                                            <label class="form-label">Formation souhaitée : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->formation_2c }}" readonly />
                                        </div>
                                    @endif

                                    @if ($user->candidate->autres_form_2c)
                                        <div class="col-md-6">
                                            <label class="form-label">Autres solicitations : </label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->candidate->autres_form_2c }}" readonly />
                                        </div>
                                    @endif

                                </div>
                            @endif
                        </div>
                        <div id="choice_other">
                            <form action="{{ route('adherent.choice.final.store', $user->id) }}" method="post"
                                id="formSubmit2">
                                @csrf
                                <div class="card-body row ">
                                    <div class="col-md-12">
                                        <h5 class="pb-1 text-warning">CHOIX DEFINITIF <span
                                                class="fs-6 text-danger">(Veuillez renseigner le choix définitif de
                                                l&apos;adhérent)</span></h5>
                                    </div>

                                    <input type="hidden" name="choice" value="other" />
                                    <input type="hidden" name="date_profilage" id="date_profilage_other" />
                                    <input type="text" name="candidature_id" value="{{ $candidature->id }}" hidden>
                                    @if ($user->candidate->orientation == 'auto-emploi')
                                        <div class="col-md-7">
                                            <div>
                                                <label class="form-label">Partenaire financier : </label>
                                                <select class="form-control  @error('partner_id') is-invalid @enderror"
                                                    aria-label="Default select example" name="partner_financial"
                                                    id="other_choice_partner" required>
                                                    <option value="" selected disabled>Partenaire financier</option>
                                                    @foreach ($partner_financials as $partner_financial)
                                                        <option value="{{ $partner_financial->id }}">
                                                            {{ $partner_financial->user->username }}
                                                        </option>
                                                    @endforeach
                                                    <option value="other">Autre</option>
                                                </select>
                                                @error('partner_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5" id="other_choice_partner_div" style="display:none;">
                                            <label class="form-label">Precisez : </label>
                                            <input type="text" class="form-control" name="other_partner_financial" />
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label class="form-label">Domaine : </label>
                                        <select class="form-control select2 w-full @error('domaine') is-invalid @enderror"
                                            name="domaine" required>
                                            <option value="" selected disabled>Selectionner</option>
                                            @foreach (domain_orientation() as $domain)
                                                <option value="{{ $domain }}">
                                                    {{ $domain }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Spécialisation : </label>
                                        <input type="text" class="form-control" name="specialisation"
                                            placeholder="{{ $user->candidate->specialisation_1c }}" required />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Région de projet : </label>
                                        <select class="form-control select2 @error('region_retraite_1c') is-invalid @enderror"
                                            aria-label="Default select example" name="region_retraite" required>
                                            <option value="" selected disabled>Selectionner</option>
                                            <option
                                                {{ $user->candidate->region_retraite_1c == 'National' ? 'selected' : '' }}
                                                value="National">National</option>
                                            <option
                                                {{ $user->candidate->region_retraite_1c == 'International' ? 'selected' : '' }}
                                                value="International">International</option>
                                            @foreach ($other_data['regions'] as $key => $district)
                                                <option value="{{ ucfirst($district) }}"
                                                    {{ $user->candidate->region_retraite_1c == ucfirst($district) ? 'selected' : '' }}>
                                                    {{ ucfirst($district) }}</option>
                                            @endforeach

                                        </select>
                                        @error('region_retraite_1c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Département : </label>
                                        <select class="form-control select2 @error('department_1c') is-invalid @enderror"
                                            aria-label="Default select example" name="department" required>
                                            <option value="">Selectionner</option>
                                            <option {{ $user->candidate->department_1c == 'National' ? 'selected' : '' }}
                                                value="National">National</option>
                                            <option
                                                {{ $user->candidate->department_1c == 'International' ? 'selected' : '' }}
                                                value="International">International</option>
                                            @foreach ($other_data['departments'] as $city)
                                                <option value="{{ ucfirst($city) }}"
                                                    {{ $user->candidate->department_1c == ucfirst($city) ? 'selected' : '' }}>
                                                    {{ ucfirst($city) }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_1c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Localité de projet : </label>
                                        <select class="form-control select2 @error('locality_1c') is-invalid @enderror"
                                            aria-label="Default select example" name="locality" required>
                                            <option value="">Selectionner</option>
                                            <option {{ $user->candidate->locality_1c == 'National' ? 'selected' : '' }}
                                                value="National">National</option>
                                            <option
                                                {{ $user->candidate->locality_1c == 'International' ? 'selected' : '' }}
                                                value="International">International</option>
                                            @foreach ($other_data['villages'] as $city)
                                                <option value="{{ ucfirst($city) }}"
                                                    {{ $user->candidate->locality_1c == ucfirst($city) ? 'selected' : '' }}>
                                                    {{ ucfirst($city) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Quartier / village : </label>
                                        <input type="text" class="form-control" name="adress_geo"
                                            placeholder="{{ $user->candidate->adress_geo_1c }}" required />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Formation souhaitée : </label>
                                        <input type="text" class="form-control" name="formation"
                                            placeholder="{{ $user->candidate->formation_1c }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Autres solicitations : </label>
                                        <input type="text" class="form-control" name="autres_form"
                                            value="{{ $user->candidate->autres_form_1c }}" />
                                    </div>
                                    <div class="col-md-12 pt-4">
                                        <div class="d-flex justify-content-start">
                                            <button type="submit" id="button" class="btn btn-dark">
                                                Confirmer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            const choice = document.getElementById('choice');
            const button = document.getElementById('button');
            const choice_1 = document.getElementById('choice_1');
            const choice_2 = document.getElementById('choice_2');
            const choice_other = document.getElementById('choice_other');


            button.disabled = true;
            choice_other.style.display = 'none';

            choice.addEventListener('change', function() {

                if (choice.value === 'other') {
                    choice_1.style.display = 'none';
                    choice_2.style.display = 'none';
                    choice_other.style.display = 'block';
                    button.disabled = true;
                    button.style.display = 'none';



                } else if (choice.value === 'choice_one') {
                    choice_1.style.display = 'block';
                    choice_2.style.display = 'none';
                    choice_other.style.display = 'none';
                    button.disabled = false;
                    button.style.display = 'block';



                } else if (choice.value === 'choice_two') {
                    choice_1.style.display = 'none';
                    choice_2.style.display = 'block';
                    choice_other.style.display = 'none';
                    button.disabled = false;
                    button.style.display = 'block';



                }
            });
        </script>
        <script>
            $(document).ready(function(e) {
                const sw = (number) => {
                    Swal.fire({
                        title: 'Confirmation du choix définitif de l\'adhérent?',
                        icon: 'warning',
                        iconColor: '#E68200',
                        showCancelButton: true,
                        confirmButtonColor: '#6900AF',
                        cancelButtonColor: '#363636',
                        confirmButtonText: 'Confirmer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let timerInterval
                            Swal.fire({
                                title: 'Veuillez patienter!',
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                willClose: () => {
                                    $(`#formSubmit${number}`)[0].submit();
                                    clearInterval(timerInterval)
                                }
                            })
                        }
                    });
                }
                $("#formSubmit1").submit(function(e) {
                    e.preventDefault();

                    sw(1);
                });
                $("#formSubmit2").submit(function(e) {
                    e.preventDefault();

                    sw(2);
                });
            });
        </script>

        <script>
            document.getElementById('partner_financial_id').addEventListener('change', function() {
                var otherPartnerDiv = document.getElementById('other_partner_div');
                if (this.value === 'other') {
                    otherPartnerDiv.style.display = 'block';
                } else {
                    otherPartnerDiv.style.display = 'none';
                }
            });

            document.getElementById('other_choice_partner').addEventListener('change', function() {
                var otherPartner = document.getElementById('other_choice_partner_div');
                if (this.value === 'other') {
                    otherPartner.style.display = 'block';
                } else {
                    otherPartner.style.display = 'none';
                }
            });

            document.getElementById('choice').addEventListener('change', function() {
                var partnerDiv = document.getElementById('partner_div');
                if (this.value === 'other') {
                    partnerDiv.style.display = 'none';
                } else {
                    partnerDiv.style.display = 'block';
                }
            });
            
            // Synchroniser la date entre les deux formulaires
            document.getElementById('date_profilage_main').addEventListener('change', function() {
                const dateValue = this.value;
                const otherDateField = document.getElementById('date_profilage_other');
                if (otherDateField) {
                    otherDateField.value = dateValue;
                }
            });
        </script>
    @endpush
@endsection