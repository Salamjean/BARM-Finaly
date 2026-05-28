@extends('layouts.app', ['title' => $title])
<style>
    table {
        width: auto;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        border: 1px solid #ccc;
        overflow-wrap: break-word;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var firstColumnCells = document.querySelectorAll('table tr td:first-child');

        firstColumnCells.forEach(function(cell) {

            var content = cell.textContent || cell.innerText;
            var container = document.createElement('div');
            container.innerHTML = content;
            container.style.width = 'auto';
            container.style.display = 'inline-block';
            document.body.appendChild(container);

            var computedStyle = window.getComputedStyle(container);
            var contentWidth = parseInt(computedStyle.getPropertyValue('width'), 50);

            document.body.removeChild(container);

            cell.style.maxWidth = contentWidth + 'px';
            cell.style.overflow = 'hidden';
            cell.style.textOverflow = 'ellipsis';
            cell.style.whiteSpace = 'nowrap';
        });
    });
</script>
@section('content')
    <div class="modal fade" id="confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmation de suppression</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            Êtes-vous sûr de vouloir supprimer cette activité?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="button" id="confirm-delete-btn" class="btn btn-danger">Supprimer</button>
            </div>
        </div>
        </div>
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Activités > </span> {{$title}}
        </h4>
        <div class="card">
            <h5 class="card-header">Historiques
                <div class="col-md-12 mb-1 text-end">
                    <a href="{{ route('activities.create') }}" class="btn btn-outline-primary btn-sm float-end">
                        <i class="fas fa-plus">&nbsp;</i><span class="button-with-icon"> Ajouter une activité</span>
                    </a>
                </div>
            </h5>
            <div class="card-body">
                <form action="{{route('activities.store')}}" method="POST" class="form-inline responsive-filter-form needs-validation mb-2" novalidate autocomplete="off" accept-charset="utf-8">
                    @csrf
                </form>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" style="width:115%">
                        <thead class="table-dark">
                            <tr>
                                <th>N°</th>
                                <th colspan="2">Activités</th>
                                <th colspan="3">Objectifs</th>
                                <th>Public/cible</th>
                                <th>Enregistré(e)</th>
                                <th>Statut </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($activities->isEmpty())
                            <tr><td colspan="10" class="text-center">Aucune données trouvées.</td></tr>
                            @else
                            @foreach ($activities as $activite)
                            <tr>
                                <td>#{{ $loop->index + 1 }}</td>
                                <td class="fw-bold" colspan="2">{{$activite->title}}</td>
                                <td colspan="3">{{$activite->objectifs}}</td>
                                <td>{{$activite->observations}}</td>
                                    <td style="font-size:90%">{{ dateFormat($activite->created_at) }}</td>
                               <td>
                                    @if($activite->status == 'En attente')
                                        <span class="badge bg-label-primary">{{$activite->status}}</span>
                                    @elseif ($activite->status == 'En cours')
                                        <span class="badge bg-label-warning">{{$activite->status}}</span>
                                    @else
                                        <span class="badge bg-label-secondary">{{$activite->status}}</span>
                                    @endif
                                </td>
                                <td style="width: 15%">
                                    @if ($activite->status == 'Terminée')
                                    <a href="{{ route('activities.show', $activite->id )}}" class="btn btn-sm btn-info btn-rounded" style="padding-left: 10px; padding-right: 10px;" title="Voir"><i class="fas fa-eye"></i></a>
                                    @else
                                    <a href="{{ route('activities.statusUpdate', $activite->id) }}" class="btn btn-sm {{ $activite->status == 'En cours'? 'btn-success' : ($activite->status == 'En attente'? 'btn-primary' : 'btn-secondary') }}" style="padding-left: 10px; padding-right: 10px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Changer le statut">
                                        <i class="fa-solid {{ $activite->status == 'En cours'? 'fa-check' : ($activite->status == 'En attente'? 'fa-clock' : 'fa-times') }}"></i>
                                    </a>
                                    <a href="{{ route('activities.show', $activite->id )}}" class="btn btn-sm btn-info btn-rounded" style="padding-left: 10px; padding-right: 10px;" title="Voir"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('activities.edit', $activite->id )}}" class="btn btn-sm btn-warning btn-rounded" style="padding-left: 10px; padding-right: 10px;" title="Editer"><i class="fas fa-pen"></i></a>
                                    <a href="{{ route('activities.delete', $activite->id )}}" class="btn btn-sm btn-danger btn-rounded" style="padding-left: 10px; padding-right: 10px;" title="Supprimer" onclick="document.getElementById('delete-form-{{ $activite->id }}').submit()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer"><i class="fas fa-trash"></i></a>
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
