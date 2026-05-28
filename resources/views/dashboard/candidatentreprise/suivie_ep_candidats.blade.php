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
                        <i class="bx bx-chart-line text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Suivi des candidatures</div>
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
                    <i class="bx bx-search-alt text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Tableau de bord des candidatures</h5>
                        <small class="text-muted">Suivi détaillé des activités par candidat</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidats->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats</small>
                    </div>
                    <!-- Bouton mise à disposition commenté dans l'original
                    @if(can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                        <a href="{{ route('candidatentreprises.mise_a_disposition') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bx bx-transfer me-2"></i>
                            Mise à disposition
                        </a>
                    @endif
                    -->
                </div>
            </div>
        </div>

        <!-- Tableau de suivi -->
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
                                    <i class="bx bx-conversation text-primary me-1"></i>
                                    Entretiens
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-chart text-primary me-1"></i>
                                    Bilans
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-book text-primary me-1"></i>
                                    Formations
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-file-doc text-primary me-1"></i>
                                    CV & LM
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-user-voice text-primary me-1"></i>
                                    Prépa
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-send text-primary me-1"></i>
                                    Candidatures
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-file-blank text-primary me-1"></i>
                                    Rapports
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidats as $index => $candidat)
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
                                            @php
                                                $entretiens = $candidat->candidatentretiens()->count();
                                                $badgeClass = $entretiens > 0 ? 'bg-success' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $entretiens }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                $bilans = $candidat->bilancompetences()->count();
                                                $badgeClass = $bilans > 0 ? 'bg-success' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $bilans }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                $formations = $candidat->candidatformations()->count();
                                                $badgeClass = $formations > 0 ? 'bg-success' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $formations }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                $cvlms = $candidat->cvlms()->count();
                                                $badgeClass = $cvlms > 0 ? 'bg-success' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $cvlms }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                $prepas = $candidat->prepaentretiens()->count();
                                                $badgeClass = $prepas > 0 ? 'bg-success' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $prepas }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                $candidatures = $candidat->candidatentreprises()->count();
                                                $badgeClass = $candidatures > 0 ? 'bg-success' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $candidatures }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @php
                                                $rapports = $candidat->reportsPostMonitored()->count();
                                                $badgeClass = $rapports > 0 ? 'bg-success' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $rapports }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil détaillé">
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