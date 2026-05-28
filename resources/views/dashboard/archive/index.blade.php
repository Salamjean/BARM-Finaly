@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Archives/</span> Liste des archives
                </h4>
            </nav>
        </div>

        <div class="ms-auto">
         @if(!can('chef-barm'))
            <div class="btn-group">
                <a href="{{ route('archive.create') }}" type="button" class="btn btn-primary">Créer un archive</a>
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
                            <th>Titres</th>
                            <th>Descriptions</th>
                            <th>Date de Publcation</th>
                            <th>Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($archives as $key => $archive)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                             <td>{{ $archive->titre }}</td> 
                             <td>{{ $archive->description }}</td>
                             <td>{{ dateFr($archive->date_publication) }}</td>
                             <td><img src="{{asset('assets/images/'.$archive->image)}}"  width="40px" alt="Archive Image"></td>
                            <td style="text-align: center">
                            <div class="d-flex "> 
                                <a href="{{route('archive.show',$archive->id)}}"
                                    class="badge bg-primary text-white m-2">Voir</a>
                                    <a href="{{route('archive.edit',$archive->id)}}"
                                    class="badge bg-warning text-white m-2">Modifier</a> 
                                 <form id="deleteForm" action="{{route('archive.delete',$archive->id)}}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a type="button" class="badge bg-danger text-white mt-2 delete_besoin"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Supprimer">Supprimer</a>
                                </form> 
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
                    title: "Supprimer cet archive ",
                    text: "Voulez-vous supprimer cet archive ?",
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
                                window.location.href = "{{asset('archive.liste')}}";
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