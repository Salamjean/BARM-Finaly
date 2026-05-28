
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
                        <i class="bx bx-book-open text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Gestion des formations</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto">
                @if(can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                <div class="btn-group">
                    <a href="{{ route('formations.create') }}" type="button" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i>
                        Enregistrer une formation
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-graduation text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">Gestion des formations professionnelles</h5>
                        <small class="text-muted">Suivi et organisation des programmes de formation</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $formations->count() }}
                        </div>
                        <small class="text-muted d-block">Formations</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ $formations->where('date_fin', '>=', now())->count() }}
                        </div>
                        <small class="text-muted d-block">Actives</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des formations -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Entreprise</th>
                                <th>Intitulé</th>
                                <th>Lieu</th>
                                <th>Date de debut</th>
                                <th>Date de fin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formations as $formation)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{ $formation->entreprise }}</td>
                                <td>{{ $formation->intitule }}</td>
                                <td>{{ $formation->lieu }}</td>
                                <td>{{ dateFr($formation->date_db, 'letter') }}</td>
                                <td>{{ dateFr($formation->date_fin, 'letter') }}</td>
                                <td style="text-align: center">
                                    <a class="badge bg-primary text-white"
                                        href="{{route('formations.show',$formation->id)}}">
                                        voir
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