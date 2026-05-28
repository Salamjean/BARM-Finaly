@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">

            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande de consommable/</span> Voir la demande
            </h4>

            <div class="card">
                {{-- <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Faire une demande de consommable</h5>
                </div> --}}

                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('besoins.update', $besoin->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12 mb-10">
                            <label for="libelle" class="form-label">Titre de la demande : </label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                                placeholder="Nom de besoin" name="libelle" value="{{ $besoin->libelle }}" readonly>
                            @error('libelle')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-10">
                            <label for="date" class="form-label">Date de la demande : </label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                                placeholder="Nom de besoin" name="date" value="{{ dateFr($besoin->created_at) }}" readonly>
                            @error('date')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        @if ($besoin->status == 'pending')
                        <div class="col-md-6 mb-10">
                            <label for="date" class="form-label">Status : </label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Nom de besoin"
                                name="date" value="En attente" readonly>
                            @error('date')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @elseif($besoin->status == 'validated')
                        <div class="col-md-6 mb-10">
                            <label for="date" class="form-label">Status : </label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Nom de besoin"
                                name="date" value="Validé" readonly>
                            @error('date')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @elseif($besoin->status == 'refused')
                        <div class="col-md-6 mb-10">
                            <label for="date" class="form-label">Status : </label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Nom de besoin"
                                name="date" value="Refusé" readonly>
                            @error('date')
                            <span class="invalid-feedback" besoin="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endif
                        
                        <input type="text" class="form-control  is-invalid " placeholder="Nom de besoin" name="user_id"
                            value="{{$besoin->user_id}}" hidden>

                        @foreach ($besoin->besoinitems as $key=>$besoinitem)
                            <div class="col-8">
                                <div class="mb-3">
                                    <label class="form-label">Consommable</label>
                                    <input class="form-control" placeholder="Consommable" type="text"
                                        name="besoinitems[{{ $key }}][consommable_id]" value="{{$besoinitem->consommable->designation}}"
                                        required readonly />
                                    <div class="invalid-feedback">Consommable requis</div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">Quantité demandé</label>
                                    <input class="form-control quantite" type="number"
                                        name="besoinitems[{{ $key }}][qte_demande]" value="{{$besoinitem->qte_demande}}"
                                        required readonly/>
                                    <div class="invalid-feedback">Quantité requis</div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">Quantité reçue</label>
                                    <input class="form-control quantite" type="number" name="besoinitems[{{ $key }}][qte_recue]"
                                        value="{{$besoinitem->qte_recue}}" readonly
                                    required />
                                    <div class="invalid-feedback">Quantité requis</div>
                                </div>
                            </div>
                            {{-- @if ($besoin->status != 'pending')
                                <div class="col-2" style="margin-top:2.5rem">
                                    <div class="mb-3">
                                        @if ($besoinitem->disponible == '1')
                                            <button type="button" class="btn btn-success">Disponible</button>
                                        @elseif ($besoinitem->disponible == '0')
                                            <button type="button" class="btn btn-success">Indisponible</button>
                                        @endif
                                    </div>
                                </div>
                            @endif --}}
                        @endforeach

                        {{-- @if ($besoin->status != 'pending')
                            <div class="col-md-12 mb-10">
                                <label for="commentaire" class="form-label">Commentaire : </label>
                                <textarea class="form-control @error('commentaire') is-invalid @enderror" name="commentaire" id="commentaire"
                                    rows="5">{{ $besoin->commentaire }}</textarea>
                                @error('commentaire')
                                <span class="invalid-feedback" besoin="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endif --}}
                        

                        <div class="col-md-12">
                                <a href="{{ route('besoins.index') }}" type="reset"
                                    class="btn btn-danger px-4">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('js-push')
<script>
    $(document).ready(function () {
            "use strict";
            // Add item handler
            $('.add__items__btn').click(function () {
                addItems();
            });


            // Add item function
            var rowIndex = {{$key}}+1;

            function addItems() {
                $('#items__enfant').append(`<div class="row">
                    <div class="col-9">
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input class="form-control" placeholder="Description" type="text" name="besoinitems[${rowIndex}][designation]" required />
                            <div class="invalid-feedback">Description requis</div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-3">
                            <label class="form-label">Quantité demandé</label>
                            <input class="form-control quantite" type="number" name="besoinitems[${rowIndex}][qte_demande]" value="1" required />
                            <div class="invalid-feedback">Quantité requis</div>
                        </div>
                    </div>
                    <div class="col-1" style="margin-top:1.5rem">
                        <button type="button" class="btn btn-danger border-danger text-white remove__item__btn fs-4">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>`);

                rowIndex++;

                // Remove item handler
                $(document).on('click', '.remove__item__btn', function () {
                    $(this).closest(".row").remove();
                });
            }

        });
</script>
@endpush