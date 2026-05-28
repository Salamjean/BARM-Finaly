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
                        <i class="bx bx-buildings text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Entreprises</div>
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
                    <h5 class="mb-0 text-dark">Nouvelle entreprise partenaire</h5>
                    <small class="text-muted">Enregistrement d'une nouvelle entreprise dans le réseau</small>
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
                        <form class="row g-3" method="POST" action="{{ route('entreprises.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom de l'entreprise: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"/>
                                </div>
                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="specialisation" class="form-label">Spécialisation de l'entreprise: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('specialisation') is-invalid @enderror" id="specialisation" name="specialisation" />
                                </div>
                                @error('specialisation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="localisation" class="form-label">Localisation de l'entreprise: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('localisation') is-invalid @enderror" id="localisation" name="localisation" />
                                </div>
                                @error('localisation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="num_decharge" class="form-label">Numéro de téléphone de l'entreprise: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('num_decharge') is-invalid @enderror"
                                        id="num_decharge" name="num_decharge" />
                                </div>
                                @error('num_decharge')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nom_point_focal" class="form-label">Nom du point focal: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('nom_point_focal') is-invalid @enderror"
                                        id="nom_point_focal" name="nom_point_focal" />
                                </div>
                                @error('nom_point_focal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="num_point_focal" class="form-label">Numéro du point focal: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('num_point_focal') is-invalid @enderror"
                                        id="num_point_focal" name="num_point_focal" />
                                </div>
                                @error('num_point_focal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email_point_focal" class="form-label">Email du point focal: </label>
                                <div class="input-group">
                                    <input type="email" class="form-control @error('email_point_focal') is-invalid @enderror"
                                        id="email_point_focal" name="email_point_focal" />
                                </div>
                                @error('email_point_focal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bx bx-check me-1"></i>
                                        Enregistrer
                                    </button>
                                    <a href="{{ route('entreprises.index') }}" type="reset"
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
            $(document).ready(function() {
                    var cohortSelect = $('#cohortSelect');
                    var candidateSelect = $('#candidateSelect');

                    function populateCandidates(cohortId) {
                        $.ajax({
                        url: "/getCandidats",
                        data: { cohortId: cohortId },
                        success: function(data) {
                            candidateSelect.empty();

                            $.each(data, function(index, candidate) {
                            candidateSelect.append($('<option>').val(candidate.id).text(candidate.name));
                            });
                        }
                        });
                    }

                    populateCandidates(cohortSelect.val());

                    cohortSelect.change(function() {
                        var cohortId = $(this).val();
                        populateCandidates(cohortId);
                    });
                });
        </script>
    @endpush
@endsection