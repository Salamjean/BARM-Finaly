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
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Informations > </span> {{$title}}
        </h4>
        <div class="card">
            <h5 class="card-header">Informations enregistrées
                <div class="col-md-12 mb-1 text-end">
                    <a href="{{ route('info.info-create') }}" class="btn btn-outline-primary btn-sm float-end">
                        <i class="fas fa-plus">&nbsp;</i><span class="button-with-icon"> Ajouter une information</span>
                    </a>
                </div>
            </h5>
            <div class="card-body">
                <form action="{{route('info.info-store')}}" method="POST" class="form-inline responsive-filter-form needs-validation mb-2" novalidate autocomplete="off" accept-charset="utf-8">
                    @csrf
                </form>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" style="width:110%">
                        <thead class="table-dark">
                            <tr>
                                <th>N°</th>
                                <th>Ref</th>
                                <th>Titre</th>
                                <th colspan="3">Message</th>
                                @if (@can('responsable-communication'))
                                <th>destinataire</th>
                                @endif
                                <th style="width: 12%">Crée</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($infos->isEmpty())
                            <tr><td colspan="7" class="text-center">Aucune données trouvées.</td></tr>
                            @else
                            @foreach ($infos as $info)
                            <tr>
                                <td>#{{ $loop->index + 1 }}</td>
                                <td class="fw-bold" style="width: 10%">{{$info->ref}}</td>
                                <td>{{$info->title}}</td>
                                <td colspan="3">{{$info->contenu}}</td>
                                @if (@can('responsable-communication'))
                                <td>{{$info->destinataire}}</td>
                                @endif
                                <td class="fw-bold" style="font-size:90%">{{ dateFormat($info->created_at) }}</td>
                                <td class="text-center">
                                    @if($info->status == 1)
                                        <span class="text-success">Activé</span>
                                    @else
                                        <span class="text-danger">Désactivé</span>
                                    @endif
                                </td>
                                <td style="width: 10%">
                                    <a href="{{ route('info.status', $info->id) }}" class="btn btn-sm {{ $info->status == 0? 'btn-success' : 'btn-secondary' }}" style="padding-left: 5px; padding-right: 5px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Publier/Rétirer">
                                        <i class="fa-solid {{ $info->status == 0? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </a>
                                    <a href="{{ route('info.edit', $info->id) }}" class="btn btn-sm btn-warning btn-rounded" style="padding-left: 5px; padding-right: 5px;"><i class="fas fa-pen"></i></a>
                                    <a href="{{ route('info.delete', $info->id) }}" class="btn btn-sm btn-danger btn-rounded" style="padding-left: 5px; padding-right: 5px;" onclick="document.getElementById('delete-form-{{ $info->id }}').submit()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer"><i class="fas fa-trash"></i></a>
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
