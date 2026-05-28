@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            {{-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Enregistrer</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li aria-current="page">Créer un utilisateur</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">  
                    <div class="btn-group">
                        <a href="{{ route('users.index') }}" type="button" class="btn btn-primary">Liste des utilisateurs</a>
                    </div>
                </div>
            </div> --}}
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Utilisateurs/</span> Créer un utilisateur
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Créer un utilisateur</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur : </label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bx-at'></i></span>
                                <input type="text" class="form-control @error('username') is-invalid @enderror border-start-0" id="username" placeholder="Nom d'utilisateur" name="username" value="{{ old('username') }}"/>
                            </div>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-12">
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
                        <div class="col-md-12">
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
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe </label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-lock-open' ></i></span>
                                <input type="text" class="form-control border-start-0" id="password" placeholder="Mot de passe" name="password" value="{{ old('password') }}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label">Confirmé mot de passe</label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-lock' ></i></span>
                                <input type="text" class="form-control border-start-0" id="confirm_password" placeholder="Confirmé mot de passe" name="confirm_password" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Roles :</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs roles" id="small-bootstrap-class-multiple-field" multiple name="roles[]">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('users.index') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
