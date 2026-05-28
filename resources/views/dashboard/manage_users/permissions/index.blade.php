@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                {{-- <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="active" aria-current="page">Liste des permissions</li>
                </ol> --}}
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Permissions/</span> Liste des permissions
                </h4>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('permissions.create') }}" type="button" class="btn btn-primary">Ajouter une permission</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->slug }}</td>
                            <td>
                                @if ($permission->status == 1)
                                <span class="badge bg-success text-white rounded-lg"><i class='bx bx-check-circle'></i>Active</span>
                                @elseif($permission->status == 0)
                                <span class="badge bg-danger text-white rounded-lg">Désactivé</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <a style="cursor: pointer" onclick="document.getElementById('delete-form-{{ $permission->slug }}').submit()" class="badge bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer"><i class='bx bx-trash'></i>Supprimer</a>
                                <a href="{{ route('permissions.edit', $permission->slug) }}" class="badge bg-primary text-white"><i class='bx bx-edit'></i>Modifier</a>
                                <form id="delete-form-{{ $permission->slug }}" action="{{ route('permissions.destroy', $permission->slug) }}"
                                    method="post">
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
