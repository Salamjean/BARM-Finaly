@extends('layouts.app')

@section('content')
    <div class="py-4 fs-2 fw-bolder">
        Budget annuel ({{ date('Y') }})
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center align-content-center">

                    <div class="p-4 {{ $establishment ? 'border bg-grey' : '' }}" style="width: 40vw;">
                        <div class="d-flex justify-content-between fs-5">
                            <div class="fs-5">
                                <div>
                                    <i>Année : </i><span class="fw-bolder text-warning">{{ $budget->year }}</span>
                                </div>
                                <div>
                                    <i>Date de soumission : </i><span
                                        class="fw-bolder text-warning">{{ dateFr($budget->year) }}</span>
                                </div>
                                <div>
                                    <div class=""><u><i>Cellules concernées : </i></u></div>
                                    <div>

                                        @foreach (ROLES as $key => $role)
                                            <span class="fs-6" style="text-transform:lowercase; font-style:italic;">
                                                {{ $role }}, </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="fs-5">
                            </div>
                        </div>
                        <div class="fs-3 text-dark">{{ $budget->title }}</div>
                        <div class="fs-5">{{ $budget->description }}</div>
                        @if ($step == 'create')
                            <div class="d-flex justify-content-center">
                                <div class="pt-5 pb-2" style="width: 15vw;">
                                    <a href="{{ route('annual-budget.establishment.create') }}"
                                        class="btn btn-outline-warning fw-bolder">
                                        Etablir le budget annuel de mon service
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>
                    @if ($establishment)
                        <div class="p-4 my-2 border">
                            <div>
                                <div class="fs-5">
                                    <div>
                                        <div>
                                            <i>Date de soumission : </i><span
                                                class="fw-bolder text-warning">{{ dateFr($establishment->date) }}</span>
                                        </div>
                                        <div>
                                            <i>Cellule : </i><span
                                                class="fw-bolder text-warning">{{ (controllerPersonal())->role->name }}</span>
                                        </div>
                                        <div>
                                            <i>Chef de cellule : </i><span
                                                class="fw-bolder text-danger">{{ $establishment->chief->fullName() }}</span>
                                        </div>
                                        <div>
                                            <i>Statut : </i><span
                                                class="fw-bolder">{{ statusBudget($establishment->status, 'establishment') }}</span>
                                            @if ($establishment->status === 'new')
                                                <a class="text-dark"
                                                    href="{{ route('annual-budget.establishment.edit', $establishment->id) }}">
                                                    <i class='bx bx-edit-alt'></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <table class="dt-responsive table mt-3" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($establishment->elements) as $key => $resource)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $resource }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($establishment->description)
                                <div class="col-md-12 my-3">
                                    <label for="" class="fs-5 mb-2">Consigne ou Explication: </label>
                                    <textarea name="description" id="" rows="5" class="form-control" disabled>{{ $establishment->description }}</textarea>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .bg-grey {
            background: rgba(216, 216, 216, 0.39);
        }
    </style>
@endsection
