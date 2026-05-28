@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Cohorte/</span>Détail
                    </h4>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="d-flex " style="gap:10px;">
                    <a href="{{ route('cohort.training.index', $cohort->id) }}" class="btn btn-warning">Formations</a>
                    @if ($cohort->trainings->where('status', 'finished')->count() > 0)
                        <a href="{{ route('cohort.data_collect.index', $cohort->id) }}" class="btn btn-info">Collecte de données</a>
                    @endif
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="ms-auto">
                    <div class="d-flex " style="gap:10px;">
                        <a href="{{ route('cohort.partner.index') }}" class="btn btn-danger">
                            <i class="fa fa-arrow-circle-left me-2"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Mecano / Matricule</th>
                                <th>Nom & Prénoms</th>
                                <th>Spécialisation</th>
                                <th class="text-start">Numéro de téléphone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adherents as $adhrent)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $adhrent->user->mecano }}</td>
                                    <td>{{ $adhrent->user->fullName() }}</td>
                                    <td>{{ $adhrent->choiceFinal->specialisation }}</td>
                                    <td class="text-start">{{ $adhrent->phone_number }}</td>
                                    <td>
                                        <a href="{{ route('adherent.show', $adhrent->user->id) }}" class="">
                                            <i class=" bx bx-show">
                                            </i>
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
