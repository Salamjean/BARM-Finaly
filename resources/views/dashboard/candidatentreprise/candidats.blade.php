@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Candidatures spontanées/</span> {{ $title }}
                </h4>
            </nav>
        </div>

        <!-- <div class="ms-auto">

            @if(can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
            <div class="btn-group">
                <a href="{{ route('candidatentreprises.mise_a_disposition') }}" type="button" class="btn btn-primary">Mise à disposition</a>
            </div>
            @endif

        </div> -->

    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Mecano / Matricule</th>
                            <th>Nom & Prénoms</th>
                            <th class="text-start">Numéro de téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidats as $candidat)

                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{ $candidat->user->mecano }}</td>
                            <td>{{ $candidat->user->fullName() }}</td>
                            <td class="text-start">{{ $candidat->phone_number }}</td>
                            <td style="text-align: center">
                                <a href="{{ route('adherent.show', $candidat->user->id) }}">
                                    <i class='bx bxs-show'></i>
                                </a>

                                <a class="badge bg-primary text-white" href="{{ route('candidatentreprises.show_candidatentreprise', $candidat->id) }}">
                                    Voir
                                </a>
                                @if ($candidat->en_poste != '1')
                                <a class="badge bg-warning text-white" href="{{ route('candidatentreprises.create_candidatentreprise', $candidat->id) }}">
                                    Dépot dossier
                                </a>
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
