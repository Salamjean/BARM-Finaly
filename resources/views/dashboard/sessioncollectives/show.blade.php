@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-users text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Sessions collectives d'informations</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-group text-info fs-3 me-3"></i>

                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidatures->where('pivot.presence_status', '1')->count() }}
                        </div>
                        <div class="text-muted small">Présents</div>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-danger fs-6 px-3 py-2">
                            {{ $candidatures->where('pivot.presence_status', '0')->count() }}
                        </div>
                        <div class="text-muted small">Absents</div>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ count($candidatures) }}
                        </div>
                        <div class="text-muted small">Total</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-nonz">


            <div class="p-4">
                @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))
                    <div id="bulkActionsContainer" class="mb-3 p-3 bg-light rounded-3 d-none justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bx bx-check-double text-primary fs-4"></i>
                            <span class="fw-medium text-dark"><span id="selectedCount" class="fw-bold text-primary">0</span> candidat(s) sélectionné(s)</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success btn-sm" id="bulkMarkPresentBtn">
                                <i class="bx bx-user-check me-1"></i> Marquer Présent
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" id="bulkMarkAbsentBtn">
                                <i class="bx bx-user-x me-1"></i> Marquer Absent
                            </button>
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))
                                    <th class="border-0 text-center" style="width: 40px;">
                                        <input type="checkbox" id="selectAllCandidats" class="form-check-input">
                                    </th>
                                @endif
                                <th class="border-0">
                                    <i class="bx bx-calendar-plus text-primary me-1"></i>
                                    Date d'ajout
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>

                                <th class="border-0">
                                    <i class="bx bx-group text-primary me-1"></i>
                                    Partenaire
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-check-circle text-primary me-1"></i>
                                    Présence
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatures as $index => $candidat)
                                <tr class="align-middle">
                                    @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))
                                        <td class="text-center">
                                            @if ($candidat->pivot->presence == '0')
                                                <input type="checkbox" class="form-check-input candidat-checkbox" value="{{ $candidat->id }}">
                                            @else
                                                <input type="checkbox" class="form-check-input" disabled title="Déjà traité">
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                            <div>
                                                <div class="fw-medium">{{ dateFr($candidat->created_at) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                    <span>{{ $candidat->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-medium">{{ $candidat->partenaires->last()->user->username }}
                                                </div>
                                                <small class="text-muted">Partenaire technique</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($candidat->pivot->presence_status == '0')
                                                <div class="bg-danger rounded-circle me-2" style="width: 8px; height: 8px;">
                                                </div>
                                                <span class="badge bg-danger">Absent</span>
                                            @else
                                                <div class="bg-success rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-success">Présent</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))
                                                @if ($candidat->pivot->presence == '0')
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-sm confirm-presence-btn"
                                                        data-candidat-id="{{ $candidat->id }}"
                                                        data-candidat-name="{{ $candidat->user->fullName() }}"
                                                        data-candidat-mecano="{{ $candidat->user->mecano }}"
                                                        data-session-title="{{ $sessioncollective->title ?? 'Session collective' }}"
                                                        title="Débloquer chez le partenaire technique">
                                                        <i class="bx bx-unlock me-1"></i>
                                                        Débloquer
                                                    </button>

                                                    <form id="validatedForm-{{ $candidat->id }}"
                                                        action="{{ route('updatecandidatsession', [$sessioncollective->id, $candidat->id]) }}"
                                                        method="post" style="display: none;">
                                                        @csrf
                                                        <input type="text" name="presence" value="1" hidden>
                                                        <input type="text" name="session_collective" value="1"
                                                            hidden>
                                                        <input type="text" name="session_id"
                                                            value="{{ $sessioncollective->id }}" hidden>
                                                    </form>
                                                @else
                                                    {{-- <button type="button" 
                                                            class="btn btn-outline-danger btn-sm refused"
                                                            data-candidat-id="{{ $candidat->id }}"
                                                            title="Marquer absent">
                                                        <i class="bx bx-x"></i>
                                                    </button>

                                                    <form id="refusedForm-{{ $candidat->id }}"
                                                          action="{{ route('updatecandidatsession', [$sessioncollective->id, $candidat->id]) }}"
                                                          method="post" style="display: none;">
                                                        @csrf
                                                        <input type="text" name="presence" value="0" hidden>
                                                        <input type="text" name="session_collective" value="0" hidden>
                                                        <input type="text" name="session_id" value="{{ $sessioncollective->id }}" hidden>
                                                    </form> --}}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmPresenceModal" tabindex="-1" aria-labelledby="confirmPresenceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-none">
                <div class="modal-header text-white">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-unlock me-2 fs-4"></i>
                        <h5 class="modal-title mb-0" id="confirmPresenceModalLabel">Débloquer chez le partenaire technique
                        </h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="bx bx-user-check text-success fs-1 mb-3"></i>
                        <h6 class="text-muted">Confirmer la présence et débloquer le candidat</h6>
                    </div>

                    <div class="alert alert-warning mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-exclamation-triangle text-warning me-2 fs-4"></i>
                            <div>
                                <strong>Attention !</strong>
                                <div class="small">Cette action est irréversible. Une fois confirmée, la présence ne
                                    pourra plus être modifiée.</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-user-circle text-info me-2 fs-4"></i>
                            <div>
                                <strong id="confirmCandidatName"></strong>
                                <div class="small text-muted">
                                    <span class="badge bg-secondary me-1" id="confirmCandidatMecano"></span>
                                </div>
                                <div class="small text-muted">
                                    <i class="bx bx-calendar me-1"></i>
                                    <span id="confirmSessionTitle"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="presenceStatus" class="form-label">
                            <i class="bx bx-user-check text-success me-1"></i>
                            Statut de présence <span class="text-danger">*</span>
                        </label>
                        <select name="presence_status" id="presenceStatus" class="form-select" required>
                            <option value="" disabled selected>Sélectionner le statut de présence</option>
                            <option value="1">Présent</option>
                            <option value="0">Absent</option>
                        </select>
                        <div class="form-text">
                            <i class="bx bx-info-circle me-1"></i>
                            Indiquez si le candidat a effectivement participé à la session
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x me-1"></i>
                            Annuler
                        </button>
                        <button type="button" class="btn btn-success" id="confirmPresenceBtn">
                            <i class="bx bx-unlock me-1"></i>
                            Débloquer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-push')
    <script>
        (function($) {
            "use strict";

            // Variables globales pour le modal de confirmation
            let currentCandidatId = null;
            let currentRoute = null;
            const confirmPresenceModal = new bootstrap.Modal(document.getElementById('confirmPresenceModal'));

            // Variables pour la sélection en lot
            const selectAllCheckbox = $('#selectAllCandidats');
            const candidateCheckboxes = $('.candidat-checkbox');
            const bulkActionsContainer = $('#bulkActionsContainer');
            const selectedCountSpan = $('#selectedCount');

            // Fonction pour mettre à jour l'affichage des actions en lot
            function updateBulkActions() {
                const checkedCount = $('.candidat-checkbox:checked').length;
                selectedCountSpan.text(checkedCount);

                if (checkedCount > 0) {
                    bulkActionsContainer.removeClass('d-none').addClass('d-flex');
                } else {
                    bulkActionsContainer.removeClass('d-flex').addClass('d-none');
                }

                // Gérer l'état du select all
                const allEnabledChecked = $('.candidat-checkbox:checked').length === candidateCheckboxes.length && candidateCheckboxes.length > 0;
                selectAllCheckbox.prop('checked', allEnabledChecked);
            }

            // Événement Select All
            selectAllCheckbox.on('change', function() {
                const isChecked = $(this).is(':checked');
                candidateCheckboxes.prop('checked', isChecked);
                updateBulkActions();
            });

            // Événement Checkbox Individuelle
            candidateCheckboxes.on('change', function() {
                updateBulkActions();
            });

            // Action Marquer Présent / Absent en lot
            function submitBulkPresence(presenceStatus) {
                const selectedIds = [];
                $('.candidat-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) return;

                const statusText = presenceStatus === 1 ? 'présent(s)' : 'absent(s)';
                const confirmTitle = presenceStatus === 1 ? 'Marquer comme présents ?' : 'Marquer comme absents ?';
                const confirmText = `Voulez-vous marquer les ${selectedIds.length} candidat(s) sélectionné(s) comme ${statusText} et les débloquer chez le partenaire technique ?`;
                const confirmColor = presenceStatus === 1 ? '#198754' : '#dc3545';

                Swal.fire({
                    title: confirmTitle,
                    text: confirmText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: confirmColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Oui, confirmer',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        popup: 'swal-modern'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Mise à jour en lot...',
                            text: 'Traitement en cours',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });

                        $.ajax({
                            url: "{{ route('sessioncollectives.bulk-update-presence', $sessioncollective->id) }}",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                candidature_ids: selectedIds,
                                presence_status: presenceStatus
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Succès !',
                                    text: response.message || `Les candidats ont été marqués ${statusText}.`,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                let errorMsg = 'Une erreur est survenue lors de la mise à jour.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    title: 'Erreur !',
                                    text: errorMsg,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                console.error(error);
                            }
                        });
                    }
                });
            }

            $('#bulkMarkPresentBtn').on('click', function() {
                submitBulkPresence(1);
            });

            $('#bulkMarkAbsentBtn').on('click', function() {
                submitBulkPresence(0);
            });

            // Gestion du bouton de confirmation de présence
            $('.confirm-presence-btn').on('click', function() {
                currentCandidatId = $(this).data('candidat-id');
                const candidatName = $(this).data('candidat-name');
                const candidatMecano = $(this).data('candidat-mecano');
                const sessionTitle = $(this).data('session-title');
                currentRoute = $('#validatedForm-' + currentCandidatId).attr('action');

                // Remplir les informations dans le modal
                $('#confirmCandidatName').text(candidatName);
                $('#confirmCandidatMecano').text(candidatMecano);
                $('#confirmSessionTitle').text(sessionTitle);

                // Réinitialiser le select
                $('#presenceStatus').val('');

                // Afficher le modal
                confirmPresenceModal.show();
            });

            // Gestion de la confirmation dans le modal
            $('#confirmPresenceBtn').on('click', function() {
                const btn = $(this);
                const originalText = btn.html();
                const presenceStatus = $('#presenceStatus').val();

                // Vérifier que le statut de présence est sélectionné
                if (!presenceStatus) {
                    Swal.fire({
                        title: 'Sélection requise !',
                        text: 'Veuillez sélectionner le statut de présence.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Désactiver le bouton et montrer le chargement
                btn.prop('disabled', true);
                btn.html('<i class="bx bx-loader-alt bx-spin me-1"></i> Déblocage...');

                // Fermer le modal
                confirmPresenceModal.hide();

                // Animation de chargement avec SweetAlert
                Swal.fire({
                    title: 'Déblocage...',
                    text: 'Traitement en cours',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                // Préparer les données avec le statut de présence
                const formData = $('#validatedForm-' + currentCandidatId).serialize();
                const dataWithPresence = formData + '&presence_status=' + presenceStatus;

                // Envoyer la requête AJAX
                $.ajax({
                    url: currentRoute,
                    type: 'POST',
                    data: dataWithPresence,
                    success: function(response) {
                        const statusText = presenceStatus === '1' ? 'présent' : 'absent';
                        Swal.fire({
                            title: 'Débloqué avec succès !',
                            text: `Le candidat a été marqué ${statusText} et débloqué chez le partenaire technique.`,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Réactiver le bouton en cas d'erreur
                        btn.prop('disabled', false);
                        btn.html(originalText);

                        Swal.fire({
                            title: 'Erreur !',
                            text: 'Une erreur est survenue lors du déblocage.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(error);
                    }
                });
            });

            // Gestion du bouton absent (inchangé)
            $('.refused').on('click', function() {
                var candidatId = $(this).data('candidat-id');
                var routerefused = $('#refusedForm-' + candidatId).attr('action');

                Swal.fire({
                    title: "Marquer ce candidat absent",
                    text: "Voulez-vous marquer ce candidat absent?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Oui, absent!",
                    cancelButtonText: "Non, retour",
                    customClass: {
                        popup: 'swal-modern'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Animation de chargement
                        Swal.fire({
                            title: 'Mise à jour...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });

                        $.ajax({
                            url: routerefused,
                            type: 'POST',
                            data: $('#refusedForm-' + candidatId).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: 'Succès!',
                                    text: 'Le candidat a été marqué absent.',
                                    icon: 'success',
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Erreur!',
                                    text: 'Une erreur est survenue lors de la mise à jour.',
                                    icon: 'error'
                                });
                                console.error(error);
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
