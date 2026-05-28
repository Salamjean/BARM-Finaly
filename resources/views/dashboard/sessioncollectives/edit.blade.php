@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Sessions Collectives d'Informations/</span> Modifier une session
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Modifier une session</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('sessioncollectives.update', $sessioncollective) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Date de tenue : </label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bx-date'></i></span>
                                <input type="date"
                                    class="form-control @error('date') is-invalid @enderror border-start-0" id="date"
                                    placeholder="Date" name="date" value="{{ $sessioncollective->date }}" />
                            </div>
                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="lieu" class="form-label">Lieu</label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-map'></i></span>
                                <input type="text" class="form-control border-start-0" id="lieu" placeholder="Lieu"
                                    name="lieu" value="{{ $sessioncollective->lieu }}" />
                            </div>
                            @error('lieu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="heure" class="form-label">Heure</label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-time'></i></span>
                                <input type="time" class="form-control border-start-0" id="heure" placeholder="Heure"
                                    name="heure" value="{{ $sessioncollective->heure }}" />
                            </div>
                            @error('heure')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Partenaire(s) Technique(s) :</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs partenaires"
                                id="small-bootstrap-class-multiple-field" multiple name="technicale_partenaires[]">
                                @foreach($technicale_partenaires as $user_technicale)
                                <option value="{{ $user_technicale->partenaire->id }}" {{ in_array($user_technicale->partenaire->id, $sessioncollective->partenaires->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $user_technicale->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Partenaire(s) Financier(s) :</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs partenaires"
                                id="small-bootstrap-class-multiple-field1" multiple name="financial_partenaires[]">
                                @foreach($financial_partenaires as $user_financial)
                                <option value="{{ $user_financial->partenaire->id }}" {{ in_array($user_financial->partenaire->id, $sessioncollective->partenaires->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $user_financial->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Candidat(s) :</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs candidats"
                                id="small-bootstrap-class-multiple-field2" multiple name="candidatures[]">
                                @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}" {{ in_array($candidat->id, $sessioncollective->candidatures->pluck('id')->toArray()) ? 'selected' : ''}}>{{ $candidat->user->lastname }} {{ $candidat->user->firstname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                <a href="{{ route('sessioncollectives.index') }}" type="reset"
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