@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Personnels/</span> Liste des Personnels
        </h4>
        <div class="card">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

                <div class="ms-auto py-2 px-2">

                    <div class="btn-group">
                        <a href="{{ route('personnel.index') }}" type="button" class="btn btn-primary">Liste du personnel</a>
                    </div>
                </div>
            </div>
            <h5 class="card-header pt-0">Liste des Personnels</h5>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Matricule BARM</th>
                                <th>Nom & Prénom(s)</th>
                                <th>N° téléphone </th>
                                <th>Service</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($personals as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td><b>{{ $item->matricule_barm }}</b></td>
                                    <td>{{ $item->user->fullName() }}</td>
                                    <td>{{ $item->user->phone }}</td>
                                    <td>
                                        @foreach ($item->user->roles as $role)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                            @if (!$loop->last)
                                                &nbsp;
                                            @endif
                                        @endforeach
                                    </td>



                                    <td>
                                        @if ($item->death == 1)
                                            <span class="badge bg-label-danger me-1">Décédé</span>
                                        @else
                                            <span class="badge bg-label-danger me-1">Supprimé</span>
                                        @endif
                                    </td>


                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
