@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">PLAN D'AFFAIRE ></span> Afficher un plan d'affaire
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0 text-uppercase">DETAILS DU PLAN D'AFFAIRE <span class="text-uppercase text-muted">&bull; {{$planaffaire->candidature->user->firstname}} {{$planaffaire->candidature->user->lastname}}</span></h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('plan_affaire.update',$planaffaire->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div><br></div>
                            <ul class="list-unstyled">
                                <li class="mb-1">
                                    <span class="fw-bold me-2">&bull;&nbsp;&nbsp;Nom du Candidat :</span>
                                    <span class="badge bg-label-primary">{{$planaffaire->candidature->user->firstname}} {{$planaffaire->candidature->user->lastname}}</span>&nbsp;&nbsp;<br><br>&bull;&nbsp;&nbsp;
                                    <span class="fw-bold me-2">Plan d'affaire :</span>
                                    <span><a href="{{ asset('assets/plans/' . $planaffaire->plan) }}" class="btn btn-outline-primary btn-sm btn-rounded" title="Télécharger le plan d'affaire" download="{{ $planaffaire->plan }}"><i class="fas fa-eye">  Voir plan d'affaire</i></a></span>
                                    <br><br>&bull;&nbsp;&nbsp;
                                    <span class="fw-bold me-2">Date :</span>
                                    <span class="badge bg-label-info">{{ date('d/m/Y', strtotime($planaffaire->created_at)) }}</span>&nbsp;&nbsp;<br>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="status" class="form-label">Statut</label>
                                <select name="status" id="statusSelect" class="form-select">
                                    <option value="" disabled selected>Préciser</option>
                                    <option value="accepted" @if($planaffaire->status == 'accepted') selected @endif>Valider</option>
                                    <option value="En cours" @if($planaffaire->status == 'En cours') selected @endif>En cours</option>
                                    <option value="refused" @if($planaffaire->status == 'refused') selected @endif>Refuser</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2" id="commentDiv" style="display: none" @if ($planaffaire->status == 'refused') readonly @else autofocus @endif>
                            <div class="col-md-12">
                                <label for="commentaire" class="form-label">Commentaire</label>
                                <div class="input-group">
                                    <textarea class="form-control @error('commentaire') is-invalid @enderror" id="comment" placeholder="Ajouter un commentaire" name="commentaire" rows="5" autofocus>{{ old('commentaire') ?? $planaffaire->commentaire }}</textarea>
                                </div>
                                @error('commentaire')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="footer">
                                <input type="hidden" name="id" value="@isset($planaffaire->id){{ $planaffaire->id }}@endisset">
                                @if($planaffaire->status == 'refused')
                                    <a href="{{ route('plan_affaire.index') }}" class="btn btn-secondary">
                                        <span class="button-with-icon">Annuler</span>
                                    </a>
                                    @else
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                    <a href="{{ route('plan_affaire.index') }}" class="btn btn-secondary">
                                        <span class="button-with-icon">Annuler</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js-push')
    <script>
        $(document).ready(function() {

            $('#statusSelect').change(function() {

                if ($(this).val() === 'refused') {

                    $('#commentDiv').show();
                } else {
                    $('#commentDiv').hide();
                }
            });

            $('#statusSelect').change();
        });
    </script>
@endpush
@endsection
