@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card mb-4">
            <h5 class="card-header">Ajout d'un membre</h5>

            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Nom & Prénoms<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="name" name="name" placeholder=""
                                required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="job" class="form-label">Proféssion<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="job" name="job" placeholder=""
                                required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="images" class="form-label">IMAGE<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="images" name="image"
                                accept=".jpeg, .png, .jpg" required />
                        </div>
                        <div class="mb-6 col-md-6">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_fb" class="form-label">Lien facebook</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxl-facebook-circle'></i></span>
                                <input type="text" class="form-control" name="link_fb" id="link_fb" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_x" class="form-label">Lien x</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxl-xing'></i></span>
                                <input type="text" class="form-control" name="link_x" id="link_x"  />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_linkedin" class="form-label">Lien linkedIn</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxl-linkedin' ></i></span>
                                <input type="text" class="form-control" name="link_linkedin" id="link_linkedin"  />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_insta" class="form-label">Lien instagram</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxl-instagram-alt' ></i></span>
                                <input type="text" class="form-control" name="link_insta" id="link_insta"  />
                            </div>
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
