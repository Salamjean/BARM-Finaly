@extends('layouts.app')

@section('content')
    <div class="container pt-2">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Candidatures/</span> {{ $title }}
        </h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-content-center align-items-center text-info">
                            <div class="px-1">Voir infos</div>
                            <div>
                                @include('partials.adherent', ['candidature' => $candidature, 'view_choice_final' => false])
                            </div>
                        </div>


                        <h5 class="pb-2 border-bottom mt-4">Informations personnelles</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Nom et prénoms:</span>
                                    <span>{{ $candidature->user->fullName() }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Mecano / Matricule:</span>
                                    <span>{{ $candidature->user->mecano }}</span>
                                </li>
                                @if ($candidature->birth_date)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Date de naissance:</span>
                                        <span>{{ dateFr($candidature->birth_date) }}</span>
                                    </li>
                                @endif
                                @if ($candidature->phone_number)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Numéro de téléphone:</span>
                                        <span>{{ $candidature->phone_number }}</span>
                                    </li>
                                @endif
                                @if ($candidature->user->email)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Email:</span>
                                        <span>{{ $candidature->user->email }}</span>
                                    </li>
                                @endif
                                @if ($candidature->orientation)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Orientation:</span>
                                        <span
                                            class="text-info text-uppercase">{{ statusCandidature($candidature->orientation, 'orientation') }}</span>
                                    </li>
                                @endif
                                @if ($candidature->gender)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Genre:</span>
                                        <span>{{ $candidature->gender }}</span>
                                    </li>
                                @endif
                                @if ($candidature->religion)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Réligion:</span>
                                        <span>{{ $candidature->religion }}</span>
                                    </li>
                                @endif
                                @if ($candidature->ethnic)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Ethnie:</span>
                                        <span>{{ $candidature->ethnic }}</span>
                                    </li>
                                @endif

                                @if ($candidature->situation_matrimoniale)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Sitatuation matrimoniale:</span>
                                        <span>{{ $candidature->situation_matrimoniale }}</span>
                                    </li>
                                @endif

                                @if ($candidature->residence)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Résidence:</span>
                                        <span>{{ $candidature->residence }}</span>
                                    </li>
                                @endif

                                @if (count($candidature->childs) > 0)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Nombre d'enfant:</span>
                                        <span>{{ count($candidature->childs) }}</span>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12 row p-2 py-4 rounded-2 choice">
                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="pb-1 fs-5 fw-bold text-dark">
                                CHOIX FINAL <span class="text-danger">(Refusé par le chef barm)</span>
                            </div>
                        </div>

                        @if ($candidature->choiceFinal->domaine)
                            <div class="col-md-6">
                                <label class="form-label-choice">Domaine : </label>
                                <div class="form-control-choice">{{ $candidature->choiceFinal->domaine }}</div>
                            </div>
                        @endif
                        @if ($candidature->choiceFinal->specialisation)
                            <div class="col-md-6">
                                <label class="form-label-choice">Spécialisation : </label>
                                <div class="form-control-choice">{{ $candidature->choiceFinal->specialisation }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->region_retraite)
                            <div class="col-md-6">
                                <label class="form-label-choice">Région de projet : </label>
                                <div class="form-control-choice">{{ $candidature->choiceFinal->region_retraite }}</div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->department)
                            <div class="col-md-6">
                                <label class="form-label-choice">Département : </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->department }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->locality)
                            <div class="col-md-6">
                                <label class="form-label-choice">Localité de projet :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->locality }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->adress_geo)
                            <div class="col-md-6">
                                <label class="form-label-choice">Adresse géographique :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->adress_geo }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->formation)
                            <div class="col-md-6">
                                <label class="form-label-choice">Formation souhaitée :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->formation }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->autres_form)
                            <div class="col-md-6">
                                <label class="form-label-choice">Autres solicitations :
                                </label>
                                <div class="form-control-choice"> {{ $candidature->choiceFinal->autres_form }} </div>
                            </div>
                        @endif

                        @if ($candidature->choiceFinal->partner_id)
                            <div class="col-md-12">
                                <label class="form-label-choice">Partenaire technique :
                                </label>
                                <div class="form-control-choice">
                                    {{ $candidature->choiceFinal->partner->user->username }} </div>
                            </div>
                        @endif
                    </div>
                    <div id="choice_other" class="choice-2 p-3 py-4">
                            <form action="{{ route('adherent.candidature.choice-final.remake.update', $candidature->id) }}" method="post"
                                id="formSubmit2">
                                @csrf
                                @method('PUT')
                                <div class="card-body row ">
                                    <div class="col-md-12">
                                        <h5 class="pb-1 fs-5">CHOIX DEFINITIF <span
                                                class="fs-6 text-danger">(Veuillez reprendre le choix de l&apos;adhérent avec sa permission)</span></h5>
                                    </div>

                                    <input type="hidden" name="choice" value="other" />

                                    <div class="col-md-6">
                                        <label class="form-label">Domaine : </label>
                                        <input type="text" class="form-control" name="domaine"
                                            placeholder="{{ $candidature->domaine_1c }}" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Spécialisation : </label>
                                        <input type="text" class="form-control" name="specialisation"
                                            placeholder="{{ $candidature->specialisation_1c }}" required />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Région de projet : </label>
                                        <select class="form-control  @error('region_retraite_1c') is-invalid @enderror"
                                            aria-label="Default select example" name="region_retraite" required>
                                            <option value="" selected disabled>Selectionner</option>
                                            @foreach (DISTRICTS as $district)
                                                <option value="{{ $district }}"
                                                    {{ $candidature->region_retraite_1c == $district ? 'selected' : '' }}>
                                                    {{ $district }}</option>
                                            @endforeach
                                        </select>
                                        @error('region_retraite_1c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Département : </label>
                                        <select class="form-control  @error('department_1c') is-invalid @enderror"
                                            aria-label="Default select example" name="department" required>
                                            <option value="">Selectionner</option>
                                            @foreach (CITIES as $city)
                                                <option value="{{ $city }}"
                                                    {{ $candidature->department_1c == $city ? 'selected' : '' }}>
                                                    {{ $city }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_1c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Localité de projet : </label>
                                        <select class="form-control  @error('locality_1c') is-invalid @enderror"
                                            aria-label="Default select example" name="locality" required>
                                            <option value="">Selectionner</option>
                                            @foreach (CITIES as $city)
                                                <option value="{{ $city }}"
                                                    {{ $candidature->locality_1c == $city ? 'selected' : '' }}>
                                                    {{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Adresse géographique : </label>
                                        <input type="text" class="form-control" name="adress_geo"
                                            placeholder="{{ $candidature->adress_geo_1c }}" required />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Formation souhaitée : </label>
                                        <input type="text" class="form-control" name="formation"
                                            placeholder="{{ $candidature->formation_1c }}" required />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Autres solicitations : </label>
                                        <input type="text" class="form-control" name="autres_form"
                                            value="{{ $candidature->autres_form_1c }}" />
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
@endsection
