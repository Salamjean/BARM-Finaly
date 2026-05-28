@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Commissions d'approbations/</span> {{ $title }}
                </h4>
            </nav>
        </div>

        <div class="ms-auto">

        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Partenaires Techniques</th>
                            <th>Partenaires Financiers</th>
                            <th>Date de tenue</th>
                            <th>Lieu</th>
                            <th>Rapport</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commissions as $commission)

                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>
                                @foreach ($commission->partenaires as $partenaire)
                                @if ($commission->partenaires->find($partenaire->id)->pivot->type ==
                                'partner_technique')
                                <span class="badge bg-primary mb-2">{{ $partenaire->user->username }}</span>
                                @if (!$loop->last)
                                &nbsp;
                                @endif
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($commission->partenaires as $partenaire)
                                @if ($commission->partenaires->find($partenaire->id)->pivot->type ==
                                'partner_financial')
                                <span class="badge bg-primary mb-2">{{ $partenaire->user->username }}</span>
                                @if (!$loop->last)
                                &nbsp;
                                @endif
                                @endif
                                @endforeach
                            </td>
                            <td>{{ dateFr($commission->date) }}</td>
                            <td>{{$commission->lieu}}</td>
                            <td>
                                @if ($commission->rapport)
                                <a href="{{ asset($commission->rapport) }}" download>
                                    <i class='bx bx-cloud-download fs-2'></i>
                                </a>
                                @endif
                            </td>
                            <td style="text-align: center">

                                <a href="{{ route('commissions.candidat_commission', $commission->id) }}"
                                    class="badge bg-primary text-white">Voir</a>

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