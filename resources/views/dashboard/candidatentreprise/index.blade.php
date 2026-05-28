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
                        <i class="bx bx-transfer text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Gestion des placements</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto">
                @if (can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                    <div class="btn-group">
                        <a href="{{ route('candidatentreprises.mise_a_disposition') }}" type="button"
                            class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>
                            Mise à disposition
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-briefcase-alt text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Historique des mises à disposition</h5>
                        <small class="text-muted">Suivi des placements en entreprise par date</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $datas->count() }}
                        </div>
                        <small class="text-muted d-block">Mises à disposition</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $datas->unique('entreprise')->count() }}
                        </div>
                        <small class="text-muted d-block">Entreprises</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des mises à disposition -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Entreprise/Structure</th>
                                <th>Date de mise à disposition</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $candidatentreprise)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-building text-primary me-2"></i>
                                            <span class="fw-medium">{{ $candidatentreprise['entreprise'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-calendar text-success me-2"></i>
                                            <span>{{ dateFr($candidatentreprise['date_mise_disposition'], 'letter') }}</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('candidatentreprises.show', [$candidatentreprise['entreprise'], $candidatentreprise['date_mise_disposition']]) }}"
                                            title="Voir les détails">
                                            <i class="bx bx-show me-1"></i>
                                            Voir
                                        </a>
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
