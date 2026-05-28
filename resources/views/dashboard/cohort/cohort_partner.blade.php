@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/</span> Liste
                    </h4>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">

                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Libelle</th>
                                <th class="text-start">Nombre d'adherent</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cohorts as $cohort)
                                <tr>
                                    <td>{{ $cohort->reference }}</td>
                                    <td>{{ $cohort->title }}</td>
                                    <td class="text-start">
                                        {{ $cohort->adhrents->where('partner_technical_id', auth()->user()->partenaire->id)->count() }}

                                    </td>
                                    <td>{{ $cohort->status == '0' ? 'En cours' : 'Terminer' }}</td>
                                    <td style="text-align: center">
                                        <a href="{{ route('cohort.partner.show', $cohort->id) }}"
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
