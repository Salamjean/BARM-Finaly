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
                        <i class="bx bx-user-voice text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Gestion des préparations</div>
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
                    <i class="bx bx-conversation text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Préparation aux entretiens</h5>
                        <small class="text-muted">Suivi des séances de préparation par candidat</small>
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
                            {{ $candidats->sum(function ($c) {return $c->prepaentretiens->count();}) }}
                        </div>
                        <small class="text-muted d-block">Séances</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tableau des candidats -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénoms</th>
                                <th>Nombre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidats as $candidat)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div>{{ $candidat->user->fullName() }}</div>
                                        <div class="fs-7">
                                            <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>

                                            <span>{{ $candidat->phone_number }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $prepaCount = $candidat->prepaentretiens->count();
                                            $badgeClass = $prepaCount > 0 ? 'bg-success' : 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-6">{{ $prepaCount }}</span>
                                        @if ($prepaCount > 0)
                                            <small class="text-muted d-block">
                                                @if ($prepaCount === 1)
                                                    Séance effectuée
                                                @else
                                                    Séances effectuées
                                                @endif
                                            </small>
                                        @else
                                            <small class="text-muted d-block">Aucune séance</small>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('adherent.show', $candidat->user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('prepaentretiens.index', $candidat->id) }}"
                                                title="Voir les préparations">
                                                <i class="bx bx-user-voice me-1"></i>
                                                Préparations
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
