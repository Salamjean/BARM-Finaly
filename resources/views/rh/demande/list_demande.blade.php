@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">DEMANDES > </span> {{$title}}
        </h4>
        <div class="card">
            <h5 class="card-header">Demandes enregistrées</h5>
            <div class="card-body">
                <form action="{{route('demande.leaveSearch')}}" method="POST" class="form-inline responsive-filter-form needs-validation mb-2" novalidate autocomplete="off" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12">
                      <div class="row g-1">
                          <div class="col-sm-4">
                            <input name="sendDate" type="date" class="airdatepicker form-control form-control-sm mr-1" placeholder="{{ __('Date de soumission') }}" required>
                          </div>
                          <div class="col-sm-4">
                            <select class="form-control form-control-sm mr-1" aria-label="Type de la demande" name="leaveType" required>
                                <option value="" >Sélectionner</option>
                                <option value="Permission">Permission</option>
                                <option value="Congé">Congé</option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <button class="btn btn-secondary btn-sm">
                                <i class="fas fa-filter">&nbsp;&nbsp;</i><span class="button-with-icon">{{ __(" Filtrer") }}</span>
                            </button>
                          </div>
                      </div>
                      <br>
                    </div>
                </form>
                @php
                 $leaves = App\Models\Leave::orderBy('created_at', 'desc')->get();
                @endphp
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>N°</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Du</th>
                                <th>Au</th>
                                <th>Durée</th>
                                @foreach($leaves as $leave)
                                    @if ($leave->leave_type == 'Permission')<th>Raison/Motif</th>@else<th style="display:none"></th>@endif
                                @endforeach
                                <th>Date Reprise</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if($leaves->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">Aucune données trouvées.</td>
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
                                        <td class="text-center fw-bold">{{ $leave->nb_day }} jours</td>
                                        @if ($leave->leave_type == 'Permission')
                                        <td>{{ $leave->reason }}</td>@else<td>Congé Annuel</td>
                                        @endif
                                        <td>{{ date('d/m/Y', strtotime($leave->returndate)) }}</td>
                                        <td>
                                            @if($leave->status == 'Approuvé')<span style="color: green">Avis favorable</span>@elseif ($leave->status == 'En attente')<span style="color: blue">{{ $leave->status }}</span>
                                            @else<span style="color: red">{{ $leave->status }}</span>@endif
                                        </td>
                                        <td class="text-right">
                                            @if ($leave->file != null)
                                            <a href="{{ asset('assets/faces/' . $leave->file) }}" class="btn btn-outline-secondary btn-sm btn-rounded" title="Télécharger la pièce justificative" download="{{ $leave->file }}"><i class="fas fa-paperclip"></i></a>
                                            @endif
                                            @if ($leave->leave_type == 'Permission')

                                            <a href="{{ route('leave.leave-pdf', $leave->id) }}" class="btn btn-sm btn-info btn-rounded"><i class="fas fa-upload" title="Télécharger la demande de permission"></i></a>
                                                @else
                                                <a href="{{ route('certificat.demandeCongePdf', $leave->id) }}" class="btn btn-sm btn-secondary btn-rounded"><i class="fas fa-upload" title="Télécharger la demande de congé"></i></a>
                                            @endif
                                        <a href="{{ route('demande.editPersonnelLeave', $leave->id) }}" class="btn btn-sm btn-warning btn-rounded" title="Voir la demande"><i class="fas fa-eye"></i></a>
                                                                                    {{-- <a href="{{ route('leave.delete', $leave->id) }}" class="btn btn-sm btn-danger btn-rounded"><i class="fas fa-trash"></i></a> --}}
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
