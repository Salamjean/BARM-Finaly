@extends('layouts.auth', ['title' => 'B.A.R.M | ' . $title, 'type' => 'register', 'asset' => 'assets/img/logo/03.gif'])
@section('content')
    <h5 class="mb-3 text-center fw-bold">INSCRIVEZ VOUS</h5>
    <br>
    <form class="mb-3" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="mecano" class="form-label">Mecano / Matricule <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano"
                    name="mecano" placeholder="CS-000000/00" value="{{ old('mecano') }}" required>
                @error('mecano')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone_number" class="form-label">Contact<span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">+225</span>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                        name="phone_number" placeholder="05 00 00 00 00" value="{{ old('phone_number') }}" required
                        pattern="[0-9]{10}" maxlength="10" minlength="10" />
                </div>
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name" class="form-label">Nom<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                    name="first_name" placeholder="Jean" value="{{ old('first_name') }}" required>
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="last_name" class="form-label">Prénoms<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                    name="last_name" placeholder="Jaurès Sory" value="{{ old('last_name') }}" required>
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="sarahndri@kks-technologies.com" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="type_piece" class="form-label">Type de pièce<span class="text-danger">*</span></label>
                <select class="form-select @error('type_piece') is-invalid @enderror"
                    aria-label="Sélectionner un type de pièce" name="type_piece" required>
                    <option value="" disabled {{ old('type_piece') == '' ? 'selected' : '' }}>Sélectionner</option>
                    @foreach (TYPEPIECES as $type_piece)
                        <option value="{{ $type_piece }}" {{ old('type_piece') == $type_piece ? 'selected' : '' }}>
                            {{ $type_piece }}</option>
                    @endforeach
                </select>
                @error('type_piece')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="no_card" class="form-label">N° de la carte<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('no_card') is-invalid @enderror" id="no_card"
                    name="no_card" placeholder="CI 0000000000" value="{{ old('no_card') }}" required>
                @error('no_card')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="birth_date" class="form-label">Date de naissance<span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                    name="birth_date" value="{{ old('birth_date') }}" max="<?php echo date('Y-m-d', strtotime('-10 years')); ?>" required>
                @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="gender" class="form-label">Genre<span class="text-danger">*</span></label>
                <select class="form-select @error('gender') is-invalid @enderror" aria-label="Default select example"
                    name="gender" required>
                    <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>Sélectionner</option>
                    @foreach (GENDERS as $gender)
                        <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>
                            {{ $gender }}</option>
                    @endforeach
                </select>
                @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="ethnic" class="form-label">Ethnie<span class="text-danger">*</span></label>
                <select class="form-select @error('ethnic') is-invalid @enderror" aria-label="Default select example"
                    name="ethnic" >
                    <option value="" disabled {{ old('ethnic') == '' ? 'selected' : '' }}>Selectionner</option>
                    @foreach (ETHNICS as $ethnic)
                        <option value="{{ $ethnic }}" {{ old('ethnic') == $ethnic ? 'selected' : '' }}>
                            {{ $ethnic }}</option>
                    @endforeach
                </select>
                @error('ethnic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="religion" class="form-label">Réligion<span class="text-danger">*</span></label>
                <select class="form-select @error('religion') is-invalid @enderror" aria-label="Default select example"
                    name="religion" >
                    <option value="" disabled {{ old('religion') == '' ? 'selected' : '' }}>Selectionner</option>
                    @foreach (RELIGIONS as $religion)
                        <option value="{{ $religion }}" {{ old('religion') == $religion ? 'selected' : '' }}>
                            {{ $religion }}</option>
                    @endforeach
                </select>
                @error('religion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <br><br>

        <div class="col-12 d-flex justify-content-between">
            <a href="{{ url('/login') }}" class="btn btn-secondary">
                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="d-sm-inline-block d-none">Retour</span>
            </a>

            <button class="btn btn-success d-grid">S'inscrire</button>
        </div>
    </form>
    <script>
        document.getElementById('phone_number').addEventListener('keypress', function(event) {
            var charCode = (typeof event.which == "number") ? event.which : event.keyCode;

            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        });
    </script>
@endsection
