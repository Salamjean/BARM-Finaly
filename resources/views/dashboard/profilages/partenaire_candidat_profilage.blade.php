@extends('layouts.app')

@section('content')
    <div class="container pt-2">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Profilages/</span> {{ $title }}
        </h4>
        <div class="card">
            <div class="card-body mt-4">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th class="px-5">Cohorte</th>
                                <th class="w-100">Nom & Prénoms</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($candidatures as $candidat)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="pe-5 fw-bold">{{ $candidat->cohort->title }}</div>
                                        <div class="pe-5">Session du {{ dateFr($candidat->sessionCollective->date) }}</div>
                                        <div>Lieu: <span class="text-success">{{ $candidat->sessionCollective->lieu }}</span></div>
                                    </td>
                                    <td>
                                        <div>{{ $candidat->user->fullName() }}</div>
                                        <div class="fs-7">
                                            <span class="text-primary">{{ $candidat->user->mecano }}</span>,
                                            <span>{{ $candidat->phone_number }}</span>
                                        </div>
                                    </td>


                                    <td>
                                        <a href="{{ route('adherent.show', $candidat->user->id) }}" class=" me-2"
                                            title="Voir les détails">
                                            <i class='bx bxs-show'></i>
                                        </a>

                                        @if ($candidat->partenaires->contains($partenaire->id))
                                            @php
                                                $pivotData = \App\Models\CandidaturePartenaire::where('candidature_id', $candidat->id)
                                                    ->where('partenaire_id', $partenaire->id)
                                                    ->orderBy('id', 'desc')
                                                    ->first();
                                                $status = $pivotData->status;
                                            @endphp
                                            {{-- {{ dd($pivotData->pivot->orderByDesc('id')) }} --}}
                                            @if ($status == null)
                                                <div class="d-inline-flex gap-2">
                                                    <a href="{{ route('adherent.choice.final', $candidat->id) }}"
                                                        class="btn btn-sm btn-success" title="Accepter le candidat">
                                                        <i class='bx bx-check'></i> Accepter
                                                    </a>

                                                    <button type="button" class="btn btn-sm btn-danger refused"
                                                        data-candidat-id="{{ $candidat->id }}" title="Refuser le candidat">
                                                        <i class='bx bx-x'></i> Refuser
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-warning mark-absent-btn"
                                                        data-candidature-id="{{ $candidat->id }}"
                                                        data-candidate-name="{{ $candidat->user->fullName() }}"
                                                        title="Marquer comme absent">
                                                        <i class="bx bx-user-x"></i> Absent
                                                    </button>
                                                </div>

                                                <form id="refusedForm-{{ $candidat->id }}"
                                                    action="{{ route('updatestatuspartnercandidat', $candidat->id) }}"
                                                    method="post" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="refused">
                                                    <input type="hidden" name="motif_refus" id="motifRefus-{{ $candidat->id }}">
                                                </form>
                                            @elseif ($status == 'accepted')
                                                <span class="badge bg-success">
                                                    <i class='bx bx-check-circle'></i> Accepté
                                                </span>
                                            @elseif ($status == 'refused')

                                                <span class="badge bg-danger">
                                                    <i class='bx bx-x-circle'></i> Refusé
                                                </span>
                                            @endif
                                        @endif
                                    </td>


                                </tr>
                            @endforeach

                        </tbody>
                    </table>
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
            $('.refused').on('click', function() {
                var candidatId = $(this).data('candidat-id');
                var routerefused = $('#refusedForm-' + candidatId).attr('action');
                console.log(routerefused);

                Swal.fire({
                    title: "Motif de refus",
                    text: "Veuillez indiquer le motif du refus :",
                    input: "textarea",
                    inputPlaceholder: "Saisissez le motif du refus...",
                    inputAttributes: {
                        "aria-label": "Saisissez le motif du refus",
                        "rows": 4
                    },
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Suivant",
                    cancelButtonText: "Annuler",
                    inputValidator: (value) => {
                        if (!value) {
                            return "Vous devez saisir un motif de refus !";
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var motifRefus = result.value;

                        Swal.fire({
                            title: "Confirmer le refus",
                            html: "Voulez-vous vraiment refuser ce candidat ?<br><br><strong>Motif :</strong><br>" + motifRefus,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#6c757d",
                            confirmButtonText: "Oui, refuser!",
                            cancelButtonText: "Annuler"
                        }).then((confirmResult) => {
                            if (confirmResult.isConfirmed) {
                                $('#motifRefus-' + candidatId).val(motifRefus);

                                $.ajax({
                                    url: routerefused,
                                    type: 'POST',
                                    data: $('#refusedForm-' + candidatId).serialize(),
                                    success: function(response) {
                                        Swal.fire({
                                            title: "Refusé!",
                                            text: "Le candidat a été refusé.",
                                            icon: "success"
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire({
                                            title: "Erreur!",
                                            text: "Une erreur est survenue lors du refus.",
                                            icon: "error"
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });

        })(jQuery);
    </script>

    <script>
        (function($) {
            "use strict";
            $('.validated').on('click', function() {
                var candidatId = $(this).data('candidat-id');
                var routevalidated = $('#validatedForm-' + candidatId).attr('action');
                console.log(routevalidated);
                Swal.fire({
                    title: "Accepter cet candidat ",
                    text: "Voulez-vous accepter cet candidat ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, accepter!",
                    cancelButtonText: "Non, retour"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: routevalidated,
                            type: 'POST',
                            data: $('#validatedForm-' + candidatId).serialize(),
                            success: function(response) {
                                window.location.reload();
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                });
            });
        })(jQuery);

        // Gestion du bouton Absent
        $(document).ready(function() {
            // Gérer l'ouverture du modal pour marquer absent
            $('.mark-absent-btn').on('click', function() {
                const candidatureId = $(this).data('candidature-id');
                const candidateName = $(this).data('candidate-name');
                
                $('#candidatureId').val(candidatureId);
                $('#candidateName').text(candidateName);
                $('#absentJustification').val('');
                
                $('#markAbsentModal').modal('show');
            });

            // Gérer la soumission du formulaire d'absence
            $('#markAbsentForm').on('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                
                // Désactiver le bouton et afficher le loading
                submitBtn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Traitement...');
                
                $.ajax({
                    url: '{{ route("profilage.mark_candidate_absent") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#markAbsentModal').modal('hide');
                            
                            // Afficher un message de succès
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                            
                            // Recharger la page après 2 secondes
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Une erreur est survenue lors du traitement.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        // Afficher un message d'erreur
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: errorMessage
                        });
                    },
                    complete: function() {
                        // Réactiver le bouton
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });
        });
    </script>

    <!-- Modal pour marquer comme absent -->
    <div class="modal fade" id="markAbsentModal" tabindex="-1" aria-labelledby="markAbsentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-none">
                <div class="modal-header bg-warning text-white">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user-x me-2 fs-4"></i>
                        <h5 class="modal-title mb-0" id="markAbsentModalLabel">Marquer comme absent</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="bx bx-exclamation-triangle text-warning fs-1 mb-3"></i>
                        <h6 class="text-muted">Confirmer l'absence du candidat</h6>
                        <p class="text-muted mb-0">Candidat : <span id="candidateName" class="fw-bold text-dark"></span></p>
                    </div>

                    <form id="markAbsentForm">
                        @csrf
                        <input type="hidden" id="candidatureId" name="candidature_id">
                        
                        <div class="mb-3">
                            <label for="absentJustification" class="form-label">
                                <i class="bx bx-message-detail text-warning me-1"></i>
                                Motif d'absence (optionnel)
                            </label>
                            <textarea class="form-control" id="absentJustification" name="absent_justification" 
                                rows="3" placeholder="Précisez le motif d'absence si nécessaire..."></textarea>
                            <div class="form-text">
                                <i class="bx bx-info-circle me-1"></i>
                                Ce champ est optionnel mais recommandé pour le suivi.
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x me-1"></i>
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="bx bx-check me-1"></i>
                                Confirmer l'absence
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
