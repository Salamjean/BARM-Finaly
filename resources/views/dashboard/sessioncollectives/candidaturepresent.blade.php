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
                            <div class="text-muted small">Sessions collectives d'informations</div>
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
                    <i class="bx bx-user-check text-success fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Liste des candidats</h5>
                        <small class="text-muted">Participants inscrits à la session</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $candidatures->count() }}
                        </div>
                        <small class="text-muted d-block">Candidats</small>
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
                                    #
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-bookmark text-primary me-1"></i>
                                    Cohorte
                                </th>
                                
                                <th class="border-0">
                                    <i class="bx bx-user text-primary me-1"></i>
                                    Nom & Prénoms
                                </th>
                                <th class="border-0">
                                    Session collective
                                </th>
                                <th class="border-0">
                                    Présence à la session
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-primary me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatures as $index => $candidat)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-primary border-3 ps-2 py-1">
                                            <div class="fw-bold text-primary">{{ $candidat->cohort->title }}</div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $candidat->user->fullName() }}</div>
                                                <div class="small text-muted">
                                                    <span
                                                        class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                                                    <span>{{ $candidat->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border-start border-primary border-3 ps-2 py-1">
                                            <div class="fw-bold text-primary">
                                                {{ $candidat->sessionCollective->lieu }} <br> {{ $candidat->sessionCollective->date }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if ($candidat->candidatureSessioncollective->presence_status == '1')
                                                <span class="badge bg-success">Présent</span>
                                            @else
                                                <span class="badge bg-danger">Absent</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil de l'adhérent">
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
