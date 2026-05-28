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
                        <i class="bx bx-user-voice text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Préparation entretien</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="ms-auto">
                @if(can('conseiller-entreprise-prive') || can('chef-cellule-formation-et-insertion'))
                <div class="btn-group">
                    <a href="{{ route('prepaentretiens.create',$candidat->id) }}" type="button" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i>
                        Faire une séance
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Header avec informations -->
        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-user text-info fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 text-dark">{{ $candidat->user->fullName() }}</h5>
                        <small class="text-muted">
                            <span class="badge bg-secondary me-1">{{ $candidat->user->mecano }}</span>
                            <span>{{ $candidat->phone_number }}</span>
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        <div class="badge bg-info fs-6 px-3 py-2">
                            {{ $prepaentretiens->count() }}
                        </div>
                        <small class="text-muted d-block">Séances</small>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-warning fs-6 px-3 py-2">
                            {{ $prepaentretiens->whereNotNull('commentaire')->count() }}
                        </div>
                        <small class="text-muted d-block">Commentaires</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des séances -->
        <div class="bg-white rounded-3 shadow-sm">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prepaentretiens as $prepaentretien)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{ dateFr($prepaentretien->date,'letter') }}</td>
                                <td style="text-align: center">
                                    <!-- <a href="{{ asset($prepaentretien->rapport) }}" download><i class="bx bx-cloud-download fs-2"></i></a> -->
                                    @if ($prepaentretien->commentaire != null)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#commentModal{{$prepaentretien->id}}" class="badge bg-warning mb-2">Voir
                                        commentaire</a>
                                    <div id="commentModal{{$prepaentretien->id}}" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Commentaire de la séance</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="#" method="POST" class="row g-3" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Commentaire: </label>
                                                                <textarea name="comment" class="form-control" id="" cols="10"
                                                                    rows="5" readonly>{{ $prepaentretien->commentaire }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-label-danger btn-reset" data-bs-dismiss="modal"
                                                            aria-label="Close">Retour</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <span class="text-muted">Aucun commentaire</span>
                                    @endif
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