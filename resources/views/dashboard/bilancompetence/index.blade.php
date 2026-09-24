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
                        <i class="bx bx-chart text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Bilan de compétences</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('candidatentreprises.synthese_parcours', $candidat->id) }}" class="btn btn-outline-info">
                    <i class="bx bx-folder-open me-1"></i>
                    Voir le dossier / parcours
                </a>
                @if (can('conseiller-fonction-public') ||
                        can('chef-cellule-formation-et-insertion') ||
                        can('conseiller-entreprise-prive'))
                    <a href="{{ route('bilancompetences.create', $candidat->id) }}"
                        class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i>
                        Faire un bilan
                    </a>
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
                            {{ $bilancompetences->count() }}
                        </div>
                        <small class="text-muted d-block">Bilans</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $bilancompetences->where('presence', '1')->count() }}
                        </div>
                        <small class="text-muted d-block">Présences</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des bilans -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Présence</th>
                                <th style="text-align: center">Rapport</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbod                            @foreach ($bilancompetences as $bilancompetence)
                                <tr class="align-middle">
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ dateFr($bilancompetence->date, 'letter') }}</td>
                                    <td>
                                        @if ($bilancompetence->presence == null)
                                            <span class="badge bg-light text-muted border">À venir</span>
                                        @elseif($bilancompetence->presence == '0')
                                            <span class="badge bg-danger"><i class="bx bx-x me-1"></i> Absent</span>
                                        @elseif ($bilancompetence->presence == '1')
                                            <span class="badge bg-success"><i class="bx bx-check me-1"></i> Présent</span>
                                        @elseif ($bilancompetence->presence == '2')
                                            <span class="badge bg-warning text-dark"><i class="bx bx-error-circle me-1"></i> Abandon</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if ($bilancompetence->rapport != null)
                                            <a href="{{ asset($bilancompetence->rapport) }}" download><i
                                                    class="bx bx-cloud-download fs-2 text-primary"></i></a>
                                        @else
                                            <i class="bx bx-cloud-download fs-2" style="color:gray"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            @if ($bilancompetence->comment)
                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#commentModal{{ $bilancompetence->id }}"
                                                    title="Voir commentaire">
                                                    <i class="bx bx-message-square-detail"></i>
                                                </button>
                                            @endif

                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rapportModal{{ $bilancompetence->id }}">
                                                <i class="bx bx-edit me-1"></i> Évaluer / Statut
                                            </button>
                                        </div>

                                        <!-- Modal Commentaire -->
                                        @if ($bilancompetence->comment)
                                            <div id="commentModal{{ $bilancompetence->id }}" class="modal fade"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info text-white">
                                                            <h5 class="modal-title text-white">Commentaire du bilan de compétences</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <label class="form-label fw-semibold text-dark">Commentaire / Observations : </label>
                                                            <textarea class="form-control" rows="5" readonly>{{ $bilancompetence->comment }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Modal Évaluation & Statut (Présent / Absent / Abandon) -->
                                        <div id="rapportModal{{ $bilancompetence->id }}" class="modal fade" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title text-white">Évaluation & Statut du Bilan</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('bilancompetences.presence') }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body p-4">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">Statut du Bilan <span class="text-danger">*</span></label>
                                                                <select name="presence" class="form-select" required>
                                                                    <option value="1" {{ $bilancompetence->presence == '1' ? 'selected' : '' }}>🟢 Présent (Bilan effectué)</option>
                                                                    <option value="0" {{ $bilancompetence->presence === '0' ? 'selected' : '' }}>🔴 Absent</option>
                                                                    <option value="2" {{ $bilancompetence->presence == '2' ? 'selected' : '' }}>🟠 Abandon</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">Rapport (Fichier)</label>
                                                                <input type="file" name="rapport" class="form-control">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-dark">Observations / Synthèse : </label>
                                                                <textarea name="comment" class="form-control" rows="4" placeholder="Conclusions et observations du bilan...">{{ $bilancompetence->comment }}</textarea>
                                                            </div>

                                                            <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                                                            <input type="hidden" name="bilancompetence_id" value="{{ $bilancompetence->id }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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

                $('.validated').on('click', function() {
                    var candidatId = $(this).data('candidat-id');
                    var routevalidated = $('#validatedForm-' + candidatId).attr('action');
                    Swal.fire({
                        title: "Marquer ce candidat présent",
                        text: "Voulez-vous marquer ce candidat présent?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oui, présent!",
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