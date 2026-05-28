@extends('layouts.app', ['title' => $title])

@section('content')
@foreach($leaves as $leave)
        @include('layouts.inc.delete-modal')
        @include('layouts.inc.leave-modal')
    @endforeach
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">DEMANDES > </span> {{$title}}
        </h4>
        <div class="card">
            <h5 class="card-header">Mes demandes enregistrées
                <div class="col-md-12 mb-1 text-end">
                    <a href="{{ route('leave.create') }}" class="btn btn-outline-primary btn-sm float-end">
                        <i class="fas fa-plus">&nbsp;</i><span class="button-with-icon"> Faire une demande</span>
                    </a>
                </div>
            </h5>
            <div class="card-body">
                <form action="{{ route('leave.persleaveSearch')}}" method="POST" class="form-inline responsive-filter-form needs-validation mb-2" novalidate autocomplete="off" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12">
                      <div class="row g-1">
                          <div class="col-sm-4">
                            <input name="date_envoi" type="date" class="airdatepicker form-control form-control-sm mr-1 @error('date_envoi') is-invalid @enderror" placeholder="{{ __('Date de soumission') }}" required>
                          </div>
                          @error('date_envoi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                          <div class="col-sm-4">
                            <select class="form-control form-control-sm mr-1 @error('typeLeave') is-invalid @enderror" aria-label="Type de la demande" name="typeLeave" required>
                                <option value="" >Sélectionner</option>
                                <option value="Permission">Permission</option>
                                <option value="Congé">Congé</option>
                            </select>
                        </div>
                            @error('typeLeave')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          <div class="col-sm-4">
                            <button class="btn btn-secondary btn-sm">
                                <i class="fas fa-filter">&nbsp;&nbsp;</i><span class="button-with-icon"> Filtrer</span>
                            </button>
                          </div>
                      </div>
                      <br>
                    </div>
                </form>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>N°</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Date Depart</th>
                                <th>Date Retour</th>
                                <th>Durée</th>
                                <th>Raison/Motif</th>
                                <th>Date Reprise</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @if($leaves->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">Aucune donnée trouvée.</td>
                            </tr>
                            @else
                            @foreach($leaves as $leave)
                                <tr>
                                    <td class="text-dark fw-bold fs-6">{{ $loop->index + 1 }}</td>
                                    <td class="fw-bold">{{ date('d/m/Y', strtotime($leave->created_at)) }}</td>
                                    <td>
                                        @if ($leave->leave_type == 'Permission')<span class="badge bg-info">{{ $leave->leave_type }}</span>
                                        @else<span class="badge bg-secondary">{{ $leave->leave_type }}</span> @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($leave->leavefrom)) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($leave->leaveto)) }}</td>
                                    <td class="text-center">{{ $leave->nb_day }} Jours</td>
                                        @if ($leave->leave_type == 'Permission')
                                        <td>{{ $leave->reason }}</td>
                                        @else
                                        <td>Congé annuel</td>
                                        @endif
                                    <td>{{ date('d/m/Y', strtotime($leave->returndate)) }}</td>
                                    <td>
                                        @if($leave->status == 'Approuvé')<span style="color: green">Avis favorable</span>@elseif ($leave->status == 'En attente')<span style="color: blue">{{ $leave->status }}</span>
                                        @else<span style="color: red">{{ $leave->status }}</span>@endif
                                    </td>
                                    <td class="text-right">
                                        @if ($leave->status == 'En attente')
                                        <a href="{{ route('leave.edit', $leave->id) }}" class="btn btn-sm btn-warning btn-rounded"><i class="fas fa-pen"></i></a>
                                        <a href="{{ route('leave.delete', $leave->id) }}" class="btn btn-sm btn-danger btn-rounded" onclick="document.getElementById('delete-form-{{ $leave->id }}').submit()" data-bs-toggle="#confirmationModal" data-bs-placement="bottom" title="Supprimer"><i class="fas fa-trash"></i></a>

                                        @elseif ($leave->status == 'Réjeté')
                                        @if($leave->comment == null)
                                            <span style="color: red"><i class="fas fa-warning" title="aucune action"></i></span>
                                        @else
                                            <a href="#" onclick="afficherModal('{{ $leave->id }}')" data-tooltip='modal' data-position='top right'><i class="fas fa-comment"></i></a>
                                        @endif
                                    @elseif ($leave->status == 'Approuvé')
                                        @if ($leave->leave_type == 'Permission')
                                        <a href="{{ route('leave.leave-pdf', $leave->id) }}" class="btn btn-sm btn-info btn-rounded"><i class="fas fa-upload" title="Télécharger la demande de permission"></i></a>
                                        @else
                                        <a href="{{ route('certificat.demandeCongePdf', $leave->id) }}" class="btn btn-sm btn-secondary btn-rounded"><i class="fas fa-upload" title="Télécharger la demande de congé"></i></a>
                                        @endif
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                         @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js-push')
<script>
    function afficherModal(leaveId) {
        var myModal = new bootstrap.Modal(document.getElementById('messageModal' + leaveId));
        myModal.show();
    }
</script>
<script>
    (function() {
        "use strict";

        $('.btnDelete').on('click', function() {
            var url;
            url = $(this).attr("data-url");
            $('.modal_URL').attr("href", url);
        });
    })();
</script>
@endpush
