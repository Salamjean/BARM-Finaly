@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Modifier</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="active" aria-current="page">Modifier une permission</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('permissions.index') }}" type="button" class="btn btn-primary">Voir la liste</a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Modifier la permission</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('permissions.update', $permission->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mb-10">
                            <label for="name" class="form-label">Nom : </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nom de permission" name="name" value="{{ old('phone') ?? $permission->name }}">
                            @error('name')
                            <span class="invalid-feedback" permission="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                <button type="reset" class="btn btn-danger px-4">Annuler</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
</div>
@endsection
