@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">

            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande de consommable/</span> Enregister un consommable
            </h4>

            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Enregister un consommable</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('consommables.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-10">
                            <label for="designation" class="form-label">Designation : </label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" placeholder="Nom du consommable" name="designation" value="{{ old('designation') }}">
                            @error('designation')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-10">
                            <label for="qte_disponible" class="form-label">Quantité disponible : </label>
                            <input type="number" class="form-control @error('qte_disponible') is-invalid @enderror" id="qte_disponible" placeholder="Quantité disponible" name="qte_disponible" value="{{ old('qte_disponible') }}">
                            @error('qte_disponible')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-10">
                            <label for="description" class="form-label">Description : </label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="Description"></textarea>
                            @error('description')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('consommables.index') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

