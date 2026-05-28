@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Etablir le budget annuel/</span> Liste des budgets
                    </h4>
                </nav>
            </div>


        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    @if (can('responsable-du-patrimoine-et-de-la-logistique|assistant-du-patrimoine-et-de-la-logistique'))
                        <div class="d-flex justify-content-end mb-2">
                            <div class="btn-group">
                                <a href="{{ route('annual-budget.create') }}" type="button" class="btn btn-primary">Etablie
                                    le budget
                                    de
                                    l'année</a>
                            </div>
                        </div>
                    @endif
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start">Année</th>
                                <th>Nbre de participant</th>
                                <th>Date de demarage</th>
                                <th>Titre</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets as $budget)
                                <tr>
                                    <td class="">{{ $budget->year }}</td>
                                    <td class="text-warning">{{ count($budget->budgetByCell) }} <span class="text-dark">/
                                            {{ count(ROLES) }}</span></td>
                                    <td class="">{{ dateFr($budget->date) }}</td>
                                    <td class="" style="width: 30vw;">{{ $budget->title }}</td>
                                    @php
                                        if($budget->status == "finished")
                                            $statusName = "Terminer";
                                        elseif($budget->status == "negotiation")
                                            $statusName = "Négociation";
                                        else
                                            $statusName = "Lancement";
                                    @endphp
                                    <td class="text-center">{{ $statusName }}</td>
                                    <td class="text-center">
                                        <a href={{ route('annual-budget.show', $budget->id) }}" class="btn btn-info">
                                            Détail
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
