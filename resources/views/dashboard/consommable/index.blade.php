@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Gestion de stock/</span> Liste des consommables
                </h4>
            </nav>
        </div>

        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('consommables.create') }}" type="button" class="btn btn-primary">Enregistrer un consommable</a>
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
                            <th>Designation</th>
                            <th>Quantité disponible</th>
                            <th>Visible</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consommables as $consommable)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $consommable->designation }}</td>
                            <td>{{ $consommable->qte_disponible }}</td>
                            <td>
                                @if ($consommable->is_visible == 1)
                                <span class="badge bg-label-success me-1"><i class='bx bx-check-circle'></i>Visible</span>
                                @elseif($consommable->is_visible == 0)
                                <span class="badge bg-label-danger me-1"><i class="fa-regular fa-circle-xmark"></i>Invisible</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <a href="{{ route('consommables.show', $consommable->id) }}" class="badge bg-primary text-white">Voir</a>
                                <a href="{{ route('consommables.edit', $consommable->id) }}" class="badge bg-primary text-white">Modifier</a>

                                <form id="deleteForm" action="{{ route('consommables.destroy', $consommable->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a type="button" class="badge bg-danger text-white mt-2 delete_besoin" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer">Supprimer</a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    (function($) {
        "use strict";
        $('.delete_besoin').on('click', function() {
            var route = $(this).closest('form').attr('action');
            Swal.fire({
                title: "Supprimer le consommable ",
                text: "Voulez-vous supprimer ce consommable ?",
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
                        success: function(response) {
                            window.location.href = "{{ route('consommables.index') }}";
                        },
                        error: function(xhr, status, error) {
                            // Gérer les erreurs ici
                        }
                    });
                }
            });
        });
    })(jQuery);
</script>

@endsection
