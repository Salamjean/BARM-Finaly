@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Archives /</span> Créer un archive
            </h4>
            <div class="card">
                
                <div class="card-body p-4">
                    <form id="formationForm" class="row g-3" method="POST" action="{{ route('archive.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6 mb-3 form-group">
                            <label for="dossier_id" class="form-label">Reseau Social : </label>
                                <select class="form-control @error('dossier_id') is-invalid @enderror" name="dossier_id">
                                    <option value="" selected disabled>Selectionner....</option>
                                    @foreach($dossiers as $dossier)
                                    <option value="{{$dossier->id}}">{{$dossier->nom}}</option>
                                    @endforeach
                                </select>
                            @error('reseauSocial_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="date_publication" class="form-label">Date de publication: </label>
                                <input type="date" class="form-control @error('date_publication') is-invalid @enderror" id="" placeholder="Date de publication" name="date_publication" value="{{ old('date_publication') }}"/>
                            @error('date_publication')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="titre" class="form-label">Titre: </label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="" placeholder="Entrer le titre" name="titre" value="{{ old('titre') }}"/>
                            @error('titre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="image" class="form-label">Image: </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="" placeholder="image" name="image" value="{{ old('image') }}"/>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3 form-group">
                            <label for="description" class="form-label">Description: </label>
                                <textarea type="description" cols="5" rows="5" class="form-control @error('description') is-invalid @enderror" id="" placeholder="Description" name="description" value="{{ old('description') }}">
                                </textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('archive.liste') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
