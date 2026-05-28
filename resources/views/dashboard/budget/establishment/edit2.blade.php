@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">

                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Etablir le budget annuel/</span> Etablir le budget de l'année
                </h4>

                <div class="card">
                    <div class="card-header px-4 py-3 border-bottom">
                        <h5 class="mb-0">Etablir le budget de l'année</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST"
                            action="{{ route('annual-budget.establishment.update.2', $establishment->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="http" class="form-control" value="put">

                            <div class="col-md-6 mb-10">
                                <label for="libelle" class="form-label">Titre: </label>
                                <input type="text" class="form-control"
                                    value="{{ $establishment->annualBudget->title }} " disabled>
                            </div>
                            <div class="col-md-5 mb-10">
                                <label for="" class="form-label">Cellule: </label>
                                <input type="text" class="form-control" disabled
                                    value="{{ (controllerPersonal($establishment->chief))->role->name }}">
                            </div>
                            <div class="col-md-1 mb-10">
                                <label for="" class="form-label">Année: </label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $establishment->annualBudget->year }}">
                            </div>
                            <div class="col-md-12 mb-10">
                                <label for="" class="form-label">Consigne ou Explication: </label>
                                <textarea name="description" id="" rows="10" class="form-control">{{ $establishment->description }}</textarea>
                            </div>
                            @php
                                $first_element = json_decode($establishment->elements)[0];
                                $orther_element = [];
                                foreach (json_decode($establishment->elements) as $key => $element) {
                                    if ($key != 0) {
                                        $orther_element[$key - 1] = $element;
                                    }
                                }
                            @endphp

                            <div class="col-11">
                                <div class="mb-1">
                                    <label class="form-label">Ressource 1</label>
                                    <input class="form-control" placeholder="Ressource" type="text" name="elements[]"
                                        value="{{ $first_element }}" required />
                                </div>
                            </div>
                            <div class="col-1" style="">
                                <button type="button"
                                    class="btn btn-primary border-info text-white add__items__btn fs-4"><i
                                        class='bx bx-plus'></i></button>
                            </div>
                            <div id="items__enfant">
                                @foreach ($orther_element as $key => $element)
                                    <div class="row">
                                        <div class="col-11">
                                            <div class="mb-1">
                                                <label class="form-label">Ressource {{ $key + 2 }} :</label>
                                                <input class="form-control" placeholder="Ressource" type="text"
                                                    value="{{ $element }}" name="elements[]" required />
                                                <div class="invalid-feedback">Ressource requis</div>
                                            </div>
                                        </div>
                                        <div class="col-1" style="">
                                            <button type="button"
                                                class="btn btn-danger border-danger text-white remove__item__btn fs-4">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                            </div>


                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                    <a href="{{ route('dashboard') }}" type="reset"
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
        $(document).ready(function() {
            "use strict";

            var rowIndex = 1;

            // Add item handler
            $('.add__items__btn').click(function() {
                rowIndex++;
                addItems();
            });

            // Remove item handler
            $(document).on('click', '.remove__item__btn', function() {
                $(this).closest(".row").remove();
                rowIndex--;
            });


            // Add item function
            function addItems() {
                $('#items__enfant').append(`<div class="row">
                    <div class="col-11">
                        <div class="mb-1">
                            <label class="form-label">Ressource ${rowIndex} :</label>
                            <input class="form-control" placeholder="Ressource" type="text" name="elements[]" required />
                            <div class="invalid-feedback">Ressource requis</div>
                        </div>
                    </div>
                    <div class="col-1" style="">
                        <button type="button" class="btn btn-danger border-danger text-white remove__item__btn fs-4">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>`);

            }

        });
    </script>
@endpush
