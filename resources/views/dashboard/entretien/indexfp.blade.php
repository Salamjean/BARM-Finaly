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
                    <i class="bx bx-conversation text-primary fs-4 me-3"></i>
                    <div>
                        <div class="text-muted small">Entretiens</div>
                        <h4 class="mb-0 text-primary">{{ $title }}</h4>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header avec bouton d'action -->
    <div class="bg-white p-4 rounded-3 shadow-none mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="bx bx-calendar-event text-success fs-3 me-3"></i>
                <div>
                    <h5 class="mb-0 text-dark">Gestion des entretiens</h5>
                    <small class="text-muted">
                        @if ($type == 'collectif')
                        Sessions d'entretiens collectifs
                        @else
                        Entretiens personnalisés
                        @endif
                    </small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-center">
                    <div class="badge bg-info fs-6 px-3 py-2">
                        @if ($type == 'collectif')
                        {{ $entretiens->count() }}
                        @else
                        {{ $entretiens->sum(function($e) { return $e->candidatentretiens->count(); }) }}
                        @endif
                    </div>
                    <small class="text-muted d-block">
                        @if ($type == 'collectif')
                        Sessions
                        @else
                        Candidats
                        @endif
                    </small>
                </div>
                @if(can('conseiller-fonction-public') || can('chef-cellule-formation-et-insertion'))
                <a href="{{ route('entretiens.createfp', $type) }}" class="btn btn-primary d-flex align-items-center">
                    <i class="bx bx-plus me-2"></i>
                    Organiser un entretien
                </a>
                @endif
            </div>
        </div>
    </div>

    @if ($type == 'collectif')
    <!-- Vue Entretiens Collectifs -->
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
                                <i class="bx bx-calendar text-primary me-1"></i>
                                Date
                            </th>
                            <th class="border-0">
                                Nbre de candidats
                            </th>
                            <th class="border-0 text-center">
                                <i class="bx bx-cog text-primary me-1"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entretiens as $index => $entretien)
                        <tr class="align-middle">
                            <td>
                                <div class="d-flex justify-content-end align-items-center">
                                    <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="border-start border-success border-3 ps-2 py-1">
                                    <div class="fw-bold text-success">{{ dateFr($entretien->date, 'letter') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="">
                                    <span class="badge bg-info me-2">{{ $entretien->candidatentretiens->count() }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('entretiens.candidats', $entretien->id) }}"
                                        class="btn btn-outline-primary btn-sm"
                                        title="Voir les candidats">
                                        <i class="bx bx-show me-1"></i>
                                        Voir candidats
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @elseif ($type == 'perso')
    <!-- Vue Entretiens Personnalisés -->
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
                                <i class="bx bx-calendar text-primary me-1"></i>
                                Date de l'entretien
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
                        @php $globalIndex = 0; @endphp
                        @foreach ($entretiens as $entretien)
                        @foreach ($entretien->candidatentretiens as $candidat)
                        @php $globalIndex++; @endphp
                        <tr class="align-middle">
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info me-2">{{ $globalIndex }}</span>
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
                                <div class="border-start border-warning border-3 ps-2 py-1">
                                    <div class="fw-medium text-warning">{{ dateFr($entretien->date, 'letter') }}</div>
                                </div>
                            </td>
                            <td>
                                @if ($candidat->presence == '0')
                                <div class="d-flex align-items-center">
                                    <div class="bg-danger rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                    <span class="badge bg-danger">Absent</span>
                                </div>
                                @else
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                    <span class="badge bg-success">Présent</span>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    <a href="{{ route('adherent.show', $candidat->candidature->user->id) }}"
                                        class="btn btn-outline-primary btn-sm"
                                        title="Voir le profil">
                                        <i class="bx bx-show"></i>
                                    </a>

                                    <button type="button"
                                        class="btn btn-outline-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#commentModal{{ $candidat->id }}"
                                        title="Voir commentaire">
                                        <i class="bx bx-message-square-detail"></i>
                                    </button>

                                    @if ($candidat->presence == '0')
                                    <button type="button"
                                        class="btn btn-outline-success btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rapportModal{{ $candidat->id }}"
                                        title="Marquer présent">
                                        <i class="bx bx-check"></i>
                                    </button>
                                    @else
                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm refused"
                                        data-candidat-id="{{ $candidat->id }}"
                                        title="Marquer absent">
                                        <i class="bx bx-x"></i>
                                    </button>
                                    @endif
                                </div>

                                <!-- Modal Commentaire -->
                                <div id="commentModal{{ $candidat->id }}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-white">
                                                <h5 class="modal-title">
                                                    <i class="bx bx-message-square-detail me-2"></i>
                                                    Compte rendu de l'entretien
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium">
                                                        <i class="bx bx-comment text-primary me-1"></i>
                                                        Commentaire
                                                    </label>
                                                    <textarea class="form-control" readonly rows="5">{{ $candidat->comment ?: 'Aucun commentaire disponible' }}</textarea>
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

                                <!-- Modal Marquer Présent -->
                                @if ($candidat->presence == '0')
                                <div id="rapportModal{{ $candidat->id }}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-white">
                                                <h5 class="modal-title">
                                                    <i class="bx bx-check-circle me-2"></i>
                                                    Marquer présent
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('entretiens.presence') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium">
                                                            <i class="bx bx-comment text-primary me-1"></i>
                                                            Commentaire sur l'entretien
                                                        </label>
                                                        <textarea name="comment" class="form-control" rows="5"
                                                            placeholder="Ajoutez vos observations sur l'entretien..."></textarea>
                                                    </div>
                                                    <input type="hidden" name="presence" value="1">
                                                    <input type="hidden" name="candidatentretien_id" value="{{ $candidat->id }}">
                                                    <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                                                    <input type="hidden" name="entretien_id" value="{{ $entretien->id }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="bx bx-x me-1"></i>
                                                        Annuler
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="bx bx-save me-1"></i>
                                                        Enregistrer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Form pour marquer absent -->
                                <form id="refusedForm-{{ $candidat->id }}" action="{{ route('entretiens.presence') }}" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="presence" value="0">
                                    <input type="hidden" name="candidatentretien_id" value="{{ $candidat->id }}">
                                    <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                                    <input type="hidden" name="entretien_id" value="{{ $entretien->id }}">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
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
                text: "Voulez-vous marquer ce candidat absent?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, absent!",
                cancelButtonText: "Non, retour"
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
    })(jQuery);
</script>
@endpush
@endsection