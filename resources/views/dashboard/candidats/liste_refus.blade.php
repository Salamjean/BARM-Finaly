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
        <span class="text-muted fw-light">Candidatures/</span> Liste des candidatures refusées
    </h4>
    <div class="card">
        <h5 class="card-header">Liste des candidatures refusées</h5>
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th></th>
                            {{-- <th>Nom d'utilisateur</th> --}}
                            <th>Nom & Prénom(s)</th>
                            <th>Mécano</th>
                            <th>Email</th>
                            <th>N° téléphone </th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($liste_refus as $liste_refu)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            {{-- <td>@<a href="#">{{ $user->username }}</a></td> --}}
                            <td>{{ $liste_refu->first_name }} {{ $liste_refu->last_name }}</td>
                            <td></td>
                            <td>{{ $liste_refu->email }}</td>
                            <td>{{ $liste_refu->phone_number }}</td>
                            <td>
                                <span class="badge bg-label-danger me-1">Refusé</span>
                            </td>
                            <td>
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
