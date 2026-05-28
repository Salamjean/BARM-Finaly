@extends('layouts.app')
@section('content')
    <div class="container">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Identification ></span> Personnel Militaire
        </h4>
        <div class=" order-0 order-md-1">


            <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link active" id="ex-with-icons-tab-1" href="#ex-with-icons-tabs-1"
                        role="tab" aria-controls="ex-with-icons-tabs-1" aria-selected="true"><i
                            class="bx bx-user me-1"></i>Informations personnelles</a>
                </li>
            </ul>

            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <div class="card">
                        <div class="card-header px-4 py-3 border-bottom">
                            <h5 class="mb-0">Enregistrement Personnel Civil</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('personalbarm.update', $personal->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="header-title">
                                    <h5>&bull; <i>Identification</i></h5>
                                </div>
                                <input type="hidden" name="type" value="civil" />
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="lastname" class="form-label">Prénom(s) </label>

                                        <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                            id="lastname" placeholder="Prénom(s)" name="lastname"
                                            value="{{ old('lastname') ?? $personal->lastname }}" />

                                        @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="firstname" class="form-label">Nom</label>

                                        <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                            id="firstname" placeholder="Nom" name="firstname"
                                            value="{{ old('firstname') ?? $personal->firstname }}" />

                                        @error('firstname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="grade" class="form-label">Grade </label>
                                        <select class="form-select select2" id="grade" name="grade" required>
                                            <option selected disabled>Selectionner</option>
                                            @foreach (GRADES['other'] as $grade)
                                                <option value="{{ $grade }}"
                                                    {{ $personal->grade == $grade ? 'selected' : '' }}>
                                                    {{ $grade }}</option>
                                            @endforeach
                                        </select>

                                        @error('grade')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="birth_date" class="form-label">Né(e) le</label>
                                        <input type="date" max="{{ Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}" class="form-control @error('birth_date') is-invalid @enderror"
                                            id="birth_date" name="birth_date"
                                            value="{{ old('birth_date') ?? $personal->birth_date }}">
                                        @error('birth_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="lieu_naissance" class="form-label">à </label>

                                        <input type="text"
                                            class="form-control @error('lieu_naissance') is-invalid @enderror"
                                            id="lieu_naissance" placeholder="Lieu de naissance" name="lieu_naissance"
                                            value="{{ old('lieu_naissance') ?? $personal->lieu_naissance }}" />

                                        @error('lieu_naissance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="nationalite" class="form-label">Nationalité</label>

                                        <input type="text"
                                            class="form-control @error('nationalite') is-invalid @enderror"
                                            id="nationalite" name="nationalite"
                                            value="{{ old('nationalite') ?? $personal->nationalite }}"
                                            placeholder="Nationalité">

                                        @error('nationalite')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="nbre_enfant" class="form-label">Nombre d'enfant</label>

                                        <input type="text"
                                            class="form-control @error('nbre_enfant') is-invalid @enderror"
                                            id="nbre_enfant" name="nbre_enfant"
                                            value="{{ old('nbre_enfant') ?? $personal->nbre_enfant }}"
                                            placeholder="Nombre d'enfant">

                                        @error('nbre_enfant')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="no_card" class="form-label">N° CNI</label>

                                        <input type="text" class="form-control @error('no_card') is-invalid @enderror"
                                            id="no_card" name="no_card" placeholder="CI 0000000000"
                                            value="{{ old('no_card') ?? $personal->no_card }}">

                                        @error('no_card')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_etabli" class="form-label">Etablie le</label>
                                        <input type="date"
                                            class="form-control @error('date_etabli') is-invalid @enderror"
                                            id="date_etabli" name="date_etabli"
                                            value="{{ old('date_etabli') ?? $personal->date_etabli }}">
                                        @error('date_etabli')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="lieu_etabli" class="form-label">Lieu d'étbalissement</label>

                                        <input type="text"
                                            class="form-control @error('lieu_etabli') is-invalid @enderror"
                                            id="lieu_etabli" name="lieu_etabli" placeholder="Lieu d'étbalissement"
                                            value="{{ old('lieu_etabli') ?? $personal->lieu_etabli }}">

                                        @error('lieu_etabli')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_validate" class="form-label">Date de validité</label>
                                        <input type="date"
                                            class="form-control @error('date_validate') is-invalid @enderror"
                                            id="date_validate" name="date_validate"
                                            value="{{ old('date_validate') ?? $personal->date_validate }}">
                                        @error('date_validate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <br><br><br>
                                <div class="header-title">
                                    <h5>&bull; <i>Informations contacts</i></h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="no_cim" class="form-label">N° CIM</label>

                                        <input type="text" class="form-control @error('no_cim') is-invalid @enderror"
                                            id="no_cim" name="no_cim"
                                            value="{{ old('no_cim') ?? $personal->no_cim }}" placeholder="N° CIM">

                                        @error('no_cim')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="phone" class="form-label">N° téléphone</label>
                                        <input type="text" class="form-control  @error('phone') is-invalid @enderror"
                                            id="phone" placeholder="0000000000" name="phone"
                                            value="{{ old('phone') ?? $personal->phone }}" />
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                            id="email" placeholder="xyz@exemple.com" name="email"
                                            value="{{ old('email') ?? $personal->email }}" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label for="group_sanguin" class="form-label">Groupe sanguin</label>

                                        <input type="text"
                                            class="form-control @error('group_sanguin') is-invalid @enderror"
                                            id="group_sanguin" name="group_sanguin"
                                            value="{{ old('group_sanguin') ?? $personal->groupe_sanguin }}"
                                            placeholder="Groupe sanguin">

                                        @error('group_sanguin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="lieu_residence" class="form-label">Lieu de residence</label>

                                        <input type="text"
                                            class="form-control @error('lieu_residence') is-invalid @enderror"
                                            id="lieu_residence" name="lieu_residence"
                                            value="{{ old('lieu_residence') ?? $personal->lieu_residence }}"
                                            placeholder="Lieu de residence">

                                        @error('lieu_residence')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <br><br><br>
                                <div class="header-title">
                                    <h5>&bull; <i>Informations BARM</i></h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="matricule_barm" class="form-label">Matricule BARM</label>

                                        <input type="text"
                                            class="form-control @error('matricule_barm') is-invalid @enderror"
                                            id="matricule_barm" name="matricule_barm"
                                            value="{{ old('matricule_barm') ?? $personal->matricule_barm }}"
                                            placeholder="Matricule BARM">

                                        @error('matricule_barm')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="matricule_fae" class="form-label">Matricule FAE</label>

                                        <input type="text"
                                            class="form-control @error('matricule_fae') is-invalid @enderror"
                                            id="matricule_fae" name="matricule_fae"
                                            value="{{ old('matricule_fae') ?? $personal->matricule_fae }}"
                                            placeholder="Matricule FAE">

                                        @error('matricule_fae')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_prise_service" class="form-label">Date de prise de
                                            service</label>

                                        <input type="date"
                                            class="form-control @error('date_prise_service') is-invalid @enderror"
                                            id="date_prise_service" name="date_prise_service"
                                            value="{{ old('date_prise_service') ?? $personal->date_prise_service_barm }}"
                                            placeholder="Date de prise de service (BARM)">

                                        @error('date_prise_service')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-2 row">
                                    <div class="col-md-4">
                                        <label for="lieu_service" class="form-label">SERvice</label>
                                        <select class="form-select select2"
                                            data-placeholder="Choisir le service d'affectation" id="roles"
                                            name="roles">
                                            <option selected disabled>Selectionner</option>
                                            @foreach (POSTBYCELLBARM as $role)
                                                @if ($role['name'] != 'CHEF BARM')
                                                    <option value="{{ $role['name'] }}"
                                                        {{ $personal->cell === $role['name'] ? 'selected' : '' }}>
                                                        {{ $role['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-8 mt-2">
                                        <label class="form-label">POSTES :</label>
                                        <select class="form-select select2" data-placeholder="Permissions"
                                            id="small-bootstrap-class-multiple-field" multiple name="permissions[]">

                                        </select>
                                    </div>

                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="diplome_eleve" class="form-label">Diplôme civil (plus élévé)</label>
                                        <select class="form-select select2" id="diplome_eleve" name="diplome_eleve">
                                            <option selected disabled>Selectionner</option>
                                            @foreach (EDUCATIONS as $education)
                                                <option value="{{ $education }}"
                                                    {{ old('diplome_eleve') ?? $personal->diplome_civil_eleve == $education ? 'selected' : '' }}>
                                                    {{ $education }}</option>
                                            @endforeach
                                        </select>

                                        @error('diplome_eleve')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="derniere_formation" class="form-label">Dernière formation
                                            effectuée</label>

                                        <input type="text"
                                            class="form-control @error('derniere_formation') is-invalid @enderror"
                                            id="derniere_formation" name="derniere_formation"
                                            value="{{ old('derniere_formation') ?? $personal->derniere_formation }}"
                                            placeholder="Dernière formation">

                                        @error('derniere_formation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="lieu_formation" class="form-label">Lieu de formation</label>

                                        <input type="text"
                                            class="form-control @error('lieu_formation') is-invalid @enderror"
                                            id="lieu_formation" name="lieu_formation"
                                            value="{{ old('lieu_formation') ?? $personal->lieu_formation }}"
                                            placeholder="Lieu de la formation">

                                        @error('lieu_formation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="annee_formation" class="form-label">Année de formation</label>

                                        <input type="text"
                                            class="form-control @error('annee_formation') is-invalid @enderror"
                                            id="annee_formation" name="annee_formation"
                                            value="{{ old('annee_formation') ?? $personal->annee_de_formation }}"
                                            placeholder="Année de la formation">

                                        @error('annee_formation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="statut_personnel" class="form-label">Statut</label>
                                        <select class="form-select @error('statut_personnel') is-invalid @enderror"
                                            aria-label="Default select example" name="statut_personnel">
                                            <option value="" disabled
                                                {{ old('statut_personnel') ?? $personal->statut_personnel == '' ? 'selected' : '' }}>
                                                Sélectionner</option>
                                            <option value="Contractuel"
                                                {{ old('statut_personnel') ?? $personal->statut_personnel == 'Contractuel' ? 'selected' : '' }}>
                                                Contractuel
                                            </option>
                                            <option value="Fonctionnaire civil"
                                                {{ old('statut_personnel') ?? $personal->statut_personnel == 'Fonctionnaire civil' ? 'selected' : '' }}>
                                                Fonctionnaire civil
                                            </option>
                                        </select>
                                        @error('statut_personnel')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="nom_cas_urgence" class="form-label">Nom(cas urgent)</label>

                                        <input type="text"
                                            class="form-control  @error('nom_cas_urgence') is-invalid @enderror"
                                            id="nom_cas_urgence" placeholder="Personne en cas d'urgence"
                                            name="nom_cas_urgence"
                                            value="{{ old('nom_cas_urgence') ?? $personal->nom_cas_urgence }}" />

                                        @error('nom_cas_urgence')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="telephone_cas_urgence" class="form-label">Contact(cas urgent)</label>

                                        <input type="text"
                                            class="form-control  @error('telephone_cas_urgence') is-invalid @enderror"
                                            id="telephone_cas_urgence" placeholder="contact en cas d'urgence"
                                            name="telephone_cas_urgence"
                                            value="{{ old('telephone_cas_urgence') ?? $personal->telephone_cas_urgence }}" />

                                        @error('telephone_cas_urgence')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">

                                    <button type="button"
                                        class="btn btn-outline-primary add_decoration_btn fs-4 mt-10 mb-10">
                                        Ajouter une/les Décoration(s) <span class="fa-solid fa-plus-circle"></span>
                                    </button>
                                    <div class="items mt-10">
                                        <div class="col-md-10">
                                            <div id="decoration__item">
                                                @if ($personal->decorations != null)
                                                            @foreach (json_decode($personal->decorations) as $decoration)
                                                                <div class="row rounded-3">
                                                                    <div class="col-md-10 mb-3 mx-auto">
                                                                        <label for="decoration"
                                                                            class="form-label">Décoration</label>
                                                                        <input type="text" class="form-control "
                                                                            id="decoration" placeholder="Decoration "
                                                                            name="decoration[]"
                                                                            value="{{ $decoration }}">
                                                                    </div>
                                                                    <div class="col-md-1 mt-4">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove__item__btn">
                                                                            <i class="bx bx-trash" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            @endforeach
                                                        @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                        <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                        <a href="{{ route('personalbarm.index') }}" type="reset"
                                            class="btn btn-danger px-4">Annuler</a>
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
        <script type="text/javascript" src="{{ asset('assets/js/mdb.umd.min.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                "use strict";

                $('.add_decoration_btn').click(function() {
                    addDecoration();
                });

                $('.remove__item__btn').click(function() {
                    $(this).closest(".row").remove();
                });

                var TitreNbre = 0;

                function addDecoration() {
                    var devisSection = $("#decoration__item");

                    devisSection.append(`<div class="row rounded-3">
                                <div class="col-md-10 mb-3 mx-auto">
                                    <label for="decoration" class="form-label">Décoration</label>
                                    <input type="text" class="form-control " id="decoration" placeholder="Decoration " name="decoration[]" value="">
                                </div>
                                <div class="col-md-1 mt-4">
                                    <button type="button" class="btn btn-danger remove__item__btn">
                                        <i class="bx bx-trash" aria-hidden="true"></i>
                                    </button>
                                </div>

                            </div>`);

                    $(".remove_decoration_btn").hide();
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                "use strict";
                const typeUserRoles = {!! json_encode(POSTBYCELLBARM) !!};

                let selectedPermissions = [];

                function dataPermission() {
                    let selectedRoleName = "{{ $personal->cell }}";
                    let permissions = {!! json_encode($personal->posts) !!};
                    console.log(JSON.stringify(permissions));

                    typeUserRoles.forEach(role => {
                        if (role.name === selectedRoleName) {
                            selectedPermissions = role.permissions;
                        }
                    });

                    var perms = $("#small-bootstrap-class-multiple-field");
                    perms.empty();
                    perms.append($('<option>', {
                        value: '',
                        text: 'Selectionnez',
                    }));

                    selectedPermissions.forEach(function(permission) {
                        perms.append($('<option>', {
                            value: permission,
                            text: permission,
                            selected: permissions.includes(permission) ? true : false
                        }));
                    });
                }

                @if ($personal->cell)
                    dataPermission();
                @endif

                $('#roles').on("change", function() {
                    let selectedRoleName = this.value;
                    selectedPermissions = [];

                    typeUserRoles.forEach(role => {
                        if (role.name === selectedRoleName) {
                            selectedPermissions = role.permissions;
                        }
                    });

                    var perms = $("#small-bootstrap-class-multiple-field");
                    perms.empty();
                    perms.append($('<option>', {
                        value: '',
                        text: 'Selectionnez',
                    }));

                    selectedPermissions.forEach(function(permission) {
                        perms.append($('<option>', {
                            value: permission,
                            text: permission,
                        }));
                    });

                });
            });
        </script>
    @endpush
@endsection
