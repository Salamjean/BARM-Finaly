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
                        <i class="bx bx-users text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Candidats</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-conversation text-success fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Candidats de l'entretien | {{ $entretien->parcours == 'fonction_public' ? 'Fonction publique' : 'Entréprise privée' }}</h5>
                        <small class="text-muted">Gestion des présences et commentaires</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidats->where('presence', '1')->count() }}
                        </div>
                        <small class="text-muted d-block">Présents</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-danger fs-6 px-3 py-2">
                            {{ $candidats->where('presence', '0')->count() }}
                        </div>
                        <small class="text-muted d-block">Absents</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning text-dark fs-6 px-3 py-2">
                            {{ $candidats->where('presence', '2')->count() }}
                        </div>
                        <small class="text-muted d-block">Abandons</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-check-circle text-primary me-1"></i>
                                    Statut / Présence
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidats as $index => $candidat)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->candidature->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $candidat->candidature->user->mecano }}</span>
                                                    <span>{{ $candidat->candidature->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($candidat->presence == 1 || $candidat->presence === '1')
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-success"><i class="bx bx-check me-1"></i> Présent</span>
                                            </div>
                                        @elseif ($candidat->presence == 2 || $candidat->presence === '2')
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-warning text-dark"><i class="bx bx-error-circle me-1"></i> Abandon</span>
                                            </div>
                                        @elseif ($candidat->presence === 0 || $candidat->presence === '0')
                                            <div class="d-flex align-items-center">
                                                <div class="bg-danger rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Absent</span>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-light text-muted border">En attente</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->candidature->id) }}" 
                                               class="btn btn-outline-info btn-sm" 
                                               title="Voir le dossier / synthèse du parcours">
                                                <i class="bx bx-folder-open me-1"></i> Dossier
                                            </a>

                                            <a href="{{ route('adherent.show', $candidat->candidature->user->id) }}" 
                                               class="btn btn-outline-secondary btn-sm" 
                                               title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            
                                            @if ($candidat->comment)
                                                <button type="button" 
                                                        class="btn btn-outline-info btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#commentModal{{ $candidat->id }}"
                                                        title="Voir commentaire">
                                                    <i class="bx bx-message-square-detail"></i>
                                                </button>
                                            @endif

                                            <!-- Bouton Évaluer / Changer statut -->
                                            <button type="button" 
                                                    class="btn btn-outline-success btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rapportModal{{ $candidat->id }}"
                                                    title="Évaluer / Marquer la présence ou l'abandon">
                                                <i class="bx bx-check-double"></i> Évaluer
                                            </button>

                                            <!-- Bouton rapide Abandon -->
                                            @if ($candidat->presence != 2 && $candidat->presence !== '2')
                                                <button type="button" 
                                                        class="btn btn-outline-warning btn-sm abandon-btn" 
                                                        data-candidat-id="{{ $candidat->id }}"
                                                        title="Marquer comme abandon">
                                                    <i class="bx bx-error-circle"></i>
                                                </button>
                                            @endif

                                            <!-- Bouton rapide Absent -->
                                            @if ($candidat->presence !== 0 && $candidat->presence !== '0')
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm refused" 
                                                        data-candidat-id="{{ $candidat->id }}"
                                                        title="Marquer absent">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Modal Commentaire -->
                                        @if ($candidat->comment)
                                            <div id="commentModal{{ $candidat->id }}" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info text-white">
                                                            <h5 class="modal-title text-white">
                                                                <i class="bx bx-message-square-detail me-2"></i>
                                                                Compte rendu de l'entretien
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <i class="bx bx-user me-2 text-primary"></i>
                                                                    <strong>{{ $candidat->candidature->user->fullName() }}</strong>
                                                                </div>
                                                                <label class="form-label fw-medium">
                                                                    <i class="bx bx-comment text-primary me-1"></i>
                                                                    Commentaire / Observations
                                                                </label>
                                                                <textarea class="form-control" readonly rows="5">{{ $candidat->comment }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="bx bx-x me-1"></i>
                                                                Fermer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Modal Évaluation & Statut (Présent / Absent / Abandon) -->
                                        <div id="rapportModal{{ $candidat->id }}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header text-white bg-primary">
                                                        <h5 class="modal-title text-white">
                                                            <i class="bx bx-slider-alt me-2"></i>
                                                            Évaluation & Statut de l'entretien
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('entretiens.presence') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body p-4">
                                                            <div class="d-flex align-items-center mb-3 p-2 bg-light rounded-3">
                                                                <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                                                    {{ strtoupper(substr($candidat->candidature->user->firstname ?? 'C', 0, 1) . substr($candidat->candidature->user->lastname ?? 'A', 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <strong class="text-dark">{{ $candidat->candidature->user->fullName() }}</strong>
                                                                    <div class="small text-muted">Matricule: {{ $candidat->candidature->user->mecano ?? 'N/A' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">
                                                                    Statut de participation <span class="text-danger">*</span>
                                                                </label>
                                                                <select name="presence" class="form-select" required>
                                                                    <option value="1" {{ $candidat->presence == 1 ? 'selected' : '' }}>🟢 Présent (Valider l'entretien)</option>
                                                                    <option value="0" {{ ($candidat->presence === 0 || $candidat->presence === '0') ? 'selected' : '' }}>🔴 Absent</option>
                                                                    <option value="2" {{ $candidat->presence == 2 ? 'selected' : '' }}>🟠 Abandon</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">
                                                                    <i class="bx bx-comment text-primary me-1"></i>
                                                                    Compte-rendu / Observations sur l'entretien
                                                                </label>
                                                                <textarea name="comment" class="form-control" rows="4" 
                                                                          placeholder="Ajoutez vos observations sur l'entretien...">{{ $candidat->comment }}</textarea>
                                                            </div>

                                                            <input type="hidden" name="candidatentretien_id" value="{{ $candidat->id }}">
                                                            <input type="hidden" name="candidat_id" value="{{ $candidat->candidature->id }}">
                                                            <input type="hidden" name="entretien_id" value="{{ $entretien->id }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                <i class="bx bx-x me-1"></i>
                                                                Annuler
                                                            </button>
                                                            <button type="submit" class="btn btn-primary px-4">
                                                                <i class="bx bx-check me-1"></i>
                                                                Enregistrer le statut
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form pour marquer absent rapide -->
                                        <form id="refusedForm-{{ $candidat->id }}" action="{{ route('entretiens.presence') }}" method="post" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="presence" value="0">
                                            <input type="hidden" name="candidatentretien_id" value="{{ $candidat->id }}">
                                            <input type="hidden" name="candidat_id" value="{{ $candidat->candidature->id }}">
                                            <input type="hidden" name="entretien_id" value="{{ $entretien->id }}">
                                        </form>

                                        <!-- Form pour marquer abandon rapide -->
                                        <form id="abandonForm-{{ $candidat->id }}" action="{{ route('entretiens.presence') }}" method="post" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="presence" value="2">
                                            <input type="hidden" name="candidatentretien_id" value="{{ $candidat->id }}">
                                            <input type="hidden" name="candidat_id" value="{{ $candidat->candidature->id }}">
                                            <input type="hidden" name="entretien_id" value="{{ $entretien->id }}">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            (function($) {
                "use strict";
                
                $('.refused').on('click', function() {
                    var candidatId = $(this).data('candidat-id');
                    var routerefused = $('#refusedForm-' + candidatId).attr('action');
                    Swal.fire({
                        title: "Marquer ce candidat absent",
                        text: "Voulez-vous marquer ce candidat absent ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Oui, marquer absent",
                        cancelButtonText: "Annuler"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: routerefused,
                                type: 'POST',
                                data: $('#refusedForm-' + candidatId).serialize(),
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

                $('.abandon-btn').on('click', function() {
                    var candidatId = $(this).data('candidat-id');
                    var routeAbandon = $('#abandonForm-' + candidatId).attr('action');
                    Swal.fire({
                        title: "Marquer ce candidat en Abandon",
                        text: "Voulez-vous déclarer ce candidat en statut abandon pour cet entretien ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#ffc107",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Oui, marquer abandon",
                        cancelButtonText: "Annuler"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: routeAbandon,
                                type: 'POST',
                                data: $('#abandonForm-' + candidatId).serialize(),
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
        </script>
    @endpush
@endsection