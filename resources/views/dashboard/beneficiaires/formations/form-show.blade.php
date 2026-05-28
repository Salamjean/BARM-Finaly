@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Formations /</span>{{$title}}
        </h4>
        <div class="row gy-4">
            <div class="col-xl-3 col-lg-4 col-md-4 order-1 order-md-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <img class="img-fluid rounded my-4" src="../../assets/img/avatars/avatar.png" height="110"
                                    width="110" alt="User avatar" />
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{ $candidats->user->fullName() }}</h5>
                                    <span class="badge bg-label-secondary">{{$candidats->no_card}}</span>
                                </div>
                            </div>
                        </div>

                        <h5 class="pb-2 border-bottom mt-4"></h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Né(e) le :</span>
                                    <span>{{ date('d/m/Y', strtotime($candidats->birth_date)) }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Genre :</span>
                                    <span>{{$candidats->gender}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Telephone :</span>
                                    <span>{{$candidats->phone_number}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Status :</span>
                                    <span
                                        class="badge {{ $candidats->status == 'accepted' ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $candidats->status == 'accepted' ? 'Actif' : 'Inactif' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8 order-0 order-md-1">
                <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init
                            class="nav-link {{ (Session::get('step') ?? 'profile') == 'profile' ? 'active' : '' }}"
                            id="ex-with-icons-tab-1" href="#ex-with-icons-tabs-1" role="tab"
                            aria-controls="ex-with-icons-tabs-1" aria-selected="true"><i
                                class="bx bx-user me-1"></i>Informations formations</a>
                    </li>
                  </ul>
                <div class="tab-content" id="ex-with-icons-content">
                    <div class="tab-pane fade {{ (Session::get('step') ?? 'profile') == 'profile' ? 'show active' : '' }}"
                        id="ex-with-icons-tabs-1" role="tabpanel" aria-labelledby="ex-with-icons-tab-1">
                        <div class="card mb-2">
                            <h5 class="card-header pb-0 text-uppercase">Détails &bull; <span class="badge bg-label-warning">{{ $candidats->formationBeneficiaire->reference }}</span></h5>
                            <form class="row g-3" method="POST" action="{{route('beneficiaire.formRequestUpdate')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="table-responsive">
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <ul class="list-unstyled">
                                                <li class="mb-1">
                                                    <span class="fw-bold me-2">Référence :</span>
                                                    <span>{{ $candidats->formationBeneficiaire->reference }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                                    <span class="fw-bold me-2">Orientation :</span>
                                                    <span>{{ $candidats->formationBeneficiaire->orientation }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                                    @if ($candidats->formationBeneficiaire->formation == 'Oui')
                                                        <span class="fw-bold me-2">Date début :</span>
                                                        <span>{{ date('d/m/Y', strtotime($candidats->formationBeneficiaire->date_debut)) }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                                        <span class="fw-bold me-2">Date fin :</span>
                                                        <span>{{ date('d/m/Y', strtotime($candidats->formationBeneficiaire->date_fin)) }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                                        <span class="fw-bold me-2">Durée :</span>
                                                        <span>{{ $candidats->formationBeneficiaire->periode }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                                        <span class="fw-bold me-2">Lieu :</span>
                                                        <span>{{ $candidats->formationBeneficiaire->lieu_form }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                                        <span class="fw-bold me-2">Enregistré par :</span>
                                                        <span class="badge bg-label-danger">{{ $candidats->formationBeneficiaire->operateur->username }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                                        <span class="fw-bold me-2">Partenaire :</span>
                                                        <span class="badge bg-label-info">{{ $candidats->formationPartenaire->user->username }}</span>
                                                    @endif
                                                </li>
                                            </ul>
                                            <div class="col-md-6">
                                                <label for="description" class="form-label">Description du projet</label>
                                                <textarea name="description" id="description" class="form-control" rows="5" readonly>{{ $candidats->formationBeneficiaire->description }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="observation" class="form-label">Observation</label>
                                                <textarea name="observation" id="observation" class="form-control" rows="5" readonly>{{ $candidats->formationBeneficiaire->observation }}</textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <a href="{{ asset('assets/faces/pj/' . $candidats->formationBeneficiaire->file_attachment1) }}" class="btn btn-xm btn-primary btn-rounded" title="Télécharger le plan d'affaire" download="{{ $candidats->formationBeneficiaire->file_attachment1 }}"><i class="fas fa-download">&nbsp;</i>Télécharger le plan d'affaire</a>
                                            </div>
                                            @if ($candidats->formationBeneficiaire->formation != 'Oui')
                                                <div class="col-md-12">
                                                    <label for="reason" class="form-label">Motif/Raison</label>
                                                    <textarea name="reason" id="reason" class="form-control" rows="5" readonly>{{ $candidats->formationBeneficiaire->reason }}</textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <a href="{{ asset('assets/faces/pj/' . $candidats->formationBeneficiaire->file_attachment2) }}" class="btn btn-xm btn-outline-primary btn-rounded" title="Télécharger le plan d'affaire" download="{{ $candidats->formationBeneficiaire->file_attachment2 }}"><i class="fas fa-paperclip"></i></a>
                                                </div>
                                            @endif

                                                {{-- <div class="col-md-12">
                                                    <label for="formFile" class="form-label">Insérer Plan d'affaire</label>
                                                    <div class="input-group">
                                                        <input class="form-control @error('fileAttachment1') is-invalid @enderror" type="file" name="fileAttachment1" id="fileAttachment1" accept=".pdf, .png, .jpeg, .jpg">
                                                        @error('fileAttachment1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-6">
                                                    <div class="form-check form-switch mb-2">
                                                      <input class="form-check-input" name="validation_pa" type="checkbox" id="validation_pa">
                                                      <label class="form-check-label" for="validation_pa">Validation du plan d'affaire</label>
                                                    </div>
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" name="approbation_pa" type="checkbox" id="approbation_pa">
                                                        <label class="form-check-label" for="approbation_pa" >Approbation par le comité de crédit</label>
                                                      </div>
                                              </div>
                                              <div class="col-md-6">
                                                <label for="form_status" class="form-label">Status de la formation<span class="text-danger"> *</span></label>
                                                <select class="form-select @error('form_status') is-invalid @enderror" aria-label="Type de la demande" name="form_status" required>
                                                    <option value="En cours" {{ old('form_status') == 'En cours' ? 'selected' : '' }}>En cours</option>
                                                    <option value="Suspendue" {{ old('form_status') == 'Suspendue' ? 'selected' : '' }}>Suspendue</option>
                                                    <option value="Archivé" {{ old('form_status') == 'Archivé' ? 'selected' : '' }}>Archivé</option>
                                                    <option value="Terminé" {{ old('form_status') == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                                                </select>
                                                @error('form_status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                                <div class="row mt-3">
                                                    <input type="hidden" name="id" value="@isset($candidats->id){{ $candidats->id }}@endisset">
                                                    <div class="col-md-12">
                                                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                                            <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                                            <a href="{{ route('beneficiaire.formRequest') }}" type="reset" class="btn btn-secondary px-4">Annuler</a>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ User Content -->
        </div>
    </div>
    @push('js-push')
    <script type="text/javascript" src="{{ asset('assets/js/mdb.umd.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#validation_pa').val('validé');
            $('#approbation_pa').val('approuvé');
        });
        </script>

    @endpush
@endsection
