@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Mise à disposition/</span> {{ $title }}
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('candidatentreprises.store_mise_a_disposition') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="entreprise">Entreprise :</label>
                            <select class="form-select select2" data-placeholder="Choisir une entreprise" name="entreprise" id="entreprise" onchange="toggleNomEntreprise()">
                                <option selected>Selectionnez une entreprise</option>
                                @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->nom }}">{{ $entreprise->nom }}</option>
                                @endforeach
                                <option value="other">Autre</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" id="nom-entreprise-div" style="display: none;">
                            <label for="nom" class="form-label">Nom de l'entreprise: </label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" />
                            </div>
                            @error('nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Candidat(s) :</label>
                            <select class="form-select select2" data-placeholder="Choisir un ou plusieurs candidats" id="small-bootstrap-class-multiple-field2" multiple name="candidatures[]">
                                @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}">{{ $candidat->user->fullname()}} -  {{$candidat->user->mecano }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="poste" class="form-label">Poste à promouvoir <span
                            class="text-danger">*</span> : </label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('poste') is-invalid @enderror" id="poste" placeholder="" name="poste" value="{{ old('poste') }}" />
                            </div>
                            @error('poste')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_mise_disposition" class="form-label">Date de mise à disposition <span
                            class="text-danger">*</span> : </label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('date_mise_disposition') is-invalid @enderror" id="date_mise_disposition" placeholder="Date" name="date_mise_disposition" value="{{ old('date_mise_disposition') }}" />
                            </div>
                            @error('date_mise_disposition')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('candidatentreprises.candidats') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js-push')

<script>
    function toggleNomEntreprise() {
        var select = document.getElementById('entreprise');
        var nomEntrepriseDiv = document.getElementById('nom-entreprise-div');
        if (select.value === 'other') {
            nomEntrepriseDiv.style.display = 'block';
        } else {
            nomEntrepriseDiv.style.display = 'none';
        }
    }
</script>

@endpush
