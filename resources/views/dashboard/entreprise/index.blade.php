@extends('layouts.app')

@section('content')
    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
    @endpush
    
    <div class="container-fluid">
        <!-- Breadcrumb modernisé -->
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-buildings text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Gestion des entreprises</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto">
                @if(can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                <div class="btn-group">
                    <a href="{{ route('entreprises.create') }}" type="button" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i>
                        Enregistrer une entreprise
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-building text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des entreprises partenaires</h5>
                        <small class="text-muted">Suivi et gestion des entreprises du réseau</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $entreprises->count() }}
                        </div>
                        <small class="text-muted d-block">Entreprises</small>
                    </div>
                   
                </div>
            </div>
        </div>

        <!-- Tableau des entreprises -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Spécialisation</th>
                                <th>Localisation</th>
                                <th>Num de téléphone</th>
                                <th>Nom du point focal</th>
                                <th>Numéro du point focal</th>
                                <th>Email du point focal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entreprises as $entreprise)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{ $entreprise->nom }}</td>
                                <td>{{ $entreprise->specialisation }}</td>
                                <td>{{ $entreprise->localisation }}</td>
                                <td>{{ $entreprise->num_decharge }}</td>
                                <td>{{ $entreprise->nom_point_focal }}</td>
                                <td>{{ $entreprise->num_point_focal }}</td>
                                <td>{{ $entreprise->email_point_focal }}</td>
                                <td style="text-align: center">
                                    <a class="badge bg-primary text-white"
                                        href="{{route('entreprises.show',$entreprise->id)}}">
                                        voir
                                    </a>

                                    <a class="badge bg-warning text-white" href="{{route('entreprises.edit',$entreprise->id)}}">
                                        Modifier
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