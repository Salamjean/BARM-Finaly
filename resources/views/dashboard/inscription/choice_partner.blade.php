@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Choix du parrtenaire BARM/</span> Etat Civil
                </h4>
                <div class="card">
                    {{-- <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Créer une session</h5>
                </div> --}}
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('inscription.choice_partner', $candidat->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="fullname" class="form-label">Candidat</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bx-fullname'></i></span>
                                    <input type="text"
                                        class="form-control @error('fullname') is-invalid @enderror border-start-0"
                                        id="fullname" placeholder="text" name="fullname"
                                        value="{{ $user->fullName() }}" readonly />
                                </div>
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if ($user->candidate->domaine_1c)
                                <div class=" col-md-12 card shadow-none m-0">

                                    <div class="card-body row">
                                        <div class="col-md-12">
                                            <li class="pb-1 text-warning fs-4">CHOIX 1</li>
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

                                        <div class="col-md-12 my-3">
                                            <label class="form-label">Partenaire(s) <span class="text-danger">*</span> :
                                            </label>
                                            <select class="form-select" name="partners[]" required>
                                                <option value="" selected disabled>Selectionner le partenaire technique</option>
                                                @foreach ($partner_technicials as $partenaire)
                                                    <option
                                                        value="{{ $partenaire->id }}"
                                                        {{ $partenaire->id == $candidat->choice_1_partner_id ? 'selected' : '' }}
                                                    >
                                                        {{ $partenaire->user->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @if ($user->candidate->domaine_2c)
                                            <div class="col-md-12 pt-4">
                                                <li class="pb-1 text-warning fs-4">CHOIX 2</li>
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
                                        @if ($user->candidate->domaine_2c)
                                            <div class="col-md-12 my-3">
                                                <label class="form-label">Partenaire(s) <span class="text-danger">*</span>
                                                    : </label>
                                                <select class="form-select" name="partners[]" required>
                                                <option selected disabled>Selectionner le partenaire technique</option>
                                                    @foreach ($partner_technicials as $partenaire)
                                                        <option
                                                            value="{{ $partenaire->id }}"
                                                            {{ $partenaire->id == $candidat->choice_2_partner_id ? 'selected' : '' }}
                                                        >

                                                            {{ $partenaire->user->username }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                    <a href="{{ route('adherent.list') }}" type="reset"
                                        class="btn btn-danger px-4">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
