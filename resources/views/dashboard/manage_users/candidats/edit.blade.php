@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Candidats/</span> Créer un candidat
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Créer un candidat</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('admin.candidat.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="mecano" class="form-label">Mecano / Matricule</label>
                                <input type="text" class="form-control @error('mecano') is-invalid @enderror" id="mecano" name="mecano"
                                    placeholder="CS-000000/00" value="{{ old('mecano') ?? $candidat->user->mecano }}" disabled>
                                @error('mecano')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="last_name" class="form-label">Prénoms</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                    name="last_name" placeholder="Jaurès Sory" value="{{ old('last_name') ?? $candidat->user->lastname }}" required>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="first_name" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                    name="first_name" placeholder="Jean" value="{{ old('first_name') ?? $candidat->user->firstname}}" required>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="type_piece" class="form-label">Type de pièce</label>
                                <select class="form-select @error('type_piece') is-invalid @enderror"
                                    aria-label="Sélectionner un type de pièce" name="type_piece" required>
                                    <option value="" disabled {{ old('type_piece') == '' ? 'selected' : '' }}>Sélectionner</option>
                                    <option value="cni" {{ old('type_piece') ?? $candidat->type_piece == 'cni' ? 'selected' : '' }}>CNI</option>
                                    <option value="passeport" {{ old('type_piece') ?? $candidat->type_piece == 'passeport' ? 'selected' : '' }}>PASSEPORT</option>
                                    <option value="cmu" {{ old('type_piece') ?? $candidat->type_piece == 'cmu' ? 'selected' : '' }}>CMU</option>
                                </select>
                                @error('type_piece')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="no_card" class="form-label">N° de la carte</label>
                                <input type="text" class="form-control @error('no_card') is-invalid @enderror" id="no_card"
                                    name="no_card" placeholder="CI 0000000000" value="{{ old('no_card') ?? $candidat->no_card}}" required>
                                @error('no_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone_number" class="form-label">Contact</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">+225</span>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                                        name="phone_number" placeholder="05 00 00 00 00" value="{{ old('phone_number') ?? $candidat->phone_number}}" required
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
                            <div class="col-md-3 mb-3">
                                <label for="birth_date" class="form-label">Date de naissance</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                                    name="birth_date" value="{{ old('birth_date') ?? $candidat->birth_date}}" required>
                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">Genre</label>
                                <select class="form-select @error('gender') is-invalid @enderror" aria-label="Default select example"
                                    name="gender" required>
                                    <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>Sélectionner</option>
                                    <option value="masculin" {{ old('gender') ?? $candidat->gender == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                    <option value="feminin" {{ old('gender') ?? $candidat->gender == 'feminin' ? 'selected' : '' }}>Feminin</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="ethnic" class="form-label">Ethnie</label>
                                <select class="form-select @error('ethnic') is-invalid @enderror" aria-label="Default select example"
                                    name="ethnic" >
                                    <option value="" disabled {{ old('ethnic') == '' ? 'selected' : '' }}>Selectionner</option>
                                    @foreach (ETHNICS as $ethnic)
                                        <option value="{{ $ethnic }}" {{ old('ethnic') ?? $candidat->ethnic == $ethnic ? 'selected' : '' }}>
                                            {{ $ethnic }}</option>
                                    @endforeach
                                </select>
                                @error('ethnic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="religion" class="form-label">Réligion</label>
                                <select class="form-select @error('religion') is-invalid @enderror" aria-label="Default select example"
                                    name="religion" >
                                    <option value="" disabled {{ old('religion') == '' ? 'selected' : '' }}>Selectionner</option>
                                    @foreach (RELIGIONS as $religion)
                                        <option value="{{ $religion }}" {{ old('religion') ?? $candidat->religion == $religion ? 'selected' : '' }}>
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
                            <a href="{{ route('admin.candidat.index') }}" class="btn btn-secondary">
                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                <span class="d-sm-inline-block d-none">Retour</span>
                            </a>
                
                            <button class="btn btn-success d-grid">Soumettre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
<script>
    document.getElementById('phone_number').addEventListener('keypress', function(event) {
        var charCode = (typeof event.which == "number") ? event.which : event.keyCode;

        if (charCode < 48 || charCode > 57) {
            event.preventDefault();
        }
    });
</script>
@endsection
