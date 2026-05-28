@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Personnels/</span> Détail du personnel
                </h4>
                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">Détail du personnel</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3">

                            <div class="col-md-12 mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur : </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bx-at'></i></span>
                                    <input type="text" class="form-control border-start-0"
                                        value="{{ $personal->username }}" disabled />
                                </div>

                            </div>

                            <div class="col-md-6">
                                <label for="firstname" class="form-label">Prénom(s)</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text" class="form-control border-start-0"
                                        value="{{ $personal->firstname }}" disabled />
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Nom </label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                    <input type="text" class="form-control border-start-0"
                                        value="{{ $personal->lastname }}" disabled />
                                </div>

                            </div>
                            <div class="col-md-12">
                                <label for="phone" class="form-label">N° téléphone</label>
                                <div class="input-group"> <span class="input-group-text"><i class='bx bxs-phone'></i></span>
                                    <input type="text" class="form-control border-start-0"
                                        value="{{ $personal->phone }}" disabled />
                                </div>

                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">E-mail</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class='bx bxs-envelope'></i></span>
                                    <input type="text" class="form-control border-start-0" value="{{ $personal->email }}"
                                        disabled />
                                </div>

                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">Type de pièce</label>

                                <input type="text" class="form-control border-start-0"
                                    value="{{ $personal->type_piece }}" disabled />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="no_card" class="form-label">N° de la carte</label>
                                <input type="text" class="form-control" value="{{ $personal->no_card }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Date de naissance</label>
                                <input type="text" class="form-control " value="{{ $personal->birth_date }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Genre</label>
                                <input type="text" class="form-control " value="{{ $personal->gender }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Cellule</label>
                                <input type="text" class="form-control " value="{{ $personal->cell }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Poste</label>
                                @foreach (json_decode($personal->posts) as $post)
                                    <input type="text" class="form-control " value="{{ $post }}" disabled>
                                @endforeach
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
