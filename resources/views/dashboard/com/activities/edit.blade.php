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
                    <h5 class="mb-0">MODIFICATION D'UNE ACTIVITE</h5>
                </div>
                <div class="row"><br></div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{route('activities.update',  $activities->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="title" class="form-label">Activité à réaliser <span class="text-danger">*</span></label>
                                    <textarea type="text" rows="3" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Titre" name="title">{{ $activities->title }}</textarea>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label for="objectifs" class="form-label">Objectifs <span class="text-danger">*</span></label>
                                    <textarea type="text" rows="3" class="form-control @error('objectifs') is-invalid @enderror" id="objectifs" placeholder="Ajouter un objectif" name="objectifs">{{ $activities->objectifs }}</textarea>
                                @error('objectifs')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">

                                <div class="col-md-4">
                                    <label for="cible" class="form-label">Cible<span class="text-danger"> *</span></label>
                                    <select id="cible" class="select2 form-select @error('cible') is-invalid @enderror" data-placeholder="Choisir un ou plusieurs cible(s)" multiple name="cible[]">
                                        @foreach (CIBLES as $cible)
                                            <option value="{{ $cible }}" {{ isset($activities->cible) && is_string($activities->cible) && collect(explode(',', $activities->cible))->contains($cible)? 'selected' : '' }}>{{ $cible }}</option>
                                        @endforeach
                                    </select>
                                    @error('cible')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="canal" class="form-label">Canal de diffusion<span class="text-danger"> *</span></label>
                                    <select id="canal" class="select2 form-select @error('canal') is-invalid @enderror" data-placeholder="Choisir un ou plusieurs canal(aux)" multiple name="canal[]">
                                        @foreach ( CANAUX as $canal )
                                            <option value="{{ $canal }}" {{ isset($activities->canal) && is_string($activities->canal) && collect(explode(',', $activities->canal))->contains($canal)? 'selected' : '' }}>{{ $canal }}</option>
                                        @endforeach
                                    </select>
                                    @error('canal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="periode" class="form-label">Période<span class="text-danger"> *</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('periode') is-invalid @enderror" id="periode" name="periode" value="{{ $activities->periode }}" placeholder="Janvier-Mars 2023">
                                        @error('periode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label for="budget" class="form-label">Estimation budgetaire<span class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('budget') is-invalid @enderror" id="budget" name="budget" value="{{ $activities->budget }}" placeholder="Préciser le budget (F cfa)">
                                    @error('budget')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="content-header mb-3">
                                    <label class="form-label" for="source-financement">Source de financement</label>
                                    <div class="col @error('source') is-invalid @enderror">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="source" class="form-check-input" id="autre-financement" value="Autre financement"
                                                   {{ $activities->source == 'Autre financement'? 'checked' : '' }}>
                                            <label class="form-check-label" for="autre-financement">Autre financement</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="source" class="form-check-input" id="ressource-projet" value="Ressource projet"
                                                   {{ $activities->source == 'Ressource projet'? 'checked' : '' }}>
                                            <label class="form-check-label" for="ressource-projet">Ressource projet</label>
                                        </div>
                                        @error('source')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 form-group">
                                <label for="observations" class="form-label">Observations <span class="text-danger">*</span></label>
                                    <textarea type="text" rows="5" class="form-control @error('observations') is-invalid @enderror" id="observations" placeholder="Détails de l'information" name="observations">{{ $activities->observations }}</textarea>
                                @error('observations')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                    <a href="{{route('activities.list')}}" type="reset" class="btn btn-danger px-4">Annuler</a>
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
