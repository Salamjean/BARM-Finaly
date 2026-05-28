@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Commissions d'approbations/</span> {{ $title }}
                </h4>
                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">{{ $title }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST" action="{{ route('commissions.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4 mb-3">
                                <label for="number" class="form-label">Numéro de la session :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-date'></i></span>
                                    <input type="text"
                                        class="form-control @error('number') is-invalid @enderror border-start-0"
                                        id="number" placeholder="Numéro" name="number" value="{{ old('number') }}" />
                                </div>
                                @error('number')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Date de tenue :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-date'></i></span>
                                    <input type="date"
                                        class="form-control @error('date') is-invalid @enderror border-start-0"
                                        id="date" placeholder="Date" name="date" value="{{ old('date') }}" />
                                </div>
                                @error('date')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="lieu" class="form-label">Lieu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bxs-map'></i></span>
                                    <input type="text" class="form-control border-start-0" id="lieu"
                                        placeholder="Lieu" name="lieu" value="{{ old('lieu') }}" />
                                </div>
                                @error('lieu')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <input type="hidden" name="cohort_id" value="{{ $cohort->id }}">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Membres du Jury :</label>
                                <select class="form-select select2" 
                                        data-placeholder="Choisir les membres du jury" 
                                        name="jury_members[]" 
                                        multiple>
                                    @foreach ($technicale_partenaires as $user_technicale)
                                        <option value="{{ $user_technicale->partenaire->id }}">
                                            {{ $user_technicale->username }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Sélectionnez plusieurs membres pour former le jury de la commission
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Partenaire Technique concerné :</label>
                                <select class="form-select select2" data-placeholder="Choisir un ou plusieurs partenaires"
                                    name="technicale_partenaires[]">
                                    @foreach ($technicale_partenaires as $user_technicale)
                                        <option value="{{ $user_technicale->partenaire->id }}">
                                            {{ $user_technicale->username }}</option>
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
                                            <div class="list-group" id="candidateList"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Valider
                                                la sélection</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
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

    @push('js-push')
        <script>
            $(document).ready(function() {
                // Initialisation de Select2 pour le select multiple des membres du jury
                $('.select2-multiple').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Choisir les membres du jury'
                });

                const candidateList = $('#candidateList');
                const selectedCandidates = new Set();
                const candidateData = @json($candidats);

                function renderCandidateList(data) {
                    candidateList.empty();
                    data.forEach(candidate => {
                        const isChecked = selectedCandidates.has(candidate.id) ? 'checked' : '';
                        candidateList.append(`
                    <label class="list-group-item">
                        <input type="checkbox" class="form-check-input me-1 candidate-checkbox" value="${candidate.id}" ${isChecked}>
                    ${candidate.partner_technical.user.username}  | ${candidate.user.mecano} | ${candidate.user.firstname} ${candidate.user.lastname} | Point Focal : ${candidate.focal_point_area}
                    </label>
                `);
                    });
                }

                function updateSelectedCandidatesInput() {
                    $('#selectedCandidatesInput').val(Array.from(selectedCandidates).join(','));
                }

                renderCandidateList(candidateData);

                $('select[name="technicale_partenaires[]"]').on('change', function() {
                    const selectedPartnerId = $(this).val();
                    const filteredCandidates = candidateData.filter(candidate => candidate
                        .partner_technical_id === parseInt(selectedPartnerId));
                    renderCandidateList(filteredCandidates);
                });

                candidateList.on('change', '.candidate-checkbox', function() {
                    const candidateId = $(this).val();
                    if (this.checked) {
                        selectedCandidates.add(candidateId);
                    } else {
                        selectedCandidates.delete(candidateId);
                    }
                    updateSelectedCandidatesInput();
                });

                $('#candidateSearch').on('input', function() {
                    const searchTerm = $(this).val().toLowerCase();
                    const filteredCandidates = candidateData.filter(candidate => {
                        const fullName =
                            `${candidate.user.mecano} | ${candidate.user.firstname} ${candidate.user.lastname}`
                            .toLowerCase();
                        return fullName.includes(searchTerm);
                    });
                    renderCandidateList(filteredCandidates);
                });
            });
        </script>
    @endpush
@endsection
