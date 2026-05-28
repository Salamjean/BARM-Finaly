@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Plan d'affaire/</span> Liste des plans d'affaire
                </h4>
            </nav>
        </div>

        <div class="ms-auto">
         @if(!can('chef-barm'))
            <div class="btn-group">
                <a href="{{ route('plan_affaire.create') }}" type="button" class="btn btn-primary">Créer un plan d'affaire</a>
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
                            <th>N°</th>
                            <th>Nom & Prenom du candidat(e)</th>
                            <th>Plan d'affaire</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($planaffaires as $key => $planaffaire)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $planaffaire->candidature->user->firstname ?? null }} {{ $planaffaire->candidature->user->lastname ?? null}}</td>
                            <td class="text-center">
                             @if ($planaffaire->plan != null)
                             <a href="{{ asset('assets/plans/' . $planaffaire->plan) }}" class="btn btn-outline-secondary btn-sm btn-rounded" title="Télécharger le plan d'affaire" download="{{ $planaffaire->plan }}"><i class="fas fa-paperclip"> Plan d'affaire</i></a>
                             @endif
                            <td>{{ date('d/m/Y', strtotime($planaffaire->created_at)) }}</td>
                            <td class="text-center">
                            @if($planaffaire->status === "en cours")
                                            <span class="badge bg-warning">En cours</span>
                                        @endif
                             @if($planaffaire->status === "accepted")
                                            <span class="badge bg-success">Valider</span>
                                        @endif
                                        @if($planaffaire->status === "refused")
                                            <span class="badge bg-danger">Refuser</span>
                                        @endif        
                            </td>
                            <td style="text-align: center">
                            <div class="d-flex "> 
                                <a href="{{ route('plan_affaire.edit', $planaffaire->id) }}"
                                    class="badge bg-primary text-white m-2">Voir</a>
                                {{--<a href="{{ route('plan_affaire.edit', $planaffaire->id) }}"
                                    class="btn btn-primary text-white">Modifier</a> --}}
                                    @if(!can('chef-barm'))
                                 <form id="deleteForm" action="{{ route('plan_affaire.delete', $planaffaire->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a type="button" class="badge bg-danger text-white mt-2 delete_besoin"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Supprimer">Supprimer</a>
                                </form> 
                                @endif
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    (function ($) {
            "use strict";
            $('.delete_besoin').on('click', function () {
                var route = $(this).closest('form').attr('action');
                Swal.fire({
                    title: "Supprimer le plan d'affaire ",
                    text: "Voulez-vous supprimer ce plan d'affaire ?",
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
                                window.location.href = "{{ route('plan_affaire.index') }}";
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