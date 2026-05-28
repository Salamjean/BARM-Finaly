@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Commissions/</span> {{ $title }}
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
                            <th>Nombre d'adherent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cohorts as $cohort)
                        <tr>
                            <td>{{ $cohort->reference }}</td>
                            <td>{{ $cohort->title }}</td>
                            <td>
                                {{ $cohort->adhrents->count() }}
                                <span class="text-warning ms-1">/{{ $cohort->number_adherent }}</span>
                            </td>
                            <td style="text-align: center">
                                <a href="{{ route('commissions.candidat_commission_favorable', $cohort->id) }}"
                                    class="badge bg-primary text-white">Liste des candidats dont le PA à validé</a>

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