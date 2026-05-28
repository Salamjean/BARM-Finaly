@extends('layouts.app')

@section('content')
    <div class="py-4 fs-2 fw-bolder">
        Budget annuel ({{ date('Y') }})
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center align-content-center">

                    <div class="p-2 {{ count($budget->budgetByCell) ? 'border bg-grey' : '' }}" style="width: 40vw;">
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
                        <div class="d-flex justify-content-center py-3">

                            @if ($budget->status == 'launch')
                                <a href="{{ route('annual-budget.status', [$budget->id, 'negotiation']) }}"
                                    class="btn btn-outline-warning fw-bold">
                                    Activer le droit à l'ecriture
                                </a>
                            @endif

                            @if ($budget->status == 'negotiation')
                                <a href="{{ route('annual-budget.status', [$budget->id, 'finished']) }}"
                                    class="btn btn-outline-primary fw-bold">
                                    Terminer la session
                                </a>
                            @endif
                        </div>

                    </div>
                    @if (count($budget->budgetByCell))
                        @foreach ($budget->budgetByCell as $establishment)
                            <div class="p-4 my-2 mt-3 border position-relative">
                                <div class="position-absolute" style="right: 10px; top:10px;">
                                    @if ($budget->status == 'negotiation')
                                        <a class="btn btn-outline-success "
                                            href="{{ route('annual-budget.establishment.edit.2', $establishment->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @elseif ($establishment->status === 'new')
                                        <a class="btn btn-outline-success rounded-circle py-4"
                                            href="{{ route('annual-budget.establishment.status', [$establishment->id, 'verification']) }}">
                                            Vue
                                        </a>
                                    @endif
                                </div>
                                <div>
                                    <div class="fs-5">
                                        <div>
                                            <div>
                                                <i>Date de soumission : </i><span
                                                    class="fw-bolder text-warning">{{ dateFr($establishment->date) }}</span>
                                            </div>
                                            <div>
                                                <i>Cellule : </i><span
                                                    class="fw-bolder text-warning">{{ controllerPersonal($establishment->chief)->role->name }}</span>
                                            </div>
                                            <div>
                                                <i>Chef de cellule : </i><span
                                                    class="fw-bolder text-danger">{{ $establishment->chief->fullName() }}</span>
                                            </div>
                                            <div>
                                                <i>Statut : </i><span
                                                    class="fw-bolder">{{ statusBudget($establishment->status, 'establishment') }}</span>
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
                        @endforeach
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
