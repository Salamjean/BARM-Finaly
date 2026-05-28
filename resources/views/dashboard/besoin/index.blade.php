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
                <a href="{{ route('besoins.create') }}" type="button" class="btn btn-primary">Faire une demande</a>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">

                @if(!can('responsable-gestionnaire-des-ressources-humaines|chef-barm'))
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Date de la demande</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($besoins as $besoin)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $besoin->libelle }}</td>
                            <td>{{ dateFr($besoin->created_at) }}</td>
                            <td>
                                @if ($besoin->status == 'pending')
                                <span class="badge bg-warning text-white rounded-lg">En Attente</span>
                                @elseif($besoin->status == 'validated')
                                <span class="badge bg-success text-white rounded-lg">Validé</span>
                                @elseif($besoin->status == 'refused')
                                <span class="badge bg-danger text-white rounded-lg">Refusé</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <a href="{{ route('besoins.show', $besoin->id) }}"
                                    class="badge bg-primary text-white">Voir la demande</a>

                                @if ($besoin->status == 'pending')
                                <a href="{{ route('besoins.edit', $besoin->id) }}"
                                    class="badge bg-warning text-white">Modifier</a>

                                <form id="deleteForm" action="{{ route('besoins.destroy', $besoin->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a type="button" class="badge bg-danger text-white mt-2 delete_besoin"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Supprimer">Supprimer</a>
                                </form>

                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                @if(can('responsable-gestionnaire-des-ressources-humaines|chef-barm'))
                    <table class="dt-responsive table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Collaborateur</th>
                                <th>Titre</th>
                                <th>Date de la demande</th>
                                <th>Status</th>
                                <th>Par</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allbesoins as $allbesoin)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $allbesoin->user->fullName() }}</td>
                                <td>{{ $allbesoin->libelle }}</td>
                                <td>{{ dateFr($allbesoin->created_at) }}</td>
                                <td>
                                    @if ($allbesoin->status == 'pending')
                                    <span class="badge bg-primary text-white rounded-lg">En Attente</span>
                                    @elseif($allbesoin->status == 'validated')
                                    <span class="badge bg-success text-white rounded-lg">Validé</span>
                                    @elseif($allbesoin->status == 'refused')
                                    <span class="badge bg-danger text-white rounded-lg">Refusé</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($allbesoin->status !== 'pending')
                                        @if ($allbesoin->rh_id != null)
                                            <span class="badge bg-warning text-white rounded-lg">{{ $allbesoin->rh->firstname }} {{ $allbesoin->rh->lastname
                                                }}</span>
                                        @endif
                                        @if ($allbesoin->chef_barm_id != null)
                                            <span class="badge bg-warning text-white rounded-lg">{{ $allbesoin->chef_barm->firstname }} {{
                                                $allbesoin->chef_barm->lastname
                                                }}</span>
                                        @endif
                                    @endif
                                    
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('besoins.edit', $allbesoin->id) }}"
                                        class="badge bg-primary text-white">Voir</a>

                                    @if ($allbesoin->status == 'pending')
                                        @if ($allbesoin->user_id == Auth::user()->id)
                                            {{-- <a href="{{ route('besoins.edit', $allbesoin->id) }}" class="badge bg-warning text-white">Modifier</a> --}}
                                            
                                            <form id="deleteForm" action="{{ route('besoins.destroy', $allbesoin->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a type="button" class="badge bg-danger text-white mt-2 delete_besoin" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Supprimer">Supprimer</a>
                                            </form>
                                        @endif
                                    
                                    @endif

                                    <a href="{{ route('pdf', $allbesoin->id) }}" class="badge bg-secondary text-white ">Télécharger</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif


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
