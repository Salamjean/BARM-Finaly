@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card mb-4">
            <h5 class="card-header">Ajout d'une actualité</h5>

            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('ad.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="title" class="form-label">Titre<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="title" name="title"
                                placeholder="Visite du Directeur..." required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="images" class="form-label">IMAGES<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="images" name="images[]" accept=".jpeg, .png, .jpg" multiple
                                required />
                        </div>
                        <div class="mb-6 col-md-12">
                            <label for="description" class="form-label">DESCRIPTION</label>
                            <textarea class="form-control" type="text" id="description" name="description" rows="10"
                                placeholder="Description de l'evenement..."  ></textarea>
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
