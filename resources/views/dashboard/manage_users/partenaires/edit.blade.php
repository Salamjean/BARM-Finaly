@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Partenaires / </span> Modification
                </h4>

                <!-- Onglets -->
                <ul class="nav nav-tabs mb-4" id="partenaireTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                            type="button" role="tab" aria-controls="info" aria-selected="true">
                            Informations
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                            type="button" role="tab" aria-controls="password" aria-selected="false">
                            Mot de passe
                        </button>
                    </li>
                </ul>

                <!-- Contenu des onglets -->
                <div class="tab-content" id="partenaireTabsContent">
                    <!-- Onglet Informations -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <div class="card">
                            <div class="card-header px-4 py-3 border-bottom">
                                <h5 class="mb-0">Modification Partenaire</h5>
                            </div>
                            <div class="card-body p-4">
                                <form class="row g-3" method="POST"
                                    action="{{ route('partenaire.update', $partenaire->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-12 mb-3">
                                        <label for="username" class="form-label">Structure</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" placeholder="Structure" name="username"
                                            value="{{ $partenaire->user->username }}" disabled />
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">N° téléphone</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" placeholder="N° de telephone" name="phone"
                                                value="{{ old('phone') ?? $partenaire->phone_number }}" required />
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" placeholder="Adresse mail" name="email"
                                                value="{{ old('email') ?? $partenaire->user->email }}" required />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">

                                        <div class="col-md-12">
                                            <label for="address" class="form-label">Adresse</label>
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror" id="address"
                                                name="address" placeholder="Cocody, Riviera 2"
                                                value="{{ old('address') ?? $partenaire->address }}" required />
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Type de partenaire</label>
                                            <select class="form-select select2"
                                                data-placeholder="Choisir un ou plusieurs permissions" id="permissions"
                                                multiple name="permissions[]">
                                                @foreach (TYPEUSER[0]['permissions'] as $permission)
                                                    <option value="{{ $permission }}"
                                                        {{ in_array($permission, $user->permissions->pluck('name')->toArray()) ? 'selected' : '' }}>
                                                        {{ permissionFr($permission) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                            <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                            <a href="{{ route('partenaire.index') }}" type="reset"
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
                                <form method="POST" action="{{ route('partenaire.update.password', $partenaire->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="alert alert-info" role="alert">
                                        <h6 class="alert-heading mb-1">Informations importantes</h6>
                                        <span>Le nouveau mot de passe doit contenir au minimum 4 caractères.</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="password_new" class="form-label">Nouveau mot de passe</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password_new" name="password" placeholder="Nouveau mot de passe"
                                                required />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirmer le mot de
                                                passe</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" placeholder="Confirmer le mot de passe"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                            <button type="submit" class="btn btn-warning px-4">Changer le mot de
                                                passe</button>
                                            <a href="{{ route('partenaire.index') }}"
                                                class="btn btn-secondary px-4">Annuler</a>
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

            // Validation du formulaire principal (informations)
            $('form[action*="partenaire.update"]').on('submit', function(e) {
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

                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });

            // Validation du formulaire de mot de passe
            $('form[action*="partenaire.update.password"]').on('submit', function(e) {
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
