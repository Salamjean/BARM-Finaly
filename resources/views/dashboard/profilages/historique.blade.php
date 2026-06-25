@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush

    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-group text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Historique des profilages</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user-plus text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Candidatures</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $histories->count() }}
                        </div>
                        <small class="text-muted d-block">Candidatures</small>
                    </div>
                </div>
            </div>
        </div>



        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="border-0">
                                            Cohorte
                                        </th>
                                        <th class="border-0">
                                            Date
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-user text-primary me-1"></i>
                                            Nom & Prénoms
                                        </th>
                                        <th class="border-0">
                                            <i class="bx bx-user-x text-primary me-1"></i>
                                            Statut
                                        </th>
                                        
                                        <th class="border-0 ">
                                            <i class="bx bx-message-square-x text-primary me-1"></i>
                                            Motif de refus
                                        </th>
                                        <th class="border-0 text-center">
                                            <i class="bx bx-cog text-primary me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $index => $history)
                                        <tr class="align-middle">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge bg-info me-2">{{ $history->candidature->cohort->title }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-medium">
                                                            {{ dateFr($history->updated_at) }}</div>
                                                        <small
                                                            class="text-muted">{{ dateFr($history->updated_at, 'complet') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold text-dark">
                                                            {{ $history->candidature->user->fullName() }}</div>
                                                        <div class="small text-muted">
                                                            <span
                                                                class="badge bg-secondary me-1">{{ $history->candidature->user->mecano }}</span>
                                                            <span>{{ $history->candidature->phone_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                @if ($history->status == 'refused')
                                                    <span class="badge bg-danger">
                                                        Refusé
                                                    </span>
                                                @elseif ($history->status == 'accepted')
                                                    <span class="badge bg-success">
                                                        Accepté
                                                    </span>
                                                @elseif ($history->status == 'absent')
                                                    <span class="badge bg-warning text-white">
                                                        Absent
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-white">
                                                        En attente
                                                    </span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if ($history->status == 'refused')
                                                    <div class="border-start border-danger border-3 ps-2 py-1">
                                                        <div class="text-danger small">
                                                            {{ $history->reason_rejet ?? 'Aucun motif spécifié' }}
                                                        </div>
                                                        <small class="text-muted">
                                                            Refusé le {{ dateFr($history->updated_at) }}
                                                        </small>
                                                    </div>
                                                @elseif ($history->status == 'absent')
                                                    <div class="border-start border-warning border-3 ps-2 py-1">
                                                        <div class="text-warning small fw-bold">
                                                            {{ $history->reason_rejet ?? 'Aucun motif spécifié' }}
                                                        </div>
                                                        <small class="text-muted">
                                                            Marqué absent le {{ dateFr($history->updated_at) }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">

                                                    <a href="{{ route('adherent.show', $history->candidature->user->id) }}"
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


        </div>
    </div>
@endsection
