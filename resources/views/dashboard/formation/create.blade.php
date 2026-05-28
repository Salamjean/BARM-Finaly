@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-book-open text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Formations</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center">
                <i class="bx bx-plus-circle text-info fs-3 me-3"></i>
                <div>
                    <h5 class="mb-0 text-dark">Nouvelle formation professionnelle</h5>
                    <small class="text-muted">Création d'un nouveau programme de formation</small>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">{{ $title }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('formations.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="entreprise">Entreprise :</label>
                                <select class="form-select select2" data-placeholder="Choisir une entreprise"
                                    name="entreprise" id="entreprise" onchange="toggleNomEntreprise()">
                                    <option selected>Choisir une entreprise</option>
                                    @foreach ($entreprises as $entreprise)
                                        <option value="{{ $entreprise->nom }}">{{ $entreprise->nom }}</option>
                                    @endforeach
                                    <option value="other">Autre</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3" id="nom-entreprise-div" style="display: none;">
                                <label for="nom" class="form-label">Nom de l'entreprise: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                        id="nom" name="nom" />
                                </div>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="intitule" class="form-label">Intitulé</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="intitule" placeholder="Intitule"
                                        name="intitule" value="{{ old('intitule') }}" />
                                </div>
                                @error('intitule')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lieu" class="form-label">Lieu</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-map'></i></span>
                                    <input type="text" class="form-control border-start-0" id="lieu"
                                        placeholder="Lieu" name="lieu" value="{{ old('lieu') }}" />
                                </div>
                                @error('lieu')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="date_db" class="form-label">Date de debut : </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bx-date'></i></span>
                                    <input type="date"
                                        class="form-control @error('date_db') is-invalid @enderror border-start-0"
                                        id="date_db" placeholder="Date" name="date_db" value="{{ old('date_db') }}" />
                                </div>
                                @error('date_db')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="date_fin" class="form-label">Date de fin : </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bx-date'></i></span>
                                    <input type="date"
                                        class="form-control @error('date_fin') is-invalid @enderror border-start-0"
                                        id="date_fin" placeholder="Date" name="date_fin" value="{{ old('date_fin') }}" />
                                </div>
                                @error('date_fin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Candidat(s) :</label>
                                <select class="form-select select2" data-placeholder="Choisir un ou plusieurs candidats"
                                    id="small-bootstrap-class-multiple-field2" multiple name="candidatures[]" required>
                                    @foreach ($candidats as $candidat)
                                        <option value="{{ $candidat->id }}">{{ $candidat->user->fullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bx bx-check me-1"></i>
                                        Enregistrer
                                    </button>
                                    <a href="{{ route('formations.index') }}" type="reset"
                                        class="btn btn-danger px-4">
                                        <i class="bx bx-x me-1"></i>
                                        Annuler
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection