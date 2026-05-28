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

        <!-- Header avec bouton d'action -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user-check text-success fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des adhérents</h5>
                        <small class="text-muted">Liste complète des candidatures</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $submissions->count() }}
                        </div>
                        <small class="text-muted d-block">Adhérents</small>
                    </div>
                    @if (can('conseiller-auto-emploi|conseiller-entreprise-prive|conseiller-fonction-public|point-focal|conseiller-en-reconversion') || can('chef-cellule-formation-et-insertion'))
                        <a href="{{ route('adherent.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bx bx-plus me-2"></i>
                            Ajout d'un adhérent
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tableau des adhérents -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                
                                <th class="border-0">
                                    <i class="bx bx-calendar-plus text-primary me-1"></i>
                                    Auteur
                                     et Date d'ajout
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-id-card text-primary me-1"></i>
                                    Mecano
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                
                                <th class="border-0">
                                    <i class="bx bx-calendar-check text-primary me-1"></i>
                                    Date d'inscription
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
                            @foreach ($submissions as $index => $submission)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                            <div>
                                                <div class="fw-medium">{{ $submission->createdBy->fullName() }}</div>
                                                <small class="text-muted">{{ dateFr($submission->created_at, 'complet') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">{{ $submission->user->mecano }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $submission->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-secondary me-1">{{ $submission->user->mecano }}</span>
                                                    <span>{{ $submission->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="border-start border-success border-3 ps-2 py-1">
                                            <div class="fw-medium text-success">{{ dateFr($submission->completed_at, 'complet') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-medium text-warning">{{ $submission->orientation }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $stepStatus = stepCandidature($submission->step);
                                            $stepClass = 'bg-info'; // Default
                                            
                                            if (str_contains($stepStatus, 'Terminé') || str_contains($stepStatus, 'Complété')) {
                                                $stepClass = 'bg-success';
                                            } elseif (str_contains($stepStatus, 'En cours') || str_contains($stepStatus, 'Progression')) {
                                                $stepClass = 'bg-warning';
                                            } elseif (str_contains($stepStatus, 'En attente') || str_contains($stepStatus, 'Pending')) {
                                                $stepClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="bg-{{ str_replace('bg-', '', $stepClass) }} rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                            <span class="badge {{ $stepClass }}">{{ $stepStatus }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $submission->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            @if ($submission->step != 'completed')
                                                <a href="{{ route('adherent.step', [$submission->step, $submission->user->id]) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   title="Continuer l'étape">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
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
@endsection