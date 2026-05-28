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
    <div class="card ">
        <div class="card-body d-flex">
            @foreach($dossiers as $dossier)
         <div class="m-3"> <a href="{{route('archive.index',$dossier->id)}}"><i class='bx bx-folder'style='font-size:100px;color:orange'></i></a>
         <div class="m-2 text-center">{{$dossier->nom}}</div></div> 
          @endforeach
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
                                window.location.href = "{{ route('archive.index',$dossier->id) }}";
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