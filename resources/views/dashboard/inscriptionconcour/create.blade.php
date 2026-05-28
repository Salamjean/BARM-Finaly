@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Inscriptions/</span> {{ $title }}
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('inscriptionconcours.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <label for="candidature_id" class="form-label">Ahdérent: </label>
                            <div class="input-group">
                                <input type="text" class="form-control border-start-0" value="{{ $candidat->user->fullName() }}" disabled/>
                                <input type="text" class="form-control border-start-0" name='candidature_id' value="{{ $candidat->id }}" hidden />
                            </div>
                            @error('candidature_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="intitule_concours" class="form-label">Intitulé du concours: </label>
                            <div class="input-group">
                                <input type="text"
                                    class="form-control @error('intitule_concours') is-invalid @enderror" id="intitule_concours"
                                    placeholder="intitulé concours" name="intitule_concours" value="{{ old('intitule_concours') }}" />
                            </div>
                            @error('intitule_concours')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="type_concours" class="form-label">Type du concours : </label>
                            <div class="input-group">
                                <input type="text"
                                    class="form-control @error('type_concours') is-invalid @enderror" id="type_concours"
                                    placeholder="type concours" name="type_concours" value="{{ old('type_concours') }}" />
                            </div>
                            @error('type_concours')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Date d'inscription: </label>
                            <div class="input-group"> <span class="input-group-text"></span>
                                <input type="date"
                                    class="form-control @error('date') is-invalid @enderror border-start-0" id="date"
                                    placeholder="date" name="date" value="{{ old('date') }}" />
                            </div>
                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="recu">Reçu de l'inscription <span
                            class="text-danger">*</span>:</label>
                            <input type="file" id="recu" name="recu" class="form-control @error('recu') is-invalid @enderror">

                            @error('recu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('inscriptionconcours.index', $candidat->id) }}" type="reset"
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
