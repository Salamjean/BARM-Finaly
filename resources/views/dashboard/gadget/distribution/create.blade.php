@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Gestion de gadget / Distributions / </span> {{ $title }}
                    </h4>
                </nav>
            </div>

        </div>
        <div class="card">
            <div class="card-header d-flex">
                <a href="{{ route('gadget.distribution.index') }}" class="addBtn btn btn-danger">
                    Retour
                </a>
            </div>
            <div class="card-body p-4">
                <form class="row g-3" method="POST" action="{{ route('gadget.distribution.store') }}">
                    @csrf
                    <div class="row mb-4 mx-2 ">
                        <div class="col-md-2 ">
                            <label class="form-label">Date </label>
                            <input class="form-control" type="date" name="distribution_date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required />
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">CELLULE / SERVICE</label>
                            <select class="select2 form-select" id="title" name="title" required>
                                <option selected disabled>Selectionner</option>
                                @foreach (GADGETS_DISTRIBUTIONS as $dest)
                                    <option value="{{ $dest }}">{{ $dest }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 " style="display: none;" id="title_prec">
                            <label class="form-label">PRECISER LE SERVICE</label>
                            <input class="form-control" placeholder="KOUAME KABLAN" type="text" name="title_pres" />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">DESCRIPTION</label>
                            <textarea class="form-control" placeholder="CELLULE D'INSERTION" name="sub_title"></textarea>
                        </div>

                    </div>

                    <div class="row mb-1">
                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary">Distribution de gadget 1</label>
                        </div>
                        <div class="col-9">
                            <div class="">
                                <label class="form-label">Gadget</label>
                                <select class="select2 form-select" name="gadget[]" required>
                                    <option selected disabled>Selectionner</option>
                                    @foreach ($gadgets as $gadget)
                                        <option value="{{ $gadget->id }}">{{ $gadget->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="">
                                <label class="form-label">Quantité</label>
                                <input class="form-control" placeholder="6" type="number" name="quantity[]" required />
                            </div>
                        </div>
                        <div class="col-1 mt-4">
                            <button type="button" class="btn btn-primary border-info text-white add__items__btn fs-4"><i
                                    class='bx bx-plus'></i></button>
                        </div>
                    </div>
                    <div id="items__child"></div>


                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                            <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                            <a href="{{ route('dashboard') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                        </div>
                    </div>
                </form>
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
                $('#items__child').append(`
                    <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-secondary">Distribution de gadget ${rowIndex}</label>
                            </div>
                            <div class="col-9">
                                <div class="">
                                    <label class="form-label">Gadget</label>
                                    <select class="select2 form-select" name="gadget[]" required>
                                        <option selected disabled>Selectionner</option>
                                        @foreach ($gadgets as $gadget)
                                            <option value="{{ $gadget->id }}">{{ $gadget->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="">
                                    <label class="form-label">Quantité</label>
                                    <input class="form-control" placeholder="6" type="number" name="quantity[]" required />
                                </div>
                            </div>
                            <div class="col-1" style="">
                            <button type="button" class="btn btn-danger border-danger text-white remove__item__btn fs-4">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
            }

            // Add item handler
            $('#title').change(function() {
                if ($('#title').val() === 'AUTRE') {
                    $('#title_prec').css('display', 'block');
                    $("[name='tilte_pres']").attr('required', true);
                } else {
                    $('#title_prec').css('display', 'none');
                    $("[name='tilte_pres']").attr('required', false);
                }
            });
        });
    </script>
@endpush
