@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <style>
                    .custom-breadcrumb {
                        background: #f8f9fa;
                        border-radius: 0.5rem;
                        padding: 0.75rem 1.5rem;
                        font-size: 1.08rem;
                        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                    }
                    .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
                        content: '\203A'; /* chevron » */
                        color: #6c757d;
                        font-weight: bold;
                        margin: 0 0.5rem;
                    }
                    .custom-breadcrumb .breadcrumb-item a {
                        color: #0d6efd;
                        text-decoration: none;
                        transition: color 0.2s;
                    }
                    .custom-breadcrumb .breadcrumb-item a:hover {
                        color: #084298;
                        text-decoration: underline;
                    }
                    .custom-breadcrumb .breadcrumb-item.active {
                        color: #495057;
                        font-weight: 600;
                    }
                </style>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb custom-breadcrumb mb-4">
                        <li class="breadcrumb-item me-2"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item me-2"><a href="{{ route('monitored-evaluation.credit_committee.index') }}">Suivi-Evaluation</a></li>
                        <li class="breadcrumb-item me-2 active" aria-current="page">PV Comité</li>
                    </ol>
                </nav>
            </div>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="btn-group d-flex justify-content-end">
                    <div class="d-flex">
                        <a href="{{ route('monitored-evaluation.credit_committee.create') }}" type="button"
                            class="btn btn-primary text-end">Organiser
                        </a>
                    </div>
                </div>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Date du comité</th>
                                <th>Nombre d'adherent</th>
                                <th class="text-center">Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($committees as $pv)
                                <tr>
                                    <td>{{ $pv->reference }}</td>
                                    <td>{{ dateFr($pv->date) }}</td>
                                    <td>
                                        {{ $pv->creditCommittees()->count() }}
                                    </td>
                                    <td class="text-center">{{ $pv->status == 'finished' ? 'Terminer' : 'En attente' }}</td>
                                    <td style="text-align: center">
                                        <a href="{{ route('monitored-evaluation.credit_committee.show', $pv->id) }}"
                                            class="badge bg-primary text-white">Voir</a>
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
