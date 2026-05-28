@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card mb-4">
            <h5 class="card-header">Edition</h5>

            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Nom & Prénoms<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="name" name="name" placeholder=""
                                value="{{ $partner->name }}" required />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="images" class="form-label">IMAGE<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="images" name="image"
                                accept=".jpeg, .png, .jpg" required />
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
