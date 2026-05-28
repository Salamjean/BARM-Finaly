@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Personnels/</span> Créer un personnel
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Créer un personnel</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('personnel.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-8">
                            <label for="firstname" class="form-label">Prénom(s)</label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                <input type="text" class="form-control border-start-0" id="firstname" placeholder="Prénom(s)" name="firstname" value="{{ old('firstname') }}"/>
                            </div>
                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="lastname" class="form-label">Nom </label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                <input type="text" class="form-control border-start-0" id="lastname" placeholder="Nom" name="lastname" value="{{ old('lastname') }}"/>
                            </div>
                            @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="grade" class="form-label">Grade </label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-medal"></i></span>
                                <input type="text" class="form-control border-start-0" id="grade" placeholder="Grade" name="grade" value="{{ old('grade') }}"/>
                            </div>
                            @error('grade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="birth_date" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                                name="birth_date" value="{{ old('birth_date') }}">
                            @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="lieu_naissance" class="form-label">Lieu de naissance </label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-street-view"></i></span>
                                <input type="text" class="form-control border-start-0" id="lieu_naissance" placeholder="Lieu de naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}"/>
                            </div>
                            @error('lieu_naissance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nationalite" class="form-label">Nationalité</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-flag"></i></span>
                                <input type="text" class="form-control border-start-0 @error('nationalite') is-invalid @enderror" id="nationalite" name="nationalite" value="{{ old('nationalite') }}" placeholder="Nationalité">
                            </div>
                            @error('nationalite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="nbre_enfant" class="form-label">Nombre d'enfant</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-children"></i></span>
                                <input type="text" class="form-control border-start-0 @error('nbre_enfant') is-invalid @enderror" id="nbre_enfant" name="nbre_enfant" value="{{ old('nbre_enfant') }}" placeholder="Nombre d'enfant">
                            </div>
                            @error('nbre_enfant')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label for="no_card" class="form-label">N° CNI</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-id-card"></i></i></span>
                                <input type="text" class="form-control border-start-0 @error('no_card') is-invalid @enderror" id="no_card" name="no_card" placeholder="CI 0000000000" value="{{ old('no_card') }}">
                            </div>
                            @error('no_card')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="date_etabli" class="form-label">Date d'établissement</label>
                            <input type="date" class="form-control @error('date_etabli') is-invalid @enderror" id="date_etabli"
                                name="date_etabli" value="{{ old('date_etabli') }}">
                            @error('date_etabli')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="lieu_etabli" class="form-label">Lieu d'étbalissement</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-map-location-dot"></i></span>
                                <input type="text" class="form-control border-start-0 @error('lieu_etabli') is-invalid @enderror" id="lieu_etabli" name="lieu_etabli" placeholder="Lieu d'étbalissement" value="{{ old('lieu_etabli') }}">
                            </div>
                            @error('lieu_etabli')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="date_validite" class="form-label">Date de validité</label>
                            <input type="date" class="form-control @error('date_validite') is-invalid @enderror" id="date_validite"
                                name="date_validite" value="{{ old('date_validite') }}">
                            @error('date_validite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="no_cim" class="form-label">N° CIM</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-id-card-clip"></i></span>
                                <input type="text" class="form-control border-start-0 @error('no_cim') is-invalid @enderror" id="no_cim" name="no_cim" value="{{ old('no_cim') }}" placeholder="N° CIM">
                            </div>
                            @error('no_cim')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">N° téléphone</label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-phone' ></i></span>
                                <input type="text" class="form-control border-start-0" id="phone" placeholder="N° de telephone" name="phone" value="{{ old('phone') }}"/>
                            </div>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-envelope' ></i></span>
                                <input type="text" class="form-control border-start-0" id="email" placeholder="Adresse mail" name="email" value="{{ old('email') }}"/>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="group_sanguin" class="form-label">Groupe sanguin</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-truck-droplet"></i></span>
                                <input type="text" class="form-control border-start-0 @error('group_sanguin') is-invalid @enderror" id="group_sanguin" name="group_sanguin" value="{{ old('group_sanguin') }}" placeholder="Groupe sanguin">
                            </div>
                            @error('group_sanguin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="lieu_residence" class="form-label">Lieu de residence</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                <input type="text" class="form-control border-start-0 @error('lieu_residence') is-invalid @enderror" id="lieu_residence" name="lieu_residence" value="{{ old('lieu_residence') }}" placeholder="Lieu de residence">
                            </div>
                            @error('lieu_residence')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="matricule_barm" class="form-label">Matricule BARM</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                                <input type="text" class="form-control border-start-0 @error('matricule_barm') is-invalid @enderror" id="matricule_barm" name="matricule_barm" value="{{ old('matricule_barm') }}" placeholder="Matricule BARM">
                            </div>
                            @error('matricule_barm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="matricule" class="form-label">Matricule</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
                                <input type="text" class="form-control border-start-0 @error('matricule') is-invalid @enderror" id="matricule" name="matricule" value="{{ old('matricule') }}" placeholder="Matricule">
                            </div>
                            @error('matricule')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="mecano" class="form-label">N° Mécano</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-regular fa-id-badge"></i></span>
                                <input type="text" class="form-control border-start-0 @error('mecano') is-invalid @enderror" id="mecano" name="mecano" value="{{ old('mecano') }}" placeholder="N° Mécano">
                            </div>
                            @error('mecano')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="cellule" class="form-label">Cellule</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-brands fa-pied-piper"></i></span>
                                <input type="text" class="form-control border-start-0 @error('cellule') is-invalid @enderror" id="cellule" name="cellule" value="{{ old('cellule') }}" placeholder="Cellule">
                            </div>
                            @error('cellule')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="fonction" class="form-label">Fonction</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                                <input type="text" class="form-control border-start-0 @error('fonction') is-invalid @enderror" id="fonction" name="fonction" value="{{ old('fonction') }}" placeholder="Fonction" placeholder="Fonction">
                            </div>
                            @error('fonction')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="date_prise_service" class="form-label">Date de prise de service (BARM)</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                <input type="date" class="form-control border-start-0 @error('date_prise_service') is-invalid @enderror" id="date_prise_service" name="date_prise_service" value="{{ old('date_prise_service') }}" placeholder="Date de prise de service (BARM)">
                            </div>
                            @error('date_prise_service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="lieu_service" class="form-label">Lieu de service</label>
                            <select class="form-select select2" data-placeholder="Choisir le service d'affectation" id="small-bootstrap-class-multiple-field" multiple name="roles[]">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('lieu_service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="gender" class="form-label">Genre</label>
                            <select class="form-select @error('gender') is-invalid @enderror" aria-label="Default select example"
                                name="gender" required>
                                <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>Sélectionner</option>
                                <option value="masculin" {{ old('gender') == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                <option value="feminin" {{ old('gender') == 'feminin' ? 'selected' : '' }}>Feminin</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="diplome_militaire" class="form-label">Diplôme militaire</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-briefcase"></i></span>
                                <input type="text" class="form-control border-start-0 @error('diplome_militaire') is-invalid @enderror" id="diplome_militaire" name="diplome_militaire" value="{{ old('diplome_militaire') }}" placeholder="Diplôme militaire">
                            </div>
                            @error('diplome_militaire')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="diplome_eleve" class="form-label">Diplôme civil le plus élévé</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-business-time"></i></span>
                                <input type="text" class="form-control border-start-0 @error('diplome_eleve') is-invalid @enderror" id="diplome_eleve" name="diplome_eleve" value="{{ old('diplome_eleve') }}" placeholder="Diplôme civil le plus élévé">
                            </div>
                            @error('diplome_eleve')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="lieu_formation" class="form-label">Lieu de la formation</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-map-pin"></i></span>
                                <input type="text" class="form-control border-start-0 @error('lieu_formation') is-invalid @enderror" id="lieu_formation" name="lieu_formation" value="{{ old('lieu_formation') }}" placeholder="Lieu de la formation">
                            </div>
                            @error('lieu_formation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="annee_formation" class="form-label">Année de la formation</label>
                            <div class="input-group"> <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                                <input type="text" class="form-control border-start-0 @error('annee_formation') is-invalid @enderror" id="annee_formation" name="annee_formation" value="{{ old('annee_formation') }}" placeholder="Année de la formation">
                            </div>
                            @error('annee_formation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="nom_telephone_cas_urgence" class="form-label">Nom et numero téléphonique de la personne a contacter en cas d'urgence</label>
                            <input type="text" class="form-control @error('nom_telephone_cas_urgence') is-invalid @enderror" id="nom_telephone_cas_urgence"
                                name="nom_telephone_cas_urgence" value="{{ old('nom_telephone_cas_urgence') }}" placeholder="Nom et numero téléphonique de la personne a contacter en cas d'urgence">
                            @error('nom_telephone_cas_urgence')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('personnel.index') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
