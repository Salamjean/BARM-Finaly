@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Demande de consommable/</span> Liste des demandes
                </h4>
            </nav>
        </div>

        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('entreestock.create') }}" type="button" class="btn btn-primary">Enregistrer une entrée</a>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">

                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Consommable</th>
                            <th>Quantité</th>
                            <th>Date d'entrée</th>
                            <th>Fournisseur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entreestocks as $entreestock)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $entreestock->consommable->designation }}</td>
                            <td>{{ $entreestock->qte_entree }}</td>
                            <td>{{ dateFr($entreestock->date_entree) }}</td>
                            <td>{{ $entreestock->fournisseur }}</td>
                            <td style="text-align: center">
                                <a href="{{ route('entreestock.show', $entreestock->id) }}"
                                    class="badge bg-primary text-white">Voir</a>
                                <a href="{{ route('entreestock.edit', $entreestock->id) }}"
                                    class="badge bg-primary text-white">Modifier</a>

                                {{-- <form id="deleteForm" action="{{ route('entreestock.destroy', $entreestock->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a type="button" class="badge bg-danger text-white mt-2 delete_besoin"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Supprimer">Supprimer</a>
                                </form> --}}

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    (function ($) {
            "use strict";
            $('.delete_besoin').on('click', function () {
                var route = $(this).closest('form').attr('action');
                Swal.fire({
                    title: "Supprimer la demande ",
                    text: "Voulez-vous supprimer cette demande ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, supprimez-le!",
                    cancelButtonText: "Non, ne pas supprimer"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envoyer le formulaire via AJAX
                        $.ajax({
                            url: route,
                            type: 'POST',
                            data: $('#deleteForm').serialize(),
                            success: function (response) {
                                window.location.href = "{{ route('besoins.index') }}";
                            },
                            error: function (xhr, status, error) {
                                // Gérer les erreurs ici
                            }
                        });
                    }
                });
            });
        })(jQuery);
</script>

@endsection