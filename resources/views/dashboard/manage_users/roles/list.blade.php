@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Roles/</span> Liste des roles
                </h4>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('role.create') }}" type="button" class="btn btn-primary">Ajouter un role</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Slug</th>
                            <th>Permissions</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->slug }}</td>
                            <td style="width: 10%">
                                @foreach ($role->permissions as $permission)
                                <span class="badge bg-primary">{{ $permission->name }}</span>
                                    @if (!$loop->last)
                                       &nbsp;
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if ($role->status == 1)
                                <a class="badge bg-success text-white rounded-lg"><i class='bx bx-check-circle'></i>Active</a>
                                @elseif($role->status == 0)
                                <a class="badge bg-danger text-white rounded-lg">Désactivé</a>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <a style="cursor: pointer" onclick="document.getElementById('delete-form-{{ $role->slug }}').submit()" class="badge bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer"><i class='bx bx-trash'></i>Supprimer</a>
                                <a href="{{ route('role.edit', ['slug' => $role->slug]) }}" class="badge bg-primary text-white"><i class='bx bx-edit'></i>Modifier</a>
                                <form id="delete-form-{{ $role->slug }}" action="{{ route('role.destroy', $role->slug) }}"
                                    method="get">
                                    @csrf
                                    @method("GET")
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
