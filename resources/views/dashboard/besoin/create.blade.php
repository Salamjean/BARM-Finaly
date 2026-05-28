@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-10 mx-auto">

            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande de consommable/</span> Faire une demande
            </h4>

            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">Faire une demande de consommable</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('besoins.store') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="col-md-12 mb-10">
                                <label for="libelle" class="form-label">Titre de la demande : </label>
                                <input type="text" class="form-control @error('libelle') is-invalid @enderror"
                                    id="libelle" placeholder="Nom de besoin" name="libelle"
                                    value="{{ old('libelle') }}">
                                @error('libelle')
                                <span class="invalid-feedback" besoin="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            {{-- <div class="col-md-3 mb-10">
                                <label for="date" class="form-label">Période de la demande : </label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                    placeholder="Nom de besoin" name="date" value="{{ old('date') }}">
                                @error('date')
                                <span class="invalid-feedback" besoin="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> --}}
                            <input type="text" class="form-control  is-invalid " placeholder="Nom de besoin"
                                name="user_id" value="{{Auth::user()->id}}" hidden>

                            <div class="col-md-9 mb-3">
                                <label class="form-label">Consommable :</label>
                                <select class="form-select select2" data-placeholder="Choisir un consommable" name="besoinitems[0][consommable_id]">
                                    @foreach($consommables as $consommable)
                                    <option value="{{ $consommable->id }}">{{ $consommable->designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">Quantité demandé</label>
                                    <input class="form-control quantite" type="number" name="besoinitems[0][qte_demande]"
                                        value="1" required />
                                    <div class="invalid-feedback">Quantité requis</div>
                                </div>
                            </div>
                            <div class="col-1"  style="margin-top:2.5rem">
                                <button type="button"
                                    class="btn btn-primary border-info text-white add__items__btn fs-4"><i
                                        class='bx bx-plus'></i></button>
                            </div>
                            <div id="items__enfant"></div>


                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                <a href="{{ route('besoins.index') }}" type="reset"
                                    class="btn btn-danger px-4">Annuler</a>
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
            var rowIndex = 1;

            function addItems() {
                $('#items__enfant').append(`<div class="row">
                    <div class="col-md-9">
                        <label class="form-label">Consommable :</label>
                        <select class="form-select select2" data-placeholder="Choisir un consommable" name="besoinitems[${rowIndex}][consommable_id]">
                            @foreach($consommables as $consommable)
                            <option value="{{ $consommable->id }}">{{ $consommable->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <div class="mb-3">
                            <label class="form-label">Quantité demandé</label>
                            <input class="form-control quantite" type="number" name="besoinitems[${rowIndex}][qte_demande]" value="1" />
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
