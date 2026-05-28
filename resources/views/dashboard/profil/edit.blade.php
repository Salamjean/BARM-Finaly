@extends('layouts.app')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Utilisateur / Profil /</span> Compte utilisateur
        </h4>
        <div class="row gy-4">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <img class="img-fluid rounded my-4" src="../../assets/img/avatars/avatar.png" height="110"
                                    width="110" alt="User avatar" />
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{ Auth::user()->username }}</h5>
                                    @foreach (Auth::user()->permissions as $permission)
                                        <span class="badge bg-label-secondary">{{ $permission->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <h5 class="pb-2 border-bottom mt-4">Informations personnelles</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Username:</span>
                                    <span>{{ Auth::user()->username }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Email:</span>
                                    <span>{{ Auth::user()->email }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Status:</span>
                                    <span class="badge bg-label-success">Active</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">CELLULE:</span>
                                    <span>{{ roleFr(Auth::user()->roles->first()->name) }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Contact:</span>
                                    <span>{{ Auth::user()->phone }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">


                <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link active" id="ex-with-icons-tab-1" href="#ex-with-icons-tabs-1"
                            role="tab" aria-controls="ex-with-icons-tabs-1" aria-selected="true"><i
                                class="bx bx-user me-1"></i>Informations personnelles</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link" id="ex-with-icons-tab-2" href="#ex-with-icons-tabs-2"
                            role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false"><i
                                class="bx bx-lock-alt me-1"></i>Changer de mot de passe</a></a>
                    </li>
                </ul>

                <div class="tab-content" id="ex-with-icons-content">
                    <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                        aria-labelledby="ex-with-icons-tab-1">
                        <div class="card mb-4">
                            <h5 class="card-header">Informations personnelles</h5>
                            <div class="table-responsive mb-3">
                                <div class="card-body p-4">
                                    <form class="row g-3" method="POST"
                                        action="{{ route('profil.update', 'info') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-12 mb-3">
                                            <label for="username" class="form-label">Nom d'utilisateur : </label>
                                            <div class="input-group"> <span class="input-group-text"><i
                                                        class='bx bx-at'></i></span>
                                                <input type="text"
                                                    class="form-control @error('username') is-invalid @enderror border-start-0"
                                                    id="username" placeholder="Nom d'utilisateur" name="username"
                                                    value="{{ Auth::user()->username }}" @if(!auth()->user()->hasRole('admin')) readonly @endif />
                                            </div>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="firstname" class="form-label">Prénom(s)</label>
                                            <div class="input-group"> <span class="input-group-text"><i
                                                        class='bx bxs-user'></i></span>
                                                <input type="text" class="form-control border-start-0" id="firstname"
                                                    placeholder="Prénom(s)" name="firstname"
                                                    value="{{ Auth::user()->firstname }}" @if(!auth()->user()->hasRole('admin')) readonly @endif />
                                            </div>
                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname" class="form-label">Nom </label>
                                            <div class="input-group"> <span class="input-group-text"><i
                                                        class='bx bxs-user'></i></span>
                                                <input type="text" class="form-control border-start-0" id="lastname"
                                                    placeholder="Nom" name="lastname"
                                                    value="{{ Auth::user()->lastname }}" @if(!auth()->user()->hasRole('admin')) readonly @endif />
                                            </div>
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-md-12">
                                            <label for="phone" class="form-label">N° téléphone</label>
                                            <div class="input-group"> <span class="input-group-text"><i
                                                        class='bx bxs-phone'></i></span>
                                                <input type="text" class="form-control border-start-0" id="phone"
                                                    placeholder="N° de telephone" name="phone"
                                                    value="{{ Auth::user()->phone }}" />
                                            </div>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}
                                        <div class="col-md-12">
                                            <label for="email" class="form-label">E-mail</label>
                                            <div class="input-group"> <span class="input-group-text"><i
                                                        class='bx bxs-envelope'></i></span>
                                                <input type="text" class="form-control border-start-0" id="email"
                                                    placeholder="Adresse mail" name="email"
                                                    value="{{ Auth::user()->email }}" @if(!auth()->user()->hasRole('admin')) readonly @endif />
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                                <button type="reset" class="btn btn-danger px-4">Annuler</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel"
                        aria-labelledby="ex-with-icons-tab-2">
                        <div class="card mb-4">
                            <h5 class="card-header">Change de mot de passe</h5>
                            <div class="card-body">
                                <form method="POST" action="{{ route('profil.update', 'password') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="alert alert-warning" role="alert">
                                        <h6 class="alert-heading mb-1">Veiller à ce que ces exigences soient respectées
                                        </h6>
                                        <span>Minimum de 4 caractères, majuscules et symboles</span>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <label for="email" class="form-label">E-mail</label>
                                            <div class="input-group"> <span class="input-group-text"><i
                                                        class='bx bxs-envelope'></i></span>
                                                <input type="text" class="form-control border-start-0" id="email"
                                                    placeholder="Adresse mail" name="email"
                                                    value="{{ Auth::user()->email }}" readonly />
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                            <label class="form-label" for="password">Nouveau mot de passe</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="password" id="password"
                                                    name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                            <label class="form-label" for="confirm_password">Confirmer mot de
                                                passe</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="password" name="password_confirmation"
                                                    id="confirm_password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary me-2">Changer le mot de
                                                passe</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <!--/ User Content -->
        </div>
    </div>



    <script type="text/javascript" src="{{ asset('assets/js/mdb.umd.min.js') }}"></script>
@endsection
