@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Candidatures/</span> Liste des candidatures acceptées
    </h4>
    <div class="card">
        <h5 class="card-header">Liste des candidatures acceptées</h5>
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom & Prénom(s)</th>
                            <th>Mécano</th>
                            <th>Email</th>
                            <th>N° téléphone </th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($liste_admis as $liste_admi)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $liste_admi->user->fullName() }}</td>
                            <td>{{ $liste_admi->user->mecano }}</td>
                            <td>{{ $liste_admi->user->email }}</td>
                            <td>{{ $liste_admi->phone_number }}</td>
                            <td>
                                <span class="badge bg-label-success me-1">Accepté</span>
                            </td>
                            <td>
                                <td class="text-right">
                                    @if ($leave->file != null)
                                    <a href="{{ asset('assets/faces/' . $leave->file) }}" class="btn btn-outline-secondary btn-sm btn-rounded" title="Télécharger la pièce justificative" download="{{ $leave->file }}"><i class="fas fa-paperclip"></i></a>
                                    @endif
                                    <a href="{{ route('leave.leave-pdf', $leave->id) }}" class="btn btn-sm btn-primary btn-rounded"><i class="fas fa-upload" title="Télécharger la demande"></i></a>
                                    <a href="{{ route('demande.editPersonnelLeave', $leave->id) }}" class="btn btn-sm btn-warning btn-rounded" title="Voir la demande"><i class="fas fa-eye"></i></a>
                                    {{-- <a href="{{ route('leave.delete', $leave->id) }}" class="btn btn-sm btn-danger btn-rounded"><i class="fas fa-trash"></i></a> --}}
                                </td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
