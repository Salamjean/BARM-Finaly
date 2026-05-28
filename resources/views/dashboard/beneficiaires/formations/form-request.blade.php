@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">FORMATIONS > </span> {{$title}}
        </h4>
        <div class="card">
            <h5 class="card-header">Formations enregistrés</h5>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped"  id="formationsList">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Ref</th>
                                <th>Nom & Prenoms</th>
                                <th>Orientation</th>
                                <th>Validation PA</th>
                                <th>Approbation PA</th>
                                <th>Enregistré par</th>
                                <th>Crée le</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($forms->isEmpty())
                                <tr>
                                    <tr><td colspan="10" class="text-center">Aucune données trouvées.</td></tr>
                                </tr>
                                @else
                                @foreach($forms as $item)
                                    @if ($item->formation == 'Oui')
                                    <tr>
                                        <<td>{{ $loop->index + 1 }}</td>
                                        <td class="text-dark fw-bold fs-6">{{$item->reference}}</td>
                                        <td class="fw-bold">{{$item->formationBeneficiaire->user->fullName()}}</td>
                                        <td>{{$item->orientation}}</td>
                                        <td>
                                            @if ($item->Validation_PA == 'validé')
                                            <span class="badge bg-success me-1"> Validé</span>@else<span class="badge bg-label-danger me-1">Non-validé</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->Approbation_PA == 'approuvé')
                                            <span class="badge bg-success me-1"> Approuvé</span>@else<span class="badge bg-label-danger me-1">Non-approuvé</span>
                                            @endif</td>
                                        <td><span class="badge bg-label-dark me-1">{{ $item->operateur->username }}</span></td>
                                        <td>{{ date('d/m/Y - H:i', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if ($item->status == 'En cours' || $item->status == 'Suspendue')
                                                <span class="badge bg-label-warning me-1">{{$item->status}}</span>
                                                @elseif ($item->status == 'Archivé')
                                                <span class="badge bg-label-dark me-1">{{$item->status}}</span>
                                                @else
                                                <span class="badge bg-label-success me-1">{{$item->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->Approbation_PA == NULL)
                                                <a href="{{route('beneficiaire.formShow', ['id' => $item->id])}}" class="btn btn-sm btn-info btn-rounded" title="Voir détails de la formation"><i class="fas fa-eye"></i></a>
                                                @else
                                                <a href="#" class="btn btn-sm btn-label-info btn-rounded" title="Editer détails de la formation"><i class="fas fa-pencil"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @else
                                    <td colspan="10" class="text-center">Aucune formation</td>
                                    @endif 
                                @endforeach
                            @endif
                        </tbody>
                    </table>
               </div>
            </div>
        </div>
    </div>
@endsection
