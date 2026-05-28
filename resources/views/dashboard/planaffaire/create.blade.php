@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Plan d'affaires /</span> Créer un plan d'affaire
            </h4>
            <div class="card">

                <div class="card-body p-4">
                    <form id="formationForm" class="row g-3" method="POST" action="{{ route('plan_affaire.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-3 form-group">
                            <label for="plan" class="form-label">Plan d'affaires: </label>
                                <input type="file" class="form-control @error('plan') is-invalid @enderror" id="" placeholder="Plan d'affaires" name="plan" value="{{ old('plan') }}"/>
                            @error('plan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="candidature_id" class="form-label">Nom du candidats : </label>
                                <select class="form-control @error('candidature_id') is-invalid @enderror" name="candidature_id">
                                    <option value="" selected disabled>Selectionner....</option>
                                    @foreach($candidatures as $candidature)
                                    <option value="{{$candidature->id}}">{{$candidature->user->fullName()}}</option>
                                    @endforeach
                                </select>
                            @error('candidature_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('plan_affaire.index') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
