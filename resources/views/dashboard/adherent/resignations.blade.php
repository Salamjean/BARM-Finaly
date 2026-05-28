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
                        <i class="bx bx-group text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Adhérents</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Carte principale avec header intégré -->
        <div class="bg-white rounded-3 shadow-sm">
            <!-- Header de la carte -->
            <div class="border-bottom p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-list-ul text-success fs-3 me-3"></i>
                        <div>
                            <h5 class="mb-0 text-dark">{{ $title }}</h5>
                            <small class="text-muted">Gestion des candidatures</small>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $adherents->count() }}
                        </div>
                        <small class="text-muted d-block">Adhérents</small>
                    </div>
                </div>
            </div>

            <!-- Contenu du tableau -->
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th class="border-0">
                                    <i class="bx bx-hash text-primary me-1"></i>
                                    #
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-calendar-plus text-primary me-1"></i>
                                    Date d'ajout
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                
                                <th class="border-0">
                                    <i class="bx bx-compass text-primary me-1"></i>
                                    Orientation
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-check-circle text-primary me-1"></i>
                                    Statut
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $index => $adherent)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">{{ $index + 1 }}</span>
                                            <div>
                                                <div class="fw-medium">{{ dateFr($adherent->created_at) }}</div>
                                                <small class="text-muted">{{ dateFr($adherent->created_at, 'complet') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $adherent->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $adherent->user->mecano }}</span>
                                                    <span>{{ $adherent->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-medium text-info">{{ $adherent->orientation }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $stepStatus = stepCandidature($adherent->step);
                                            $stepClass = 'bg-info'; // Default
                                            $circleClass = 'info';
                                            
                                            if (str_contains($stepStatus, 'Terminé') || str_contains($stepStatus, 'Complété')) {
                                                $stepClass = 'bg-success';
                                                $circleClass = 'success';
                                            } elseif (str_contains($stepStatus, 'En cours') || str_contains($stepStatus, 'Progression')) {
                                                $stepClass = 'bg-warning';
                                                $circleClass = 'warning';
                                            } elseif (str_contains($stepStatus, 'En attente') || str_contains($stepStatus, 'Pending')) {
                                                $stepClass = 'bg-secondary';
                                                $circleClass = 'secondary';
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="bg-{{ $circleClass }} rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                            <span class="badge {{ $stepClass }}">{{ $stepStatus }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil">
                                                <i class="bx bx-show"></i>
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
@endsection