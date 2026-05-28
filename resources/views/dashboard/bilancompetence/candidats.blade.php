@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-chart text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Bilan de compétences</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-analyse text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Suivi des bilans de compétences</h5>
                        <small class="text-muted">Évaluation des compétences par candidat</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $candidats->sum(function($c) { return $c->bilancompetences->count(); }) }}
                        </div>
                        <small class="text-muted d-block">Bilans</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-chart-line text-primary me-1"></i>
                                    Nombre de bilans
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidats as $index => $candidat)
                                @php
                                    $bilanCount = $candidat->bilancompetences->count();
                                    $badgeClass = $bilanCount > 0 ? 'bg-success' : 'bg-secondary';
                                @endphp
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                    <span>{{ $candidat->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $bilanCount }}</span>
                                            @if($bilanCount > 0)
                                                <small class="text-muted d-block">
                                                    @if($bilanCount === 1)
                                                        Bilan effectué
                                                    @else
                                                        Bilans effectués
                                                    @endif
                                                </small>
                                            @else
                                                <small class="text-muted d-block">Aucun bilan</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('bilancompetences.index', $candidat->id) }}" 
                                               class="btn btn-primary btn-sm" 
                                               title="Voir les bilans de compétences">
                                                <i class="bx bx-chart me-1"></i>
                                                Bilans
                                            </a>
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

    @push('js-push')
        <script>
            (function($) {
                "use strict";
                
                // Scripts SweetAlert préservés (si nécessaires)
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
@endsection