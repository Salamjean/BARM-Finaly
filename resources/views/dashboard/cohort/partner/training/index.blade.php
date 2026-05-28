@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/Formations/</span> Liste
                    </h4>
                </nav>
            </div>

        </div>
        <div class="mb-4">
            <div class="btn-group">
                <a href="{{ route('cohort.training.create', $cohort->id) }}" class="btn btn-info">
                    AJOUTER UNE FORMATION
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="ms-auto mb-2">
                    <div class="d-flex " style="gap:10px;">
                        <a href="{{ route('cohort.partner.show', $cohort->id) }}" class="btn btn-danger">
                            <i class="fa fa-arrow-circle-left me-2"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Intitulé</th>
                                <th>Nombre</th>
                                <th>F. Présence</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainings as $training)
                                <tr>
                                    <td>{{ dateFr($training->beging_date) }}</td>
                                    <td>
                                        {{ $training->status == 'pending' ? '#' : dateFr($training->end_date) }}
                                    </td>
                                    <td>{{ $training->title }}</td>

                                    <td class="text-center">{{ $training->participations->count() }}</td>
                                    <td class="text-center">
                                        @if ($training->file_presence)
                                            <a class="text-italic" href="{{ asset($training->file_presence) }}" target="_blank">voir</a>
                                        @endif
                                    </td>
                                    <th>{{ $training->status == 'pending' ? 'En cours' : 'Terminer' }}</th>

                                    <td>
                                        <a href="{{ route('cohort.training.show', $training->id) }}"
                                            class="btn btn-secondary">Détail</a>
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
