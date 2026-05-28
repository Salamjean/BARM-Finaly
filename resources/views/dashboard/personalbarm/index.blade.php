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
                        <a href="{{ route('personalbarm.militaire') }}" type="button" class="btn btn-warning">Enregistrer un
                            Personnel Militaire</a>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('personalbarm.civil') }}" type="button" class="btn btn-primary">Enregistrer un
                            Personnel Civil</a>
                    </div>
                </div>
            </div>
            <h5 class="card-header pt-0">Liste des Personnels</h5>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="">#</th>
                                <th>Matricule BARM</th>
                                <th>Nom & Prénom(s)</th>
                                <th>Type</th>
                                <th>N° téléphone </th>
                                <th>Service</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($personals as $item)
                                <tr>
                                    <td class="">{{ $loop->index + 1 }}</td>
                                    <td><b>{{ $item->matricule_barm }}</b></td>
                                    <td>{{ $item->fullName() }}</td>
                                    <td class="text-capitalize">{{ $item->type }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                            <span class="badge bg-primary">{{ $item->cell }}</span>
                                    </td>

                                    <td class="d-flex" style="gap: 10px;">
                                        <a href="{{ route('personalbarm.edit', $item->id) }}"
                                            class="badge bg-primary text-white"><i class='bx bx-edit'></i>Modifier</a>

                                        <form action="{{ route('personalbarm.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button style="cursor: pointer" type="submit"
                                                class="badge bg-danger text-white" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Supprimer"><i
                                                    class='bx bx-trash'></i>Supprimer</button>


                                        </form>
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
