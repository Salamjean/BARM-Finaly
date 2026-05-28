@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user-check text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Profilages</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user-circle text-success fs-3 me-3"></i>
                    <div>
                        
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidatures->filter(function($adherent) { return $adherent->choiceFinal; })->count() }}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">
            
            
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
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-primary me-1"></i>
                                    Partenaire technique
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-calendar-check text-primary me-1"></i>
                                    Date du profilage
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatures as $index => $adherent)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">{{ $index + 1 }}</span>
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
                                        <div class="border-start border-primary border-3 ps-2 py-1">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary">{{ $adherent->partnerTechnical->user->username }}</span>
                                            </div>
                                            <small class="text-muted">Partenaire assigné</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($adherent->choiceFinal)
                                            <div class="border-start border-success border-3 ps-2 py-1">
                                                <div class="fw-medium text-success">
                                                    {{ $adherent->choiceFinal->profilage_date 
                                                        ? dateFr($adherent->choiceFinal->profilage_date) 
                                                        : dateFr($adherent->choiceFinal->created_at) }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                                <span class="badge bg-warning">Non définie</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('adherent.show', $adherent->user->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir le profil de l'adhérent">
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

    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
@endsection