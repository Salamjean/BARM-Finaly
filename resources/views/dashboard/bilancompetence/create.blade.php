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
                        <i class="bx bx-chart text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Bilan de compétences</div>
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
                    <h5 class="mb-0 text-dark">Nouveau bilan de compétences</h5>
                    <small class="text-muted">Création d'un nouveau bilan pour {{ $candidat->user->fullName() }}</small>
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
                        <form class="row g-3" method="POST" action="{{ route('bilancompetences.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="date" class="form-label">Ahdérent: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control border-start-0" value="{{ $candidat->user->fullName() }}" disabled/>
                                    <input type="text" class="form-control border-start-0" name='candidature_id' value="{{ $candidat->id }}" hidden />
                                </div>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="date" class="form-label">Date de tenue : </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bx-date'></i></span>
                                    <input type="date"
                                        class="form-control @error('date') is-invalid @enderror border-start-0" id="date"
                                        placeholder="Date" name="date" value="{{ old('date') }}" />
                                </div>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- <div class="col-md-6 mb-3">
                                <label class="form-label">Présence :</label>
                                <select class="form-select" data-placeholder="Choisir un élément"
                                    id="small-bootstrap-class-multiple-field2" name="presence">
                                    <option value="1">Présent</option>
                                    <option value="0">Abscent</option>
                                </select>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">commentaire: </label>
                                        <textarea name="comment" class="form-control" id="" cols="10" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Rapport</label>
                                <input type="file" name="rapport" class="form-control">
                            </div> -->
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bx bx-check me-1"></i>
                                        Enregistrer
                                    </button>
                                    <a href="{{ route('bilancompetences.index', $candidat->id) }}" type="reset"
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