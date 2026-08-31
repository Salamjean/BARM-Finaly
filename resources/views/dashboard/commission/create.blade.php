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
                                <label for="number" class="form-label">Numéro de la session : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-hash'></i></span>
                                    <input type="text"
                                        class="form-control @error('number') is-invalid @enderror border-start-0"
                                        id="number" placeholder="Ex: Session N° 01/2024" name="number" value="{{ old('number') }}" required />
                                </div>
                                @error('number')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Date de tenue : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                    <input type="date"
                                        class="form-control @error('date') is-invalid @enderror border-start-0"
                                        id="date" name="date" value="{{ old('date') }}" required />
                                </div>
                                @error('date')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lieu" class="form-label">Lieu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bxs-map'></i></span>
                                    <input type="text" class="form-control border-start-0" id="lieu"
                                        placeholder="Ex: Siège BARM Abidjan" name="lieu" value="{{ old('lieu') }}" />
                                </div>
                                @error('lieu')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <input type="hidden" name="cohort_id" value="{{ $cohort->id }}">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Membres du Jury : <span class="text-danger">*</span></label>
                                <select class="form-select select2" 
                                        data-placeholder="Choisir les membres du jury" 
                                        name="jury_members[]" 
                                        multiple required>
                                    @foreach ($technicale_partenaires as $user_technicale)
                                        @if($user_technicale->partenaire)
                                            <option value="{{ $user_technicale->partenaire->id }}">
                                                {{ $user_technicale->username }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Sélectionnez un ou plusieurs membres pour former le jury d'évaluation.
                                </div>
                                @error('jury_members')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0">Partenaires Techniques concernés : <span class="text-danger">*</span></label>
                                    <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none" id="selectAllPartnersBtn">
                                        <i class="bx bx-check-double me-1"></i>Sélectionner tous les partenaires
                                    </button>
                                </div>
                                <select class="form-select select2" id="technical_partner_select" 
                                    data-placeholder="Choisir un ou plusieurs partenaires techniques (ANADER, AGEFOP, INIE, PFS-CI...)"
                                    name="technicale_partenaires[]" multiple required>
                                    @foreach ($technicale_partenaires as $user_technicale)
                                        @if($user_technicale->partenaire)
                                            <option value="{{ $user_technicale->partenaire->id }}">
                                                {{ $user_technicale->username }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Vous pouvez associer plusieurs partenaires techniques (ANADER, AGEFOP, INIE, PFS-CI...). L'ensemble des candidats choisis sera validé au sein de la même commission.
                                </div>
                                @error('technicale_partenaires')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Section Candidats -->
                            <div class="col-md-12 mb-3">
                                <input type="hidden" name="candidatures" id="selectedCandidatesInput">
                                <button type="button" class="btn btn-outline-primary w-100 py-2 d-flex justify-content-center align-items-center gap-2" id="openCandidateModalBtn" data-bs-toggle="modal"
                                    data-bs-target="#candidateModal">
                                    <i class="bx bx-user-plus fs-5"></i>
                                    <span id="btnModalText">Choisir des candidats</span>
                                    <span class="badge bg-primary text-white ms-2" id="selectedCountBadge" style="display: none;">0 sélectionné(s)</span>
                                </button>
                                @error('candidatures')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Modale de sélection des candidats -->
                            <div class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title" id="candidateModalLabel">
                                                <i class="bx bx-user-check text-primary me-2"></i>Sélectionner les candidats pour la commission
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-2 mb-3">
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                                                        <input type="text" id="candidateSearch" class="form-control"
                                                            placeholder="Rechercher par nom, prénom ou mécano...">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                                        <select id="modalPartnerFilter" class="form-select">
                                                            <option value="all">Tous les partenaires</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                                                <span class="text-muted small" id="eligibleCountInfo">0 candidat(s) éligible(s)</span>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 me-3" id="selectAllBtn">Tout cocher visibles</button>
                                                    <button type="button" class="btn btn-sm btn-link text-decoration-none text-danger p-0" id="unselectAllBtn">Tout décocher visibles</button>
                                                </div>
                                            </div>
                                            <div class="list-group" id="candidateList" style="max-height: 380px; overflow-y: auto;"></div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                                <i class="bx bx-check me-1"></i> Valider la sélection (<span id="modalFooterCount">0</span>)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <a href="{{ route('commissions.index', $cohort->id) }}"
                                        class="btn btn-danger px-4">Annuler</a>
                                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">Enregistrer</button>
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
                // Initialisation de Select2 pour tous les champs select2
                if ($.fn.select2) {
                    $('.select2').select2({
                        width: '100%',
                        allowClear: true
                    });
                }

                const candidateList = $('#candidateList');
                const selectedCandidates = new Set();
                const candidateData = @json($candidats);

                // Fonction pour déterminer le style de badge selon le partenaire
                function getPartnerBadge(partnerName) {
                    const name = (partnerName || '').toUpperCase();
                    if (name.includes('ANADER')) {
                        return '<span class="badge bg-success text-white"><i class="bx bx-buildings me-1"></i>' + partnerName + '</span>';
                    } else if (name.includes('AGEFOP')) {
                        return '<span class="badge bg-primary text-white"><i class="bx bx-buildings me-1"></i>' + partnerName + '</span>';
                    } else if (name.includes('INIE')) {
                        return '<span class="badge bg-warning text-dark"><i class="bx bx-buildings me-1"></i>' + partnerName + '</span>';
                    } else if (name.includes('PFS')) {
                        return '<span class="badge bg-info text-white"><i class="bx bx-buildings me-1"></i>' + partnerName + '</span>';
                    }
                    return '<span class="badge bg-secondary text-white"><i class="bx bx-buildings me-1"></i>' + partnerName + '</span>';
                }

                function getSelectedPartnerIds() {
                    const vals = $('#technical_partner_select').val() || [];
                    return vals.map(function(id) { return parseInt(id); });
                }

                function updateModalPartnerFilterOptions() {
                    const selectedPartnerIds = getSelectedPartnerIds();
                    const filterSelect = $('#modalPartnerFilter');
                    const previousVal = filterSelect.val();

                    filterSelect.find('option:not([value="all"])').remove();

                    $('#technical_partner_select option:selected').each(function() {
                        const partnerId = $(this).val();
                        const partnerName = $(this).text().trim();
                        filterSelect.append(`<option value="${partnerId}">${partnerName}</option>`);
                    });

                    if (selectedPartnerIds.includes(parseInt(previousVal))) {
                        filterSelect.val(previousVal);
                    } else {
                        filterSelect.val('all');
                    }
                }

                function getFilteredCandidates() {
                    const selectedPartnerIds = getSelectedPartnerIds();
                    if (selectedPartnerIds.length === 0) {
                        return [];
                    }

                    let filtered = candidateData.filter(function(candidate) {
                        return selectedPartnerIds.includes(candidate.partner_technical_id);
                    });

                    const partnerFilter = $('#modalPartnerFilter').val();
                    if (partnerFilter && partnerFilter !== 'all') {
                        filtered = filtered.filter(function(candidate) {
                            return candidate.partner_technical_id === parseInt(partnerFilter);
                        });
                    }

                    const searchTerm = $('#candidateSearch').val().toLowerCase().trim();
                    if (searchTerm) {
                        filtered = filtered.filter(function(candidate) {
                            const firstname = (candidate.user && candidate.user.firstname) ? candidate.user.firstname : '';
                            const lastname = (candidate.user && candidate.user.lastname) ? candidate.user.lastname : '';
                            const mecano = (candidate.user && candidate.user.mecano) ? candidate.user.mecano : '';
                            const fullName = `${mecano} ${firstname} ${lastname}`.toLowerCase();
                            return fullName.includes(searchTerm);
                        });
                    }

                    return filtered;
                }

                function renderCandidateList() {
                    const selectedPartnerIds = getSelectedPartnerIds();
                    candidateList.empty();

                    if (selectedPartnerIds.length === 0) {
                        $('#eligibleCountInfo').text('Aucun partenaire sélectionné');
                        candidateList.append(`
                            <div class="text-center p-4 text-muted">
                                <i class="bx bx-info-circle fs-2 text-secondary mb-2"></i>
                                <div>Veuillez sélectionner au moins un <strong>Partenaire Technique</strong> (ex: ANADER, AGEFOP, INIE, PFS-CI) dans le formulaire avant de choisir des candidats.</div>
                            </div>
                        `);
                        return;
                    }

                    const candidates = getFilteredCandidates();
                    $('#eligibleCountInfo').text(`${candidates.length} candidat(s) affiché(s)`);

                    if (candidates.length === 0) {
                        candidateList.append(`
                            <div class="text-center p-4 text-muted">
                                <i class="bx bx-user-x fs-2 text-warning mb-2"></i>
                                <div>Aucun candidat éligible trouvé pour les critères sélectionnés.</div>
                            </div>
                        `);
                        return;
                    }

                    candidates.forEach(function(candidate) {
                        const isChecked = selectedCandidates.has(String(candidate.id)) ? 'checked' : '';
                        const partnerName = (candidate.partner_technical && candidate.partner_technical.user && candidate.partner_technical.user.username) 
                            ? candidate.partner_technical.user.username 
                            : 'N/A';
                        const mecano = (candidate.user && candidate.user.mecano) ? candidate.user.mecano : 'N/A';
                        const firstname = (candidate.user && candidate.user.firstname) ? candidate.user.firstname : '';
                        const lastname = (candidate.user && candidate.user.lastname) ? candidate.user.lastname : '';
                        const focalPoint = candidate.focal_point_area ? candidate.focal_point_area : 'N/A';
                        const badgeHtml = getPartnerBadge(partnerName);

                        candidateList.append(`
                            <label class="list-group-item list-group-item-action d-flex align-items-center py-2 px-3">
                                <input type="checkbox" class="form-check-input me-3 candidate-checkbox" value="${candidate.id}" ${isChecked}>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">${firstname} ${lastname}</strong>
                                        <span class="badge bg-label-info">${mecano}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                        ${badgeHtml}
                                        <small class="text-muted">
                                            <i class="bx bx-map-pin me-1"></i>Point Focal : ${focalPoint}
                                        </small>
                                    </div>
                                </div>
                            </label>
                        `);
                    });
                }

                function updateSelectedUI() {
                    const count = selectedCandidates.size;
                    $('#selectedCandidatesInput').val(Array.from(selectedCandidates).join(','));
                    $('#modalFooterCount').text(count);

                    if (count > 0) {
                        $('#selectedCountBadge').text(`${count} sélectionné(s)`).show();
                        $('#btnModalText').text('Modifier la sélection des candidats');
                    } else {
                        $('#selectedCountBadge').hide();
                        $('#btnModalText').text('Choisir des candidats');
                    }
                }

                // Bouton sélectionner tous les partenaires
                $('#selectAllPartnersBtn').on('click', function() {
                    const allVals = [];
                    $('#technical_partner_select option').each(function() {
                        if ($(this).val()) {
                            allVals.push($(this).val());
                        }
                    });
                    $('#technical_partner_select').val(allVals).trigger('change');
                });

                // Événement lors du changement de Partenaires Techniques
                $('#technical_partner_select').on('change select2:select select2:unselect', function() {
                    const selectedPartnerIds = getSelectedPartnerIds();

                    // Nettoyer uniquement les candidats dont le partenaire n'est plus sélectionné
                    selectedCandidates.forEach(function(cId) {
                        const candidate = candidateData.find(function(c) { return String(c.id) === String(cId); });
                        if (candidate && !selectedPartnerIds.includes(candidate.partner_technical_id)) {
                            selectedCandidates.delete(cId);
                        }
                    });

                    updateModalPartnerFilterOptions();
                    renderCandidateList();
                    updateSelectedUI();
                });

                // Filtre par partenaire dans la modale
                $('#modalPartnerFilter').on('change', function() {
                    renderCandidateList();
                });

                // Événement case à cocher pour un candidat
                candidateList.on('change', '.candidate-checkbox', function() {
                    const candidateId = String($(this).val());
                    if (this.checked) {
                        selectedCandidates.add(candidateId);
                    } else {
                        selectedCandidates.delete(candidateId);
                    }
                    updateSelectedUI();
                });

                // Tout cocher dans la vue actuelle
                $('#selectAllBtn').on('click', function() {
                    const candidates = getFilteredCandidates();
                    candidates.forEach(function(c) {
                        selectedCandidates.add(String(c.id));
                    });
                    renderCandidateList();
                    updateSelectedUI();
                });

                // Tout décocher dans la vue actuelle
                $('#unselectAllBtn').on('click', function() {
                    const candidates = getFilteredCandidates();
                    candidates.forEach(function(c) {
                        selectedCandidates.delete(String(c.id));
                    });
                    renderCandidateList();
                    updateSelectedUI();
                });

                // Recherche dynamique de candidat
                $('#candidateSearch').on('input', function() {
                    renderCandidateList();
                });

                // Validation lors de la soumission du formulaire
                $('form').on('submit', function(e) {
                    if (selectedCandidates.size === 0) {
                        e.preventDefault();
                        alert('Veuillez sélectionner au moins un candidat pour organiser cette commission.');
                        $('#openCandidateModalBtn').focus();
                        return false;
                    }
                });

                // Initialisation au chargement
                updateModalPartnerFilterOptions();
                renderCandidateList();
                updateSelectedUI();
            });
        </script>
    @endpush
@endsection
