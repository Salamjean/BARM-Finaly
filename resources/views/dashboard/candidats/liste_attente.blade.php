@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Candidatures/</span> Liste des candidatures acceptées
    </h4>
    <div class="card">
        <h5 class="card-header">Liste des candidatures acceptées</h5>
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom & Prénom(s)</th>
                            <th>Mécano</th>
                            <th>Email</th>
                            <th>N° téléphone </th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($liste_attentes as $liste_attente)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $liste_attente->user->fullName() }}</td>
                            <td>{{ $liste_attente->user->mecano }}</td>
                            <td>{{ $liste_attente->user->email }}</td>
                            <td>{{ $liste_attente->phone_number }}</td>
                            <td>
                                @if($liste_attente->status == 'accepted')
                                    <span class="badge bg-label-success me-1">Accepté</span>
                                @elseif ($liste_attente->status == 'refused')
                                    <span class="badge bg-label-danger me-1">Réfusé</span>
                                @else
                                    <span class="badge bg-label-primary me-1">En attente</span>
                                @endif
                            </td>
                            <td>
                                <a style="cursor: pointer" onclick="document.getElementById('refuse-{{ $liste_attente->id }}').submit()"
                                    class="badge bg-danger text-white" title="Refuser">Refuser</a>
                                <a style="cursor: pointer" onclick="document.getElementById('accepte-{{ $liste_attente->id }}').submit()"
                                    class="badge bg-success text-white" title="Accepter">Accepter</a>

                                <form id="refuse-{{ $liste_attente->id }}" action="{{route('candidature.refuse_candidature',$liste_attente->id ) }}" method="post">
                                    @csrf
                                </form>

                                <form id="accepte-{{ $liste_attente->id }}" action="{{route('candidature.accepte_candidature', $liste_attente->id) }}" method="post">
                                    @csrf
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
