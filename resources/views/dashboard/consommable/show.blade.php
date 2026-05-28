@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">

            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande de consommable/</span> Afficher le consommable
            </h4>

            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Afficher le consommable</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-10">
                            <label for="designation" class="form-label">Designation : </label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" placeholder="Nom du consommable" name="designation" value="{{ $consommable->designation }}" readonly>
                            @error('designation')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-10">
                            <label for="qte_disponible" class="form-label">Quantité disponible : </label>
                            <input type="text" class="form-control @error('qte_disponible') is-invalid @enderror" id="qte_disponible" placeholder="Quantité disponible" name="qte_disponible" value="{{ $consommable->qte_disponible }}" readonly>
                            @error('qte_disponible')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class=" pt-1 col-2 d-flex flex-column mb-10">
                            <label for="is_visible" class="form-label">Visibilité</label>
                            <label class="switch switch-success">
                                <input type="checkbox" class="switch-input" name="is_visible" {{ $consommable->is_visible == 1 ? 'checked' : '' }} />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on">
                                        <i class="bx bx-check"></i>
                                    </span>
                                    <span class="switch-off">
                                        <i class="bx bx-x"></i>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-10">
                            <label for="description" class="form-label">Description : </label>
                            <textarea name="Description" class="form-control @error('description') is-invalid @enderror" id="Description" readonly>{{$consommable->description}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <!-- <button type="submit" class="btn btn-primary px-4">Enregistrer</button> -->
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

