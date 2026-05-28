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
                        <i class="bx bx-user-plus text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Inscriptions</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto">
                @if (can('conseiller-fonction-public') || can('chef-cellule-formation-et-insertion'))
                    <div class="btn-group">
                        <a href="{{ route('inscriptionconcours.create', $candidat->id) }}" type="button"
                            class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>
                            Enregistrer une inscription
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">{{ $candidat->user->fullName() }}</h5>
                        <small class="text-muted">
                            <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                            <span>{{ $candidat->phone_number }}</span>
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $inscriptionconcours->count() }}
                        </div>
                        <small class="text-muted d-block">Inscriptions</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $inscriptionconcours->where('status', '1')->count() }}
                        </div>
                        <small class="text-muted d-block">Admis</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $inscriptionconcours->whereNull('status')->count() }}
                        </div>
                        <small class="text-muted d-block">En attente</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des inscriptions -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Date d'inscription</th>
                                <th>
                                            <i class="bx bx-trophy text-warning me-2"></i>
                                    Intitulé concours</th>
                                <th>Type concours</th>
                                <th>Date de concours</th>
                                <th>Reçu de paiement</th>
                                <th>Résultat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inscriptionconcours as $inscriptionconcour)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-calendar text-primary me-2"></i>
                                            <span>{{ dateFr($inscriptionconcour->created_at) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">{{ $inscriptionconcour->intitule_concours }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $inscriptionconcour->type_concours }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ dateFr($inscriptionconcour->date) }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($inscriptionconcour->recu == null)
                                            <span class="text-muted">
                                                <i class="bx bx-file-blank fs-4"></i>
                                                <small class="d-block">Non disponible</small>
                                            </span>
                                        @else
                                            <a href="{{ asset($inscriptionconcour->recu) }}" download 
                                               class="text-success" title="Télécharger le reçu">
                                                <i class="bx bx-cloud-download fs-3"></i>
                                                <small class="d-block">Télécharger</small>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (can('conseiller-fonction-public') || can('chef-cellule-formation-et-insertion'))
                                            @if ($inscriptionconcour->status === null)
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-success btn-sm" 
                                                            data-bs-toggle="modal" data-bs-target="#rapportModal{{ $inscriptionconcour->id }}"
                                                            title="Marquer comme admis">
                                                        <i class="bx bx-check me-1"></i>
                                                        Admis
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm refused" 
                                                            data-candidat-id="{{ $inscriptionconcour->id }}"
                                                            title="Marquer comme refusé">
                                                        <i class="bx bx-x me-1"></i>
                                                        Refuser
                                                    </button>
                                                </div>

                                                <!-- Modal d'admission -->
                                                <div id="rapportModal{{ $inscriptionconcour->id }}" class="modal fade" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    <i class="bx bx-trophy text-success me-2"></i>
                                                                    Admission au concours
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('inscriptionconcours.decision') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12 mb-3">
                                                                            <div class="alert alert-success">
                                                                                <strong>Candidat :</strong> {{ $candidat->user->fullName() }}<br>
                                                                                <strong>Concours :</strong> {{ $inscriptionconcour->intitule_concours }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label class="form-label">Attestation d'admission :</label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-text"><i class="bx bx-file"></i></span>
                                                                                <input type="file" name="attestation" class="form-control" 
                                                                                       accept=".pdf,.doc,.docx,.jpg,.png" />
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="status" value="1">
                                                                        <input type="hidden" name="inscriptionconcour_id" value="{{ $inscriptionconcour->id }}">
                                                                        <input type="hidden" name="candidature_id" value="{{ $inscriptionconcour->candidature->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-success me-2">
                                                                        <i class="bx bx-check me-1"></i>
                                                                        Confirmer l'admission
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                        <i class="bx bx-x me-1"></i>
                                                                        Annuler
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Formulaire de refus caché -->
                                                <form id="refusedForm-{{ $inscriptionconcour->id }}" action="{{ route('inscriptionconcours.decision') }}" method="post" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="0">
                                                    <input type="hidden" name="inscriptionconcour_id" value="{{ $inscriptionconcour->id }}">
                                                    <input type="hidden" name="candidature_id" value="{{ $inscriptionconcour->candidature->id }}">
                                                </form>
                                            @else
                                                @if($inscriptionconcour->status == 1)
                                                    <span class="badge bg-success fs-6">
                                                        <i class="bx bx-check me-1"></i>
                                                        Admis
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger fs-6">
                                                        <i class="bx bx-x me-1"></i>
                                                        Non admis
                                                    </span>
                                                @endif
                                            @endif
                                        @else
                                            @if($inscriptionconcour->status === null)
                                                <span class="badge bg-warning">En attente</span>
                                            @elseif($inscriptionconcour->status == 1)
                                                <span class="badge bg-success">Admis</span>
                                            @else
                                                <span class="badge bg-danger">Non admis</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($inscriptionconcours->isEmpty())
                <div class="text-center py-5">
                    <i class="bx bx-clipboard fs-1 text-muted"></i>
                    <h5 class="text-muted mt-3">Aucune inscription</h5>
                    <p class="text-muted">Ce candidat n'a pas encore d'inscription aux concours.</p>
                </div>
                @endif
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
                        title: "Refuser cette candidature",
                        text: "Voulez-vous refuser cette candidature?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oui, refuser!",
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

                $('.validated').on('click', function() {
                    var candidatId = $(this).data('candidat-id');
                    var routevalidated = $('#validatedForm-' + candidatId).attr('action');
                    Swal.fire({
                        title: "Accepter cette candidature",
                        text: "Voulez-vous accepter cette candidature?",
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
        </script>
    @endpush
@endsection