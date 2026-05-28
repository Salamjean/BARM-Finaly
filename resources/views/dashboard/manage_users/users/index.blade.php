@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Liste</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="active">Liste des utilisateurs</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('users.create') }}" type="button" class="btn btn-primary">Enregistrer un
                    utilisateur</a>
            </div>
        </div>
    </div> --}}
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Utilisateurs/</span> Liste des utilisateurs
    </h4>
    <div class="card">
        <h5 class="card-header">Liste des utilisateurs</h5>
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
                            @canany(['delete-user', 'edit-user'])
                                <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>@<a href="#">{{ $user->username }}</a></td>
                            <td>{{ $user->fullName() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                <span class="badge bg-primary">{{ roleFr($role->name) }}</span>
                                @if (!$loop->last)
                                &nbsp;
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @if ($user->status == 1)
                                <span class="badge bg-label-success me-1"><i
                                        class='bx bx-check-circle'></i>Active</span>
                                @elseif($user->status == 0)
                                <span class="badge bg-label-danger me-1">Désactivé</span>
                                @endif
                            </td>
                            @canany(['delete-user', 'edit-user'])
                            <td>
                                <a style="cursor: pointer"
                                    onclick="document.getElementById('delete-form-{{ $user->id }}').submit()"
                                    class="badge bg-danger text-white" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Supprimer"><i
                                        class='bx bx-trash'></i>Supprimer</a>
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="badge bg-primary text-white float-end"><i class='bx bx-edit'></i>Modifier</a>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}"
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
