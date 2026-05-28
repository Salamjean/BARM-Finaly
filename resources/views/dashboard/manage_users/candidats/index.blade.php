@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Candidats/</span> Liste des Candidats
    </h4>
    <div class="card">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.candidat.create') }}" type="button" class="btn btn-primary">Enregistrer un candidat</a>
                </div>
            </div>
        </div>
        <h5 class="card-header">Liste des Candidats</h5>
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom d'utilisateur</th>
                            <th>Nom & Prénom(s)</th>
                            <th>Email</th>
                            <th>N° téléphone </th>
                            <th>Rôles</th>
                            <th>Status</th>
                            @canany(['delete-candidat', 'edit-candidat'])
                                <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($candidats as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>@<a href="#">{{ $item->user->username }}</a></td>
                            <td>{{ $item->user->fullName() }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>
                                @foreach ($item->user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                                @if (!$loop->last)
                                &nbsp;
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @if ($item->user->status == 1)
                                <span class="badge bg-label-success me-1"><i
                                        class='bx bx-check-circle'></i>Active</span>
                                @elseif($item->user->status == 0)
                                <span class="badge bg-label-danger me-1">Désactivé</span>
                                @endif
                            </td>
                            @canany(['delete-candidat', 'edit-candidat'])
                            <td>
                                <a style="cursor: pointer"
                                    onclick="document.getElementById('delete-form-{{ $item->id }}').submit()"
                                    class="badge bg-danger text-white" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Supprimer"><i
                                        class='bx bx-trash'></i>Supprimer</a>
                                <a href="{{ route('admin.candidat.edit', $item->id) }}"
                                    class="badge bg-primary text-white float-end"><i class='bx bx-edit'></i>Modifier</a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.candidat.destroy', $item->id) }}"
                                    method="post">
                                    @csrf
                                    @method("DELETE")
                                </form>
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
