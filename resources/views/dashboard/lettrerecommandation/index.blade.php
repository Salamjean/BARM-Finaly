@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Lettres de recommandation/</span> {{ $title }}
                    </h4>
                </nav>
            </div>


            <div class="ms-auto">
                @if (can('conseiller-entreprise-prive') ||
                        can('conseiller-fonction-publique') ||
                        can('chef-cellule-formation-et-insertion'))
                    <div class="btn-group">
                        <a href="{{ route('lettresrecommandations.create') }}" type="button" class="btn btn-primary">Faire
                            une demande</a>
                    </div>
                @endif
            </div>



        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start">#</th>
                                <th>Mecano / Matricule</th>
                                <th>Nom & Prénoms</th>
                                <th class="text-start">Numéro de téléphone</th>
                                <th>Date de la demande</th>
                                <th>Status</th>
                                <th>Lettre de recommandation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lettres as $lettre)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $lettre->candidature->user->mecano }}</td>
                                    <td>{{ $lettre->candidature->user->fullName() }}</td>
                                    <td class="text-start">{{ $lettre->candidature->phone_number }}</td>
                                    <td class="text-start">{{ dateFr($lettre->date_demande, 'letter') }}</td>
                                    @if ($lettre->status == '0')
                                        <td class="text-danger">Réfuser</td>
                                    @elseif ($lettre->status == '1')
                                        <td class="text-success">Accorder</td>
                                    @elseif ($lettre->status == null)
                                        <td class="text-warning">En cours de traitement</td>
                                    @endif
                                    @if ($lettre->lettre != null)
                                        <td><a href="{{ asset($lettre->lettre) }}" download><i
                                                    class="bx bx-cloud-download fs-2"></i></a></td>
                                    @else
                                        <td><a href="#"><i class="bx bx-cloud-download fs-2"
                                                    style="color:darkgray"></i></a></td>
                                    @endif
                                    <td style="text-align: center">
                                        <a href="{{ route('adherent.show', $lettre->candidature->user->id) }}">
                                            <i class='bx bxs-show'></i>
                                        </a>

                                        @if (!in_array($lettre->status, ['0', '1']))
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#rapportModal{{ $lettre->id }}"
                                                class="badge bg-success mb-2">Accepter</a>

                                            <div id="rapportModal{{ $lettre->id }}" class="modal fade" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Avis favorable</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('lettresrecommandations.status') }}"
                                                            method="POST" class="row g-3" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="form-label">Lettre de
                                                                            recommandation</label>
                                                                        <input type="file" name="lettre"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="form-label">commentaire : </label>
                                                                        <textarea name="commentaire" class="form-control" id="" cols="10" rows="5"></textarea>
                                                                    </div>
                                                                    <input type="text" name="status" value="1"
                                                                        hidden>
                                                                    <input type="text" name="candidature_id"
                                                                        value="{{ $lettre->candidature->id }}" hidden>
                                                                    <input type="text" name="lettre_id"
                                                                        value="{{ $lettre->id }}" hidden>
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

                                            <a style="cursor: pointer" class="refused"
                                                data-candidat-id="{{ $lettre->id }}">
                                                <span class="badge bg-danger mb-2">Refuser</span>
                                            </a>

                                            <form id="refusedForm-{{ $lettre->id }}"
                                                action="{{ route('lettresrecommandations.status') }}" method="post">
                                                @csrf
                                                <input type="text" name="status" value="0" hidden>
                                                <input type="text" name="candidature_id"
                                                    value="{{ $lettre->candidature->id }}" hidden>
                                                <input type="text" name="lettre_id" value="{{ $lettre->id }}" hidden>
                                            </form>
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
@endsection

@push('js-push')
    <script>
        (function($) {
            "use strict";
            $('.refused').on('click', function() {
                var candidatId = $(this).data('candidat-id');
                var routerefused = $('#refusedForm-' + candidatId).attr('action');
                Swal.fire({
                    title: "Lettre de recommandation refusée",
                    text: "Voulez-vous refuser la demande?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, réfuser!",
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
