@extends('layouts.app')

@section('content')
    <div class="container pt-2">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Candidatures/</span> {{ $title }}
        </h4>

        <div class="card">
            <h3 class="card-header mt-2">{{ $title }}</h3>

            <div class="card-body mt-4">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>

                                <th>Date</th>
                                <th>Adhérents</th>
                                <th>Orientation</th>
                                <th>Formation?</th>
                                <th class="text-center">Statut</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($trainings as $training)
                                <tr>
                                    <td>{{ dateFr($training->created_at, 'complet') }}</td>
                                    <td>{{ $training->candidature->user->fullName() }}</td>
                                    <td>{{ statusCandidature($training->candidature->orientation, 'orientation') }}</td>
                                    <td class="text-center">
                                        @if ($training->formation === 'Oui')
                                        <span class="badge bg-primary me-1">Oui</span>@else<span
                                                class="badge bg-secondary me-1">Non</span>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        <span @php echo statusCandidature($training->status, 'css'); @endphp>
                                            {{ statusCandidature($training->status) }}
                                        </span>
                                    </td>



                                    <td class="d-flex justify-content-center gap-2">

                                        @if (can(
                                                'chef-cellule-formation-et-insertion|responsable-preparation-a-la-reconversion|conseiller-preparation-a-la-reconversion|conseiller-en-reconversion'))
                                            @if ($training->candidature->orientation == 'auto-emploi' && $training->status == 'search_financial_partner')
                                                <a class="btn btn-success fw-bold"
                                                    href="{{ route('adherent.training.approbation_list', $training->id) }}">
                                                    Partenaires financiers
                                                </a>
                                            @endif
                                        @endif



                                        <a class="btn btn-success fw-bold"
                                            href="{{ route('adherent.training.show', $training->id) }}">
                                            Détail
                                        </a>
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
