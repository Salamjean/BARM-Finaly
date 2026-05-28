@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card mb-4">
            <h5 class="card-header">Edition d'une actualité</h5>

            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('ad.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="title" class="form-label">Titre<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="title" name="title"
                                placeholder="Visite du Directeur..." value="{{ $ad->title }}" required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="images" class="form-label">IMAGES<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="images" name="images[]" accept=".jpeg, .png, .jpg" multiple
                                 />
                        </div>
                        <div class="mb-6 col-md-12">
                            <label for="description" class="form-label">DESCRIPTION</label>
                            <textarea class="form-control" type="text" id="description" name="description" rows="10"
                                placeholder="Description de l'evenement..."  >{{ $ad->description }}</textarea>
                        </div>


                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Modifier</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>

    </div>
@endsection
