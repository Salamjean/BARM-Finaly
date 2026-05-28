@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande ></span> Afficher une demande
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0 text-uppercase">DETAILS DE LA DEMANDE DE {{$leaves->leave_type}} <span class="text-uppercase text-muted"> &bull; {{$leaves->user->fullName()}}</span></h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('demande.updatePersonnelLeave') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div><br></div>
                            <ul class="list-unstyled">
                                <li class="mb-1">
                                    <span class="fw-bold me-2">&bull;&nbsp;&nbsp;Type de la demande :</span>
                                    <span class="badge bg-label-primary">{{ $leaves->leave_type }}</span>&nbsp;&nbsp;<br>&bull;&nbsp;&nbsp;
                                    <span class="fw-bold me-2">Date départ :</span>
                                    <span>{{ date('d/m/Y', strtotime($leaves->leavefrom)) }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                    <span class="fw-bold me-2">Date retour :</span>
                                    <span>{{ date('d/m/Y', strtotime($leaves->leaveto)) }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
                                    <span class="fw-bold me-2">Nbre de jours :</span>
                                    <span class="badge bg-label-warning">{{ $leaves->nb_day }}</span>&nbsp;&nbsp;<br>&bull;&nbsp;&nbsp;
                                    <span class="fw-bold me-2">Date reprise :</span>
                                    <span class="badge bg-label-info">{{ date('d/m/Y', strtotime($leaves->returndate)) }}</span>&nbsp;&nbsp;<br>
                                </li>
                            </ul>
                        </div>
                        @if ($leaves->leave_type == 'Congé')
                            <div class="row" style="display: none"></div>
                            @else
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="reason" class="form-label">Raisons/Motif</label>
                                    <div class="input-group">
                                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" placeholder="Préciser" name="reason" rows="5" readonly>{{ old('reason') ?? $leaves->reason }}</textarea>
                                    </div>
                                    @error('reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                                </div>
                            </div>
                        @endif
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="status" class="form-label">Statut</label>
                                <select name="status" id="statusSelect" class="form-select">
                                    <option value="" disabled selected>Préciser</option>
                                    <option value="Approuvé" @if($leaves->status == 'Approuvé') selected @endif>Avis favorable</option>
                                    <option value="En attente" @if($leaves->status == 'En attente') selected @endif>En attente</option>
                                    <option value="Réjeté" @if($leaves->status == 'Réjeté') selected @endif>Réjeté</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2" id="commentDiv" style="display: none" @if ($leaves->status == 'Réjeté') readonly @else autofocus @endif>
                            <div class="col-md-12">
                                <label for="comment" class="form-label">Commentaire</label>
                                <div class="input-group">
                                    <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" placeholder="Ajouter un commentaire" name="comment" rows="5" autofocus>{{ old('comment') ?? $leaves->comment }}</textarea>
                                </div>
                                @error('comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="footer">
                                <input type="hidden" name="id" value="@isset($leaves->id){{ $leaves->id }}@endisset">
                                @if($leaves->status == 'Réjeté')
                                    <a href="{{ route('demande.PersonelLeave') }}" class="btn btn-secondary">
                                        <span class="button-with-icon">Annuler</span>
                                    </a>
                                    @else
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                    <a href="{{ route('demande.PersonelLeave') }}" class="btn btn-secondary">
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

                if ($(this).val() === 'Réjeté') {

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
