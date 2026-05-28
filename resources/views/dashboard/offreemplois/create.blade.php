@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Offres d'emplois/</span> {{ $title }}
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('offreemplois.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <label for="libelle" class="form-label">Intitulé <span
                                class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="libelle" placeholder="Intitule" name="libelle" required
                                    value="{{ old('libelle') }}" />
                            </div>
                            @error('libelle')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description: </label>
                            <div class="input-group">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="" cols="30" rows="10"></textarea>
                            </div>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="localisation" class="form-label">Localisation <span
                                class="text-danger">*</span></label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bxs-map'></i></span>
                                <input type="text" class="form-control border-start-0" id="localisation" placeholder="localisation" name="localisation" required
                                    value="{{ old('localisation') }}" />
                            </div>
                            @error('localisation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="datefin" class="form-label">Date de fin : </label>
                            <div class="input-group"> <span class="input-group-text"><i class='bx bx-date'></i></span>
                                <input type="date" class="form-control @error('datefin') is-invalid @enderror" id="datefin"
                                    placeholder="Date" name="datefin" value="{{ old('datefin') }}" />
                            </div>
                            @error('datefin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('offreemplois.index') }}" type="reset"
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
