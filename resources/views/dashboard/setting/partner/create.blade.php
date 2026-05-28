@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card mb-4">
            <h5 class="card-header">Ajout d'un partenaire</h5>

            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('partner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Nom du partenaire<span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="name" name="name" placeholder=""
                                required />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="images" class="form-label">IMAGE<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="images" name="image"
                                accept=".jpeg, .png, .jpg" required />
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Sauvegarder</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>

    </div>
@endsection
