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
                        <i class="bx bx-book-open text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Formations</div>
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
                    <i class="bx bx-group text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Participants à la formation</h5>
                        <small class="text-muted">Gestion des présences et attestations</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $formation->candidatures->count() }}
                        </div>
                        <small class="text-muted d-block">Participants</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $formation->candidatures->where('pivot.presence', '1')->count() }}
                        </div>
                        <small class="text-muted d-block">Présents</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $formation->candidatures->whereNotNull('pivot.attestation')->count() }}
                        </div>
                        <small class="text-muted d-block">Attestations</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des participants -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénoms</th>
                                <th>Présence</th>
                                <th class="text-start">Attestation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formation->candidatures as $candidat)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div>{{ $candidat->user->fullName() }}</div>
                                        <div class="fs-7">
                                                                                                <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>

                                            <span>{{ $candidat->phone_number }}</span>
                                        </div>
                                    </td>
                                    @if ($candidat->pivot->presence == '0')
                                        <td class="text-danger">Abscent</td>
                                    @else
                                        <td class="text-success">Présent</td>
                                    @endif
                                    @if ($candidat->pivot->attestation != null)
                                        <td class="text-start"><a href="{{ asset($candidat->pivot->attestation) }}"
                                                download><i class="bx bx-cloud-download fs-2"></i></a></td>
                                    @else
                                        <td class="text-start"><a href="#"><i class="bx bx-cloud-download fs-2"
                                                    style="color:darkgray"></i></a></td>
                                    @endif
                                    <td style="text-align: center">
                                        <a href="{{ route('adherent.show', $candidat->user->id) }}">
                                            <i class='bx bxs-show'></i>
                                        </a>

                                        @if ($candidat->pivot->commentaire != null)
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#commentModal{{ $candidat->id }}"
                                                class="badge bg-warning mb-2">Voir
                                                commentaire</a>
                                            <div id="commentModal{{ $candidat->id }}" class="modal fade" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Compte rendu de l'entretien</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('formations.presence') }}" method="POST"
                                                            class="row g-3" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="form-label">commentaire: </label>
                                                                        <textarea name="commentaire" class="form-control" id="" cols="10" rows="5" readonly>{{ $candidat->pivot->commentaire }}</textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="reset"
                                                                    class="btn btn-label-danger btn-reset"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">Retour</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($candidat->pivot->presence == '0')
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#rapportModal{{ $candidat->id }}"
                                                class="badge bg-success mb-2">Marquer présent</a>

                                            <div id="rapportModal{{ $candidat->id }}" class="modal fade" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Compte rendu de la formation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('formations.presence') }}" method="POST"
                                                            class="row g-3" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Présence : </label>
                                                                        <select class="form-select select2"
                                                                            data-placeholder="Choisir une option"
                                                                            name="presence">
                                                                            <option value="1">Présent</option>
                                                                            <option value="0">Abscent</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Attestation : </label>
                                                                        <input class="form-control" type="file"
                                                                            name="attestation">
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="form-label">commentaire : </label>
                                                                        <textarea name="commentaire" class="form-control" id="" cols="10" rows="5"></textarea>
                                                                    </div>
                                                                    <input type="text" name="candidature_id"
                                                                        value="{{ $candidat->id }}"hidden>
                                                                    <input type="text" name="formation_id"
                                                                        value="{{ $formation->id }}" hidden>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-label-info me-sm-3 me-1">Enregistrer</button>
                                                                <button type="reset"
                                                                    class="btn btn-label-danger btn-reset"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">Retour</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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