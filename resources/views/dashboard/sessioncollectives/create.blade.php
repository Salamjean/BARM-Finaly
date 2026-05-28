@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Sessions Collectives d'Informations/</span> Créer une session
                </h4>
                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">Créer une session</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('sessioncollectives.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Cohorte :</label>
                                <select class="form-select select2" data-placeholder="Choisir une cohorte" name="cohort_id"
                                    id="cohortSelect">
                                    @foreach ($cohortes as $cohorte)
                                        <option value="{{ $cohorte->id }}">{{ $cohorte->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Date de tenue : </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bx-date'></i></span>
                                    <input type="date"
                                        class="form-control @error('date') is-invalid @enderror border-start-0"
                                        id="date" placeholder="Date" name="date" value="{{ old('date') }}" />
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
                                    <input type="text" class="form-control border-start-0" id="lieu"
                                        placeholder="Lieu" name="lieu" value="{{ old('lieu') }}" />
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
                                    <input type="time" class="form-control border-start-0" id="heure"
                                        placeholder="Heure" name="heure" value="{{ old('heure') }}" />
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
                                    @foreach ($technicale_partenaires as $user_technicale)
                                        <option value="{{ $user_technicale->partenaire->id }}">
                                            {{ $user_technicale->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Partenaire(s) Financier(s) :</label>
                                <select class="form-select select2" data-placeholder="Choisir un ou plusieurs partenaires"
                                    id="small-bootstrap-class-multiple-field1" multiple name="financial_partenaires[]">
                                    @foreach ($financial_partenaires as $user_financial)
                                        <option value="{{ $user_financial->partenaire->id }}">
                                            {{ $user_financial->username }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="candidatures" id="selectedCandidatesInput">

                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#candidateModal">
                                Choisir des candidats
                            </button>

                            <div class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="candidateModalLabel">Sélectionner des candidats</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input type="text" id="candidateSearch" class="form-control"
                                                    placeholder="Rechercher un candidat par nom">
                                            </div>
                                            <div class="list-group" id="candidateList">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-bs-dismiss="modal">Valider la sélection</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <a href="{{ route('sessioncollectives.index') }}" type="reset"
                                        class="btn btn-danger px-4">Annuler</a>
                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
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
            var candidateModalBody = $('#candidateList');
            var selectedCandidates = new Set();
            var candidateData = [];

            function populateCandidates(cohortId) {
                $.ajax({
                    url: "/getCandidats",
                    data: {
                        cohortId: cohortId
                    },
                    success: function(data) {
                        candidateData = data; 
                        renderCandidateList(data);
                    }
                });
            }

            function renderCandidateList(data) {
                candidateModalBody.empty();
                $.each(data, function(index, candidate) {
                    var candidateItem = `
                <label class="list-group-item">
                    <input type="checkbox" class="form-check-input me-1 candidate-checkbox" value="${candidate.id}" ${selectedCandidates.has(candidate.id) ? 'checked' : ''}>
                    ${candidate.name}
                </label>
            `;
                    candidateModalBody.append(candidateItem);
                });
            }

            function updateSelectedCandidatesInput() {
                $('#selectedCandidatesInput').val(Array.from(selectedCandidates).join(','));
            }

            populateCandidates(cohortSelect.val());

            cohortSelect.change(function() {
                var cohortId = $(this).val();
                populateCandidates(cohortId);
            });

            candidateModalBody.on('change', '.candidate-checkbox', function() {
                var candidateId = $(this).val();
                if (this.checked) {
                    selectedCandidates.add(candidateId);
                } else {
                    selectedCandidates.delete(candidateId);
                }
                updateSelectedCandidatesInput();
            });

            $('#candidateSearch').on('input', function() {
                var searchTerm = $(this).val().toLowerCase();
                var filteredCandidates = candidateData.filter(function(candidate) {
                    return candidate.name.toLowerCase().includes(searchTerm);
                });
                renderCandidateList(filteredCandidates);
            });
        });
    </script>
@endpush

