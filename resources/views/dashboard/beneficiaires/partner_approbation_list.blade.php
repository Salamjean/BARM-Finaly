@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Sessions collectives d'informations/</span> {{ $title }}
    </h4>
    <div class="card">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-body mt-4">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>Date d'ajout</th>
                            <th>Nom & Prénoms</th>
                            <th>Numéro de téléphone</th>
                            <th>Orientation</th>
                            <th>Partenaires Techniques</th>
                            <th>Plan d'affaire du beneficiaire</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($formations as $formation)
                        <tr>
                            <td>{{ dateFr($formation->created_at) }}</td>
                            <td>{{ $formation->formationBeneficiaire->user->fullName() }}</td>
                            <td>{{ $formation->formationBeneficiaire->phone_number }}</td>
                            <td>{{ $formation->orientation }}</td>
                            <td>
                                <span class="badge bg-primary mb-2">{{ $formation->formationBeneficiaire->choiceFinal->partner->user->username
                                    }}</span>
                            </td>
                            <td>
                                <a href="{{ asset($formation->file_attachment) }}" download>
                                    <i class='bx bx-cloud-download fs-2'></i>
                                </a>
                            </td>
                            <td style="text-align: center">

                                    <a class="btn btn-outline-success fw-bold"
                                        href="{{ route('adherent.training.show', $formation->id) }}">
                                        Voir les infos
                                    </a>

                                {{-- <div>
                                    <a href="{{ route('ouverture_compte', $formation->id) }}" target="_blank"><i
                                            class="fa-solid fa-down-long"></i></a>
                                </div> --}}
                                
                                @php
                                    $partenaire_id = $formation->formationBeneficiaireFinancialPartner->where('partner_financial_id',Auth::user()->partenaire->id)->first();
                                @endphp
                                
                                @if ($partenaire_id == null)
                                    <a style="cursor: pointer" class="validated">
                                        <span class="badge bg-success mb-2">Approuver le plan d'affaire</span>
                                    </a>
                                    
                                    <a style="cursor: pointer" class="refused">
                                        <span class="badge bg-danger mb-2">Désapprouver le plan d'affaire</span>
                                    </a>
                                    
                                    <form class="validatedForm" action="{{route('beneficiaire.partner_approbation',$formation->id)}}" method="post">
                                        @csrf
                                        <input type="text" name='status' value="approuved" hidden>
                                        <input type="text" name='partner_id' value="{{ Auth::user()->partenaire->id }}" hidden>
                                    </form>
                                    
                                    <form class="refusedForm" action="{{route('beneficiaire.partner_approbation',$formation->id)}}" method="post">
                                        @csrf
                                        <input type="text" name='status' value="desapprouved" hidden>
                                        <input type="text" name='partner_id' value="{{ Auth::user()->partenaire->id }}" hidden>
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
    (function ($) {
            "use strict";
            $('.refused').on('click', function () {
                var routerefused = $('.refusedForm').attr('action');
                console.log(routerefused);
                Swal.fire({
                    title: "Approbation du plan d'affaire",
                    text: "Voulez-vous désapprouver le plan d'affaire du candidat?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, désapprouver!",
                    cancelButtonText: "Non, retour"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: routerefused,
                            type: 'POST',
                            data: $('.refusedForm').serialize(),
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
            var routevalidated = $('.validatedForm').attr('action');

            Swal.fire({
                title: "Approbation du plan d'affaire",
                text: "Voulez-vous approuver le plan d'affaire du candidat?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, approuver!",
                cancelButtonText: "Non, retour"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoyer le formulaire via AJAX
                    $.ajax({
                        url: routevalidated,
                        type: 'POST',
                        data: $('.validatedForm').serialize(),
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
