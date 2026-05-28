@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">FORMATIONS > </span> {{ $title }}
        </h4>
        <div class="card">
            <h5 class="card-header">Bénéficiaires enregistrés</h5>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>N° pièce</th>
                                <th>Nom & prénoms</th>
                                <th>Né(e) le</th>
                                <th>Genre</th>
                                <th>Orientation</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($candidatures->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">Aucune données trouvées.</td>
                                </tr>
                            @else
                                @foreach ($candidatures as $candidature)
                                    <tr>
                                        <td class="text-dark fw-bold fs-6">{{ $loop->index + 1 }}</td>
                                        <td class="text-dark fw-bold fs-6">{{ $candidature->no_card }}</td>
                                        <td class="fw-bold">
                                            {{ $candidature->user->fullName() }}</td>
                                        <td>{{ date('d/m/Y', strtotime($candidature->birth_date)) }}</td>
                                        <td>{{ $candidature->gender }}</td>
                                        <td class="text-center fw-bold">
                                            @if ($candidature->orientation == 'auto-emploi')
                                                <span class="badge bg-info">{{ $candidature->orientation }}</span>
                                            @else<span class="badge bg-warning">{{ $candidature->orientation }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($candidature->status == 'accepted')
                                                <span class="badge bg-label-success me-1"><i
                                                        class='bx bx-check-circle'>&nbsp;</i>Accepté</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">Refusé</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!($candidature && $candidature->formationBeneficiaire))
                                                @if ($candidature->status == 'accepted')
                                                    <a href="{{ route('adherent.candidature.choice-final.show', $candidature->id) }}"
                                                        class="btn btn-outline-secondary btn-sm btn-rounded"
                                                        title="Enregistrer une formation">Continuer &nbsp; <i
                                                            class="fas fa-arrow-right"></i></a>
                                                @else
                                                <a href="{{ route('adherent.candidature.choice-final.remake', $candidature->id) }}"
                                                        class="btn btn-outline-secondary btn-sm btn-rounded"
                                                        title="Enregistrer une formation">Réprendre &nbsp; <i
                                                            class="fas fa-plus"></i></a>
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
