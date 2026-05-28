@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Personnels / </span> Modification
                </h4>
                
                <!-- Onglets -->
                <ul class="nav nav-tabs mb-4" id="personnelTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
                            Informations
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                            Mot de passe
                        </button>
                    </li>
                </ul>

                <!-- Contenu des onglets -->
                <div class="tab-content" id="personnelTabsContent">
                    <!-- Onglet Informations -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <div class="card">
                            <div class="card-header px-4 py-3 border-bottom">
                                <h5 class="mb-0">Modification Personnel</h5>
                            </div>
                            <div class="card-body p-4">
                                <form class="row g-3" method="POST" action="{{ route('personnel.update', $personal->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Informations de base -->
                                    <div class="header-title">
                                        <h5 class="badge bg-secondary">&bull; <i>Informations de base</i></h5>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="firstname" class="form-label">Nom</label>
                                            <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                                id="firstname" placeholder="Nom" name="firstname"
                                                value="{{ old('firstname') ?? $personal->user->firstname }}" required />
                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="lastname" class="form-label">Prénom(s)</label>
                                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                                id="lastname" placeholder="Prénom(s)" name="lastname"
                                                value="{{ old('lastname') ?? $personal->user->lastname }}" required />
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="username" class="form-label">Nom d'utilisateur</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                                id="username" placeholder="Nom d'utilisateur" name="username"
                                                value="{{ old('username') ?? $personal->user->username }}" required />
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" placeholder="xyz@exemple.com" name="email"
                                                value="{{ old('email') ?? $personal->user->email }}" required />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone" class="form-label">N° téléphone</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" placeholder="0000000000" name="phone"
                                                value="{{ old('phone') ?? $personal->user->phone }}" required />
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="type" class="form-label">Type</label>
                                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                                <option value="" disabled {{ old('type') == '' ? 'selected' : '' }}>Sélectionner</option>
                                                <option value="civil" {{ (old('type') ?? $personal->type) == 'civil' ? 'selected' : '' }}>Civil</option>
                                                <option value="militaire" {{ (old('type') ?? $personal->type) == 'militaire' ? 'selected' : '' }}>Militaire</option>
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label for="roles" class="form-label">Cellule (Rôle)</label>
                                            <select class="form-select select2 @error('roles') is-invalid @enderror" id="roles" name="roles" required>
                                                <option value="" disabled {{ old('roles') == '' ? 'selected' : '' }}>Sélectionner</option>
                                                @foreach (TYPEUSER[1]['roles'] as $role)
                                                    <option value="{{ $role['name'] }}" {{ (old('roles') ?? $personal->user->roles[0]->name ?? '') == $role['name'] ? 'selected' : '' }}>
                                                        {{ $role['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('roles')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="permissions" class="form-label">Postes (Permissions)</label>
                                            <select class="form-select select2 @error('permissions') is-invalid @enderror" id="permissions" name="permissions[]" multiple>
                                                <option value="" disabled>Sélectionner un rôle d'abord</option>
                                            </select>
                                            @error('permissions')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 ville_section" style="display: none;">
                                            <label for="ville_barm" class="form-label">Point focal<span class="text-danger">*</span></label>
                                            <select id="ville_barm" class="form-select select2 @error('ville_barm') is-invalid @enderror" name="ville_barm">
                                                <option value="" disabled {{ old('ville_barm') == '' ? 'selected' : '' }}>Sélectionner</option>
                                                @foreach (FOCAL_POINT as $city)
                                                    <option value="{{ $city }}" {{ (old('ville_barm') ?? $personal->ville_barm ?? '') == $city ? 'selected' : '' }}>
                                                        {{ $city }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('ville_barm')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                            <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                            <a href="{{ route('personnel.index') }}" type="reset"
                                                class="btn btn-danger px-4">Annuler</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Onglet Mot de passe -->
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <div class="card">
                            <div class="card-header px-4 py-3 border-bottom">
                                <h5 class="mb-0">Modification du mot de passe</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('personnel.update.password', $personal->id) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="alert alert-info" role="alert">
                                        <h6 class="alert-heading mb-1">Informations importantes</h6>
                                        <span>Le nouveau mot de passe doit contenir au minimum 4 caractères.</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="password_new" class="form-label">Nouveau mot de passe</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password_new" name="password" placeholder="Nouveau mot de passe" required />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" 
                                                   placeholder="Confirmer le mot de passe" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                            <button type="submit" class="btn btn-warning px-4">Changer le mot de passe</button>
                                            <a href="{{ route('personnel.index') }}" class="btn btn-secondary px-4">Annuler</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            "use strict";

            // Initialisation de Select2
            $('.select2').select2({
                width: '100%'
            });

            const typeUserRoles = {!! json_encode(TYPEUSER[1]['roles']) !!};
            let selectedPermissions = [];

            // Fonction pour charger les permissions existantes
            function loadExistingPermissions() {
                let selectedRoleName = "{{ $personal->user->roles[0]->name ?? '' }}";
                let existingPermissions = {!! json_encode($personal->user->permissions->pluck('name')->toArray()) !!};
                
                if (selectedRoleName) {
                    selectedPermissions = [];
                    
                    typeUserRoles.forEach(role => {
                        if (role.name === selectedRoleName) {
                            selectedPermissions = role.permissions;
                        }
                    });

                    var perms = $("#permissions");
                    perms.empty();

                    selectedPermissions.forEach(function(permission) {
                        perms.append($('<option>', {
                            value: permission,
                            text: permission,
                            selected: existingPermissions.includes(permission)
                        }));
                    });

                    // Réinitialiser Select2 pour les permissions
                    perms.select2('destroy');
                    perms.select2({
                        width: '100%',
                        placeholder: 'Sélectionner les permissions'
                    });

                    // Afficher/masquer la section point focal
                    if(selectedRoleName === 'POINTS FOCAUX'){
                        $('.ville_section').css('display', 'block');
                        $('#ville_barm').attr('required', true);
                    } else {
                        $('.ville_section').css('display', 'none');
                        $('#ville_barm').attr('required', false);
                    }
                }
            }

            // Charger les permissions au chargement de la page
            loadExistingPermissions();

            // Gestion du changement de rôle
            $('#roles').on("change", function() {
                let selectedRoleName = this.value;
                selectedPermissions = [];

                // Récupérer les permissions du rôle sélectionné
                typeUserRoles.forEach(role => {
                    if (role.name === selectedRoleName) {
                        selectedPermissions = role.permissions;
                    }
                });

                // Mettre à jour les permissions disponibles
                var perms = $("#permissions");
                perms.empty();

                selectedPermissions.forEach(function(permission) {
                    perms.append($('<option>', {
                        value: permission,
                        text: permission
                    }));
                });

                // Réinitialiser Select2 pour les permissions
                perms.select2('destroy');
                perms.select2({
                    width: '100%',
                    placeholder: 'Sélectionner les permissions'
                });

                // Afficher/masquer la section point focal
                if(selectedRoleName === 'POINTS FOCAUX'){
                    $('.ville_section').css('display', 'block');
                    $('#ville_barm').attr('required', true);
                } else {
                    $('.ville_section').css('display', 'none');
                    $('#ville_barm').attr('required', false);
                }
            });

            // Génération automatique du nom d'utilisateur
            $('#firstname, #lastname').on('input', function() {
                let firstname = $('#firstname').val().toLowerCase().replace(/[^a-z]/g, '');
                let lastname = $('#lastname').val().toLowerCase().replace(/[^a-z]/g, '');
                
                if (firstname && lastname) {
                    let username = firstname + '.' + lastname;
                    $('#username').val(username);
                }
            });

            // Validation du formulaire principal (informations)
            $('form[action*="personnel.update"]').on('submit', function(e) {
                let isValid = true;
                let currentForm = $(this);
                
                // Vérifier que tous les champs requis du formulaire actuel sont remplis
                currentForm.find('input[required], select[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Vérifier que le point focal est sélectionné si le rôle est POINTS FOCAUX
                if (currentForm.find('#roles').val() === 'POINTS FOCAUX' && !currentForm.find('#ville_barm').val()) {
                    currentForm.find('#ville_barm').addClass('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });

            // Validation du formulaire de mot de passe
            $('form[action*="personnel.update.password"]').on('submit', function(e) {
                let isValid = true;
                let currentForm = $(this);

                // Vérifier que tous les champs requis du formulaire de mot de passe sont remplis
                currentForm.find('input[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });
        });
    </script>

    <style>
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            border-bottom: 2px solid transparent;
        }
        
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            background: none;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: #0d6efd;
        }
    </style>
@endsection
