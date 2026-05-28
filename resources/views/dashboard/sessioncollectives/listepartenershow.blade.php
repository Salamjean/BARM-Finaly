@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Sessions collectives d'informations/</span> {{ $title }}
    </h4>
    <div class="card">
        <div class="card-body mt-4">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom & Prénoms</th>
                            <th>Numéro de téléphone</th>
                            <th>Présence</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($candidatures as $candidat)

                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{ $candidat->user->fullName() }}</td>
                            <td>{{ $candidat->phone_number }}</td>
                            
                           
                                @if ($candidat->pivot->presence_status == '0')
                                    <td class="text-danger">Absent</td>
                                @elseif ($candidat->pivot->presence_status == '1')
                                    <td class="text-success">Présent</td>
                                @endif
                            

                            <td class="d-flex justify-content-between">
                                
                                    <a href="{{ route('adherent.show', $candidat->user->id) }}">
                                        <i class='bx bxs-show'></i>
                                    </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('js-push')
<script>
    (function ($) {
            "use strict";
            $('.refused').on('click', function () {
                var routerefused = $('#refusedForm').attr('action');
                console.log(routerefused);
                Swal.fire({
                    title: "Réfuser cet candidat ",
                    text: "Voulez-vous réfuser cet candidat ?",
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
                            data: $('#refusedForm').serialize(),
                            success: function (response) {
                                window.location.reload();
                            },
                            error: function (xhr, status, error) {

                            }
                        });
                    }
                });
            });

        })(jQuery);
</script>

<script>
    (function ($) {
        "use strict";
        $('.validated').on('click', function () {
            var routevalidated = $('#validatedForm').attr('action');
            console.log(routevalidated );
            Swal.fire({
                title: "Accepter cet candidat ",
                text: "Voulez-vous accepter cet candidat ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, accepter!",
                cancelButtonText: "Non, retour"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoyer le formulaire via AJAX
                    $.ajax({
                        url: routevalidated,
                        type: 'POST',
                        data: $('#validatedForm').serialize(),
                        success: function (response) {
                            window.location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    })(jQuery);
</script>
@endpush