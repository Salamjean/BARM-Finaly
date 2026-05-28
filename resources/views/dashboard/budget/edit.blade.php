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
                    <h5 class="mb-0">Modifie le budget</h5>
                </div>
                @if(can('agent-comptable'))
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('updatemontant', $budget->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-5 mb-10">
                            <label for="libelle" class="form-label">Titre: </label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                                placeholder="Nom de budget" name="libelle" value="{{ $budget->libelle }}" readonly>
                            @error('libelle')
                            <span class="invalid-feedback" budget="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-10">
                            <label for="date" class="form-label">Période: </label>
                            <input type="month" class="form-control @error('date') is-invalid @enderror" id="date"
                                placeholder="Nom de budget" name="date" min="2000-01" value="{{ $budget->date }}"
                                readonly>
                            @error('date')
                            <span class="invalid-feedback" budget="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-10">
                            <label for="service" class="form-label">Service : </label>
                            <input type="text" class="form-control @error('service') is-invalid @enderror" id="service"
                                placeholder="Nom de budget" name="service" value="{{$budget->service}}" readonly>
                            @error('service')
                            <span class="invalid-feedback" budget="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="text" class="form-control  is-invalid " placeholder="Nom de budget" name="user_id"
                            value="{{$budget->user_id}}" hidden>

                        @foreach ($budget->budgetitems as $key=>$budgetitem)
                        <div class="col-8">
                            <div class="mb-3">
                                <label class="form-label">Ressource</label>
                                <input class="form-control" placeholder="Ressource" type="text"
                                    name="budgetitems[{{ $key }}][ressource]" value="{{ $budgetitem->ressource }}"
                                    required readonly />
                                <div class="invalid-feedback">Ressource requis</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Budget alloué</label>
                                <input class="form-control" placeholder="Budget alloué" type="text"
                                    name="budgetitems[{{ $key }}][montant_vote]"
                                    value="{{$budgetitem->montant_vote == null ? '' : $budgetitem->montant_vote}}"
                                    {{$budget->status == 'submitted' ? 'readonly' : ''}} required />
                                <div class="invalid-feedback">Budget alloué requis</div>
                            </div>
                        </div>
                        @endforeach

                        <div id="items__enfant"></div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                @if ($budget->status == 'pending')
                                <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                @endif

                                @if ($budget->status == 'submitted')
                                <a style="cursor: pointer" class="btn btn-success text-white px-4 validated"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Valider">Valider</a>

                                <a style="cursor: pointer" class="btn btn-danger text-white px-4 refused"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refuser">Refuser</a>

                                <form id="validatedForm" action="{{route('changestatus', $budget->id)}}" method="post">
                                    @csrf
                                    <input type="text" name="status" value="validated" hidden>
                                </form>

                                <form id="refusedForm" action="{{ route('changestatus', $budget->id) }}" method="post">
                                    @csrf
                                    <input type="text" name="status" value="refused" hidden>
                                </form>
                                @endif

                                <a href="{{ route('budgets.index') }}" type="reset"
                                    class="btn btn-warning px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

                @if(!can('agent-comptable'))
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('budgets.update', $budget->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-5 mb-10">
                            <label for="libelle" class="form-label">Titre: </label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                                placeholder="Nom de budget" name="libelle" value="{{ $budget->libelle }}">
                            @error('libelle')
                            <span class="invalid-feedback" budget="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-10">
                            <label for="date" class="form-label">Période: </label>
                            <input type="month" class="form-control @error('date') is-invalid @enderror" id="date"
                                placeholder="Nom de budget" name="date" min="2000-01" value="{{ $budget->date }}">
                            @error('date')
                            <span class="invalid-feedback" budget="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-10">
                            <label for="service" class="form-label">Service : </label>
                            <input type="text" class="form-control @error('service') is-invalid @enderror" id="service"
                                placeholder="Nom de budget" name="service" value="{{$budget->service}}" readonly>
                            @error('service')
                            <span class="invalid-feedback" budget="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="text" class="form-control  is-invalid " placeholder="Nom de budget" name="user_id"
                            value="{{$budget->user_id}}" hidden>

                        @foreach ($budget->budgetitems as $key=>$budgetitem)
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Ressource</label>
                                <input class="form-control" placeholder="Ressource" type="text"
                                    name="budgetitems[{{ $key }}][ressource]" value="{{ $budgetitem->ressource }}"
                                    required />
                                <div class="invalid-feedback">Ressource requis</div>
                            </div>
                        </div>
                        @endforeach

                        <div id="items__enfant"></div>

                        <div class="col-1" style="margin-top:2.5rem">
                            <button type="button" class="btn btn-primary border-info text-white add__items__btn fs-4"><i
                                    class='bx bx-plus'></i></button>
                        </div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-primary px-4">Modifier</button>
                                <a href="{{ route('budgets.index') }}" type="reset"
                                    class="btn btn-danger px-4">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

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
                    <div class="col-11">
                        <div class="mb-3">
                            <label class="form-label">Ressource</label>
                            <input class="form-control" placeholder="Ressource" type="text" name="budgetitems[${rowIndex}][ressource]" required />
                            <div class="invalid-feedback">Ressource requis</div>
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

<script>
    (function ($) {
            "use strict";
            $('.refused').on('click', function () {
                var routerefused = $('#refusedForm').attr('action');
                Swal.fire({
                    title: "Réfuser cet budget ",
                    text: "Voulez-vous réfuser cet budget ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, réfuser!",
                    cancelButtonText: "Non, retour"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: routerefused,
                            type: 'POST',
                            data: $('#refusedForm').serialize(), 
                            success: function (response) {
                                window.location.href = "{{ route('budgets.index') }}";
                            },
                            error: function (xhr, status, error) {
                                
                            }
                        });
                    }
                });
            });
            
        })(jQuery);
</script>

<script>
    (function ($) {
        "use strict";
        $('.validated').on('click', function () {
            var routevalidated = "{{ route('changestatus', $budget->id) }}";
            Swal.fire({
                title: "Accepter cet budget ",
                text: "Voulez-vous accepter cet budget ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, accepter!",
                cancelButtonText: "Non, retour"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoyer le formulaire via AJAX
                    $.ajax({
                        url: routevalidated,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: 'validated'
                        },
                        success: function (response) {
                            window.location.href = "{{ route('budgets.index') }}";
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    })(jQuery);
</script>
@endpush