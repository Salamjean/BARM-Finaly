@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Informations /</span> {{$title}}
            </h4>
            <div class="card">

                <div class="card-body p-4">
                    <form id="informationForm" class="row g-3" method="POST" action="{{route('info.info-store')}}" enctype="multipart/form-data">
                        @csrf
                    @if (can('responsable-communication'))
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Titre de l'information" name="title" value="{{ old('title') }}"/>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="lieu_service" class="form-label">Cellule</label>
                        <select class="form-select select2" id="roles" name="destinataire">
                            <option selected disabled>Selectionner</option>

                            @foreach ($rolesAfterId4 as $role)
                                <option value="{{ $role->slug }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div class="col-md-12">
                        <label for="nom" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Titre de l'information" name="title" value="{{ old('title') }}"/>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @endif
                        <div class="col-md-12 form-group">
                            <label for="contenu" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea type="text" rows="5" class="form-control @error('contenu') is-invalid @enderror" id="contenu" placeholder="Détails de l'information" name="contenu" value="{{ old('contenu') }}"></textarea>
                            @error('contenu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        @if (can('responsable-communication'))
                        <div class="col-md-12">
                            <label for="formFile" class="form-label label">Pièce justificative</label>
                            <div class="input-group">
                                    <input class="form-control fileAttachment" type="file" name="fileAttachment" id="fileAttachment" accept=".pdf">
                                </div>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{route('info.histo')}}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
