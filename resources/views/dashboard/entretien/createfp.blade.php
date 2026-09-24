@extends('layouts.app')

@section('content')
<style>
    .card-entretien {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    .type-selector-card {
        cursor: pointer;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.2s ease;
        background-color: #f8fafc;
        height: 100%;
        margin-bottom: 0;
    }
    .type-selector-card:hover {
        border-color: #94a3b8;
        background-color: #f1f5f9;
    }
    .type-selector-card.active {
        border-color: #2563eb;
        background-color: #eff6ff;
    }
    .type-selector-card input[type="radio"] {
        display: none;
    }

    /* Double panneau : Disponibles & Sélectionnés */
    .dual-box-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
        height: 480px;
    }
    .dual-box-header {
        background-color: #f8fafc;
        border-bottom: 1.5px solid #e2e8f0;
        padding: 12px 16px;
        border-radius: 11px 11px 0 0;
    }
    .dual-box-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
    }
    .candidate-dual-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #f1f5f9;
        margin-bottom: 8px;
        background-color: #ffffff;
        transition: all 0.15s ease;
    }
    .candidate-dual-item:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }
    .candidate-dual-item.selected-item {
        background-color: #eff6ff;
        border-color: #bfdbfe;
    }
    .candidat-avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
        flex-shrink: 0;
        margin-right: 10px;
    }
    .candidat-avatar-circle.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .btn-action-dual {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
</style>

<div class="container-fluid py-3">
    <!-- En-tête simple et aéré -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                <i class="bx bx-calendar-plus fs-3"></i>
            </div>
            <div>
                <h4 class="mb-1 text-dark fw-bold">Organisation d'un Entretien</h4>
                <p class="text-muted mb-0 small">Fonction Publique &bull; Planification et affectation des candidats</p>
            </div>
        </div>
        <div>
            <a href="{{ route('entretiens.index', $type == 'perso' ? 'perso' : 'collectif') }}" class="btn btn-outline-secondary px-3">
                <i class="bx bx-arrow-back me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire principal -->
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <div class="card card-entretien bg-white mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="card-title mb-0 fw-semibold text-dark">
                        <i class="bx bx-slider-alt text-primary me-2"></i>1. Paramètres de l'entretien
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('entretiens.storefp') }}" enctype="multipart/form-data" id="formOrganizeEntretien">
                        @csrf
                        <input type="hidden" name="parcours" value="fonction_public" />
                        <div id="hiddenInputsContainer"></div>

                        <!-- Ligne 1 : Divisée en 3 colonnes égales (Collectif, Individuel, Date) avec même hauteur -->
                        <div class="row g-3 mb-4 align-items-end">
                            <!-- 1. Entretien Collectif -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark mb-2">
                                    <i class="bx bx-check-circle text-primary me-1"></i> Type d'entretien <span class="text-danger">*</span>
                                </label>
                                <label class="type-selector-card d-flex align-items-center {{ $type == 'collectif' ? 'active' : '' }}" id="cardTypeCollectif" style="height: 52px;">
                                    <input type="radio" name="type" value="collectif" {{ $type == 'collectif' ? 'checked' : '' }} onchange="switchType('collectif')">
                                    <div class="bg-primary text-white p-2 rounded-circle me-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="bx bx-group fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">Entretien Collectif</div>
                                        <small class="text-muted" style="font-size: 0.72rem;">Plusieurs candidats</small>
                                    </div>
                                </label>
                            </div>

                            <!-- 2. Entretien Individuel -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark mb-2 opacity-0 d-none d-md-block">
                                    Type d'entretien
                                </label>
                                <label class="type-selector-card d-flex align-items-center {{ $type == 'perso' ? 'active' : '' }}" id="cardTypeIndividuel" style="height: 52px;">
                                    <input type="radio" name="type" value="perso" {{ $type == 'perso' ? 'checked' : '' }} onchange="switchType('perso')">
                                    <div class="bg-info text-white p-2 rounded-circle me-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="bx bx-user fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">Entretien Individuel</div>
                                        <small class="text-muted" style="font-size: 0.72rem;">1 seul candidat</small>
                                    </div>
                                </label>
                            </div>

                            <!-- 3. Date de tenue -->
                            <div class="col-md-4">
                                <label for="date" class="form-label fw-semibold text-dark mb-2">
                                    <i class="bx bx-calendar text-primary me-1"></i> Date de tenue <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" style="height: 52px;">
                                    <span class="input-group-text bg-light text-muted">
                                        <i class="bx bx-calendar-event fs-5"></i>
                                    </span>
                                    <input type="date" 
                                           class="form-control form-control-lg @error('date') is-invalid @enderror" 
                                           id="date" 
                                           name="date" 
                                           value="{{ old('date', date('Y-m-d')) }}" 
                                           min="{{ date('Y-m-d') }}"
                                           style="height: 52px;"
                                           required />
                                </div>
                                @error('date')
                                    <div class="text-danger small mt-1">
                                        <i class="bx bx-error-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>    </div>

                        <hr class="my-4 text-muted opacity-25">

                        <!-- Ligne 2 : Double panneau de sélection des candidats -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-3">
                                <i class="bx bx-user-check text-primary me-1"></i> 2. Sélection des candidats participants <span class="text-danger">*</span>
                            </label>

                            <div class="row g-3">
                                <!-- CARTE GAUCHE : Candidats Disponibles -->
                                <div class="col-lg-6">
                                    <div class="dual-box-card">
                                        <div class="dual-box-header">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-bold text-dark d-flex align-items-center gap-1">
                                                    <i class="bx bx-list-ul text-primary"></i> Candidats disponibles
                                                    <span class="badge bg-secondary rounded-pill ms-1" id="countAvailable">
                                                        {{ count($candidats) }}
                                                    </span>
                                                </span>
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddAll" style="font-size: 0.75rem;">
                                                    <i class="bx bx-plus-circle me-1"></i> Tout ajouter
                                                </button>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white text-muted border-end-0">
                                                    <i class="bx bx-search"></i>
                                                </span>
                                                <input type="text" 
                                                       class="form-control bg-white border-start-0 ps-0" 
                                                       id="searchAvailableInput" 
                                                       placeholder="Filtrer par nom, prénom ou matricule..." />
                                            </div>
                                        </div>

                                        <div class="dual-box-body" id="availableList">
                                            @forelse($candidats as $candidat)
                                                @php
                                                    $initials = strtoupper(substr($candidat->user->firstname ?? 'C', 0, 1) . substr($candidat->user->lastname ?? 'A', 0, 1));
                                                    $fullName = $candidat->user->fullName();
                                                    $mecano = $candidat->user->mecano ?? 'N/A';
                                                    $phone = $candidat->user->phone ?? null;
                                                    $nbEntretiens = $candidat->candidatentretiens ? $candidat->candidatentretiens->count() : 0;
                                                @endphp
                                                <div class="candidate-dual-item" 
                                                     id="cand_item_{{ $candidat->id }}"
                                                     data-id="{{ $candidat->id }}"
                                                     data-name="{{ strtolower($fullName) }}"
                                                     data-mecano="{{ strtolower($mecano) }}"
                                                     data-fullname="{{ $fullName }}"
                                                     data-initials="{{ $initials }}"
                                                     data-phone="{{ $phone }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="candidat-avatar-circle">
                                                            {{ $initials }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark d-flex align-items-center gap-1" style="font-size: 0.9rem;">
                                                                {{ $fullName }}
                                                                @if ($nbEntretiens > 0)
                                                                    <span class="badge bg-light text-primary border rounded-pill" style="font-size: 0.68rem;">
                                                                        {{ $nbEntretiens }} entretien(s)
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="text-muted" style="font-size: 0.78rem;">
                                                                Matricule: {{ $mecano }}
                                                                @if($phone) &bull; {{ $phone }} @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-primary btn-action-dual btn-add-candidate" title="Ajouter">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="text-center py-5 text-muted">
                                                    <i class="bx bx-user-x fs-2 d-block mb-1"></i>
                                                    Aucun candidat disponible
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <!-- CARTE DROITE : Candidats Sélectionnés -->
                                <div class="col-lg-6">
                                    <div class="dual-box-card" style="border-color: #bfdbfe;">
                                        <div class="dual-box-header" style="background-color: #eff6ff;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-primary d-flex align-items-center gap-1">
                                                    <i class="bx bx-user-check text-success fs-5"></i> Candidats retenus
                                                    <span class="badge bg-primary rounded-pill ms-1" id="countSelected">
                                                        0
                                                    </span>
                                                </span>
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="btnRemoveAll" style="font-size: 0.75rem;">
                                                    <i class="bx bx-trash me-1"></i> Tout retirer
                                                </button>
                                            </div>
                                        </div>

                                        <div class="dual-box-body" id="selectedList">
                                            <!-- État vide -->
                                            <div class="text-center py-5 text-muted" id="emptySelectedState">
                                                <i class="bx bx-user-plus text-primary fs-1 d-block mb-2 opacity-50"></i>
                                                <p class="mb-0 fw-medium">Aucun candidat sélectionné</p>
                                                <small class="text-muted">Cliquez sur <strong class="text-primary">+</strong> à gauche pour ajouter des candidats à l'entretien.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @error('candidatures')
                                <div class="text-danger small mt-2">
                                    <i class="bx bx-error-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Boutons d'actions -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('entretiens.index', $type == 'perso' ? 'perso' : 'collectif') }}" class="btn btn-outline-secondary px-4">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">
                                <i class="bx bx-save me-1"></i> Enregistrer l'organisation
                            </button>
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
    var currentMode = '{{ $type == "perso" ? "perso" : "collectif" }}';
    var selectedCandidates = {}; // id -> { id, fullName, mecano, initials, phone }

    function normalizeStr(str) {
        return (str || '')
            .toString()
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .trim();
    }

    function renderHiddenInputs() {
        var container = $('#hiddenInputsContainer');
        container.empty();
        $.each(selectedCandidates, function(id, cand) {
            container.append('<input type="hidden" name="candidatures[]" value="' + id + '">');
        });
    }

    function filterAvailableCandidates() {
        var query = normalizeStr($('#searchAvailableInput').val());
        var visibleAvailable = 0;

        $('#availableList .candidate-dual-item').each(function() {
            var candId = $(this).attr('data-id');
            var isSelected = selectedCandidates.hasOwnProperty(candId);

            if (isSelected) {
                $(this).css('display', 'none');
            } else {
                var name = normalizeStr($(this).attr('data-fullname') || $(this).attr('data-name'));
                var mecano = normalizeStr($(this).attr('data-mecano'));
                var phone = normalizeStr($(this).attr('data-phone'));

                var matches = (query === '') || 
                              (name.indexOf(query) !== -1) || 
                              (mecano.indexOf(query) !== -1) || 
                              (phone.indexOf(query) !== -1);

                if (matches) {
                    $(this).css('display', 'flex');
                    visibleAvailable++;
                } else {
                    $(this).css('display', 'none');
                }
            }
        });

        $('#countAvailable').text(visibleAvailable);
    }

    function updateCounts() {
        var selectedCount = Object.keys(selectedCandidates).length;
        $('#countSelected').text(selectedCount);

        if (selectedCount === 0) {
            $('#emptySelectedState').show();
        } else {
            $('#emptySelectedState').hide();
        }

        renderHiddenInputs();
        filterAvailableCandidates();
    }

    function addCandidate(candId) {
        var itemLeft = $('#cand_item_' + candId);
        if (!itemLeft.length) return;

        var candData = {
            id: candId,
            fullName: itemLeft.attr('data-fullname') || itemLeft.data('fullname'),
            mecano: itemLeft.attr('data-mecano') || itemLeft.data('mecano'),
            initials: itemLeft.attr('data-initials') || itemLeft.data('initials'),
            phone: itemLeft.attr('data-phone') || itemLeft.data('phone')
        };

        if (currentMode === 'perso') {
            // Mode individuel : un seul candidat
            removeAllCandidates();
        }

        selectedCandidates[candId] = candData;

        // Ajout dans la carte de droite
        var itemRightHtml = `
            <div class="candidate-dual-item selected-item" id="cand_selected_${candId}" data-id="${candId}">
                <div class="d-flex align-items-center">
                    <div class="candidat-avatar-circle success">
                        ${candData.initials}
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">${candData.fullName}</div>
                        <div class="text-muted" style="font-size: 0.78rem;">
                            Matricule: ${candData.mecano}
                            ${candData.phone ? '&bull; ' + candData.phone : ''}
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger btn-action-dual btn-remove-candidate" data-id="${candId}" title="Retirer">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        `;
        $('#selectedList').append(itemRightHtml);
        updateCounts();
    }

    function removeCandidate(candId) {
        delete selectedCandidates[candId];
        $('#cand_selected_' + candId).remove();
        updateCounts();
    }

    function removeAllCandidates() {
        selectedCandidates = {};
        $('#selectedList .candidate-dual-item').remove();
        updateCounts();
    }

    function addAllCandidates() {
        if (currentMode === 'perso') return;
        $('#availableList .candidate-dual-item').each(function() {
            var candId = $(this).attr('data-id');
            var isVisible = $(this).css('display') !== 'none';
            if (isVisible && !selectedCandidates.hasOwnProperty(candId)) {
                addCandidate(candId);
            }
        });
    }

    function switchType(type) {
        currentMode = type;
        if (type === 'collectif') {
            $('#cardTypeCollectif').addClass('active');
            $('#cardTypeIndividuel').removeClass('active');
            $('#btnAddAll').show();
        } else {
            $('#cardTypeIndividuel').addClass('active');
            $('#cardTypeCollectif').removeClass('active');
            $('#btnAddAll').hide();

            // Si plusieurs étaient sélectionnés, conserver uniquement le premier
            var keys = Object.keys(selectedCandidates);
            if (keys.length > 1) {
                var firstId = keys[0];
                var firstData = selectedCandidates[firstId];
                removeAllCandidates();
                addCandidate(firstId);
            }
        }
        updateCounts();
    }

    $(document).ready(function() {
        // Clic sur bouton Ajouter (+)
        $(document).on('click', '.btn-add-candidate', function(e) {
            e.stopPropagation();
            var candId = $(this).closest('.candidate-dual-item').attr('data-id');
            addCandidate(candId);
        });

        // Double-clic sur un candidat à gauche pour l'ajouter
        $(document).on('dblclick', '#availableList .candidate-dual-item', function() {
            var candId = $(this).attr('data-id');
            addCandidate(candId);
        });

        // Clic sur bouton Retirer (poubelle)
        $(document).on('click', '.btn-remove-candidate', function(e) {
            e.stopPropagation();
            var candId = $(this).attr('data-id');
            removeCandidate(candId);
        });

        // Double-clic sur un candidat à droite pour le retirer
        $(document).on('dblclick', '#selectedList .candidate-dual-item', function() {
            var candId = $(this).attr('data-id');
            removeCandidate(candId);
        });

        // Tout ajouter
        $('#btnAddAll').on('click', function() {
            addAllCandidates();
        });

        // Tout retirer
        $('#btnRemoveAll').on('click', function() {
            removeAllCandidates();
        });

        // Filtre de recherche en direct à gauche (insensible aux accents et majuscules)
        $('#searchAvailableInput').on('input keyup change', function() {
            filterAvailableCandidates();
        });

        // Initialisation initiale du mode
        switchType(currentMode);
        filterAvailableCandidates();

        // Validation avant envoi
        $('#formOrganizeEntretien').on('submit', function(e) {
            var count = Object.keys(selectedCandidates).length;
            if (count === 0) {
                e.preventDefault();
                alert('Veuillez ajouter au moins un candidat dans la carte de droite (Candidats retenus) pour organiser l\'entretien.');
            }
        });
    });
</script>
@endpush