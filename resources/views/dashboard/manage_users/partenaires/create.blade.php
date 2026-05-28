@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Partenaires /</span> Création
                </h4>
                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">Enregistrement Partenaire</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('partenaire.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="username" class="form-label">Structure : </label>
                                <div class="input-group"> 
                                    <input type="text"
                                        class="form-control @error('username') is-invalid @enderror"
                                        id="username" placeholder="Structure" name="username"
                                        value="{{ old('username') }}" />
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">N° téléphone</label>
                                <div class="input-group"> 
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        placeholder="N° de telephone" name="phone"
                                        value="{{ old('phone') }}" />
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <div class="input-group"> 
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                        placeholder="Adresse mail" name="email" value="{{ old('email') }}" />
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label">Adresse</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" placeholder="Cocody, Riviera 2"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Type de partenaire :</label>
                                <select class="form-select select2" data-placeholder="Choisir un ou plusieurs permissions"
                                    id="small-bootstrap-class-multiple-field" multiple name="permissions[]">
                                    @foreach (TYPEUSER[0]['permissions'] as $permission)
                                        <option value="{{ $permission }}">{{ permissionFr($permission) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                    <a href="{{ route('partenaire.index') }}" type="reset"
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
