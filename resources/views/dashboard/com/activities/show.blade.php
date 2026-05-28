@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Activités ></span> {{$title}}
            </h4>

            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="card-header">DETAILS D'UNE ACTIVITE
                        <div class="mb-0 text-end">
                            <span class="badge bg-label-secondary">
                                <small>{{$activities->status}} - {{ dateFormat($activities->updated_at) }}</small>
                            </span>
                        </div>
                    </h5>
                </div>
                <div class="row"><br></div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{route('activities.update',  $activities->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="title" class="form-label fw-bold">Activité à réaliser :</label>
                                <p>
                                   &bull; {{ $activities->title }}
                                </p>
                            </div>
                            <div class="col-md-8">
                                <label for="objectifs" class="form-label fw-bold">Objectifs :</label>
                                <p>
                                    &bull; {{ $activities->objectifs }}
                                </p>
                            </div>
                        </div>
                        <div class="row mt-3">

                                <div class="col-md-4">
                                    <label for="cible" class="form-label fw-bold">Cible :</label>
                                    <p>
                                        &bull; {{ $activities->cible }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label for="canal" class="form-label fw-bold">Canal de diffusion :</label>
                                    <p>
                                        &bull; {{ $activities->canal }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label for="periode" class="form-label fw-bold">Période :</label>
                                    <p>
                                        &bull; {{ $activities->periode }}
                                    </p>
                                </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label for="budget" class="form-label fw-bold">Estimation budgetaire :</label>
                                <p>
                                    &bull; {{ $activities->budget }} Fcfa
                                </p>
                            </div>
                            <div class="col-md-4">
                                <div class="content-header mb-3">
                                    <label class="form-label fw-bold" for="source">Source de financement :</label>
                                    <p>
                                        &bull; {{ $activities->source }}
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 form-group">
                                <label for="observations" class="form-label">Observations :</label>
                                    <textarea type="text" rows="5" class="form-control" id="observations" placeholder="Détails de l'information" name="observations" readonly>{{ $activities->observations }}</textarea>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <a href="{{route('activities.list')}}" type="reset" class="btn btn-secondary px-4">Retour</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
