@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Commissions d'approbations/</span>{{ $title }}
                </h4>
            </nav>
        </div>

        <div class="ms-auto">
            <div class="btn-group">
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
                            <th>Mecano / Matricule</th>
                            <th>Nom & Prénoms</th>
                            <th class="text-start">Numéro de téléphone</th>
                            <th>Partenaire technique</th>
                            <th>Partenaire Financier</th>
                            @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion') ||
                            can('responsable-des-systemes-de-l-information|responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                <th>Avis</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatures as $adhrent)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $adhrent->user->mecano }}</td>
                            <td>{{ $adhrent->user->fullName() }}</td>
                            <td class="text-start">{{ $adhrent->phone_number }}</td>
                            <td>
                                @if ($adhrent->partnerTechnical)
                                <span class="badge bg-primary mb-2">{{
                                    $adhrent->partnerTechnical->user->username}}</span>
                                @endif
                            </td>
                            <td>
                                @if ($adhrent->partner_financial_id != null)
                                <span class="badge bg-primary mb-2">{{
                                    $adhrent->partnerFinancial->user->username}}</span>
                                @elseif ($adhrent->other_partner_financial != null)
                                <span class="badge bg-primary mb-2">{{ $adhrent->other_partner_financial}}</span>
                                @endif
                            </td>

                            @if (can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion') ||
                            can('responsable-des-systemes-de-l-information|responsable-suivi-evaluation|assistant-suivi-evaluation'))
                                @if ($adhrent->favorable_opinion == '0')
                                    <td class="text-danger">Défavorable</td>
                                @else
                                    <td class="text-success">Favorable</td>
                                @endif
                            @endif
                            
                            <td>
                                <a href="{{ route('adherent.show', $adhrent->user->id) }}" class="">
                                    <i class=" bx bx-show">

                                    </i>
                                </a>


                                @if(can('conseiller-auto-emploi') || can('chef-cellule-formation-et-insertion'))

                                    @if ($adhrent->favorable_opinion == '0')
                                        <a style="cursor: pointer" class="validated" data-candidat-id="{{ $adhrent->id }}">
                                            <span class="badge bg-success mb-2">Avis favorable</span>
                                        </a>
                                        
                                        <form id="validatedForm-{{ $adhrent->id }}"
                                            action="{{ route('commissions.candidat_opinion', $adhrent->id) }}" method="post">
                                            @csrf
                                            <input type="text" name="favorable_opinion" value="1" hidden>
                                            <input type="text" name="cohort_id" value="{{ $cohort->id }}" hidden>
                                        </form>
                                    @else
                                        <a style="cursor: pointer" class="refused" data-candidat-id="{{ $adhrent->id }}">
                                            <span class="badge bg-danger mb-2">Avis défavorable</span>
                                        </a>
                                        
                                        <form id="refusedForm-{{ $adhrent->id }}"
                                            action="{{ route('commissions.candidat_opinion', $adhrent->id) }}" method="post">
                                            @csrf
                                            <input type="text" name="favorable_opinion" value="0" hidden>
                                            <input type="text" name="cohort_id" value="{{ $cohort->id }}" hidden>
                                        </form>
                                    @endif

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

@push('js-push')
    <script>
        (function($) {
            "use strict";
            $('.refused').on('click', function() {
                var candidatId = $(this).data('candidat-id');
                var routerefused = $('#refusedForm-' + candidatId).attr('action');
                Swal.fire({
                    title: "Avis défavorable",
                    text: "Voulez-vous donner un avis défavorable à ce candidat?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, avis défavorable!",
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
                    title: "Avis favorable",
                    text: "Voulez-vous donner un avis favorable à ce candidat?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, avis favorable!",
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

@endsection