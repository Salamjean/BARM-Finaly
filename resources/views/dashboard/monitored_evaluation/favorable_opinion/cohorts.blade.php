@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item me-2"><a href="#" class="text-decoration-none">Suivi-Evaluation</a></li> /
                    <li class=" me-2">Avis favorable</li> /
                    <li class="ms-2 active" aria-current="page">Cohortes</li>
                </ol>
            </nav>
            <h1 class="h2 fw-bold text-primary">Avis favorable - Cohortes</h1>
        </div>
    </div>

    <div class="card shadow-none">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="datatable--barm">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Référence</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Libellé</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase">Nombre d'adhérent</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase text-center">Avis favorable en attente</th>
                            <th class="px-4 py-3 bg-light text-muted small fw-semibold text-uppercase text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cohorts as $cohort)
                        <tr>
                            <td class="px-4 py-3 align-middle">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary fw-normal">{{ $cohort->reference }}</span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $cohort->title }}</h6>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div>
                                    <div class="fw-medium">
                                        <span class="badge bg-success fs-6">{{ $cohort->adhrents->count() }}</span>
                                        <span class="text-muted mx-1">/</span>
                                        <span class="badge bg-warning fs-6">{{ $cohort->number_adherent }}</span>
                                    </div>
                                    <small class="text-muted">Inscrits / Capacité</small>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <span class="badge bg-warning bg-opacity-25 text-warning">{{ $cohort->adherents_favorable_opinion_pending }}</span>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <a href="{{ route('monitored-evaluation.favorable_opinion.cohort', $cohort->id) }}" 
                                   class="btn btn-primary btn-sm rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i>
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