@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light"> Suivi-Evaluation / PV Commité / </span> Création
                    </h4>
                </nav>
            </div>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body p-4">
                    <form id="creditCommitteeForm" class="row g-3" method="POST" action="{{ route('monitored-evaluation.credit_committee.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date de tenue :</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-date'></i></span>
                                <input type="date" class="form-control @error('date') is-invalid @enderror border-start-0"
                                    id="date"  name="date" value="{{ old('date') }}" required />
                            </div>
                            @error('date')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <input type="hidden" name="adherents_id" id="selectedCandidatesInput">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#candidateModal">
                            Choisir des candidats
                        </button>

                        <!-- Modal to Select Candidates -->
                        <div class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="candidateModalLabel">Sélectionner des candidats</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <input type="text" id="candidateSearch" class="form-control" placeholder="Rechercher un candidat par nom">
                                        </div>
                                        <div class="list-group" id="candidateList"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Valider la sélection</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons with Confirmation Modal Trigger -->
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <a href="{{ route('sessioncollectives.index') }}" class="btn btn-danger px-4">Annuler</a>
                                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmer l'enregistrement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir enregistrer ces informations pour le PV du comité de crédit ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmit">Confirmer</button>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            $(document).ready(function() {
                const candidateList = $('#candidateList');
                const selectedCandidates = new Set();
                const candidateData = @json($adherents);

                function renderCandidateList(data) {
                    candidateList.empty();
                    data.forEach(candidate => {
                        const isChecked = selectedCandidates.has(candidate.id) ? 'checked' : '';
                        candidateList.append(`
                            <label class="list-group-item">
                                <input type="checkbox" class="form-check-input me-1 candidate-checkbox" value="${candidate.id}" ${isChecked}>
                                ${candidate.user.mecano} | ${candidate.user.firstname} ${candidate.user.lastname}
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
                    const filteredCandidates = candidateData.filter(candidate => candidate.partner_technical_id === parseInt(selectedPartnerId));
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
                        const fullName = `${candidate.user.mecano} | ${candidate.user.firstname} ${candidate.user.lastname}`.toLowerCase();
                        return fullName.includes(searchTerm);
                    });
                    renderCandidateList(filteredCandidates);
                });

                // Confirmation modal handling
                $('#confirmSubmit').on('click', function() {
                    $('#creditCommitteeForm').submit();
                });
            });
        </script>
    @endpush
@endsection
