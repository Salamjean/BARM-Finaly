@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-none d-sm-flex align-items-center mb-4">
            <div class="border-start border-primary border-3 ps-3">
                <nav aria-label="breadcrumb">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-map-pin text-primary fs-4 me-3"></i>
                        <div>
                            <div class="text-muted small">Accueil</div>
                            <h4 class="mb-0 text-primary">{{ $title }}</h4>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3 shadow-none mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <i class="bx bx-time-five text-warning fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 text-warning">Plans d'affaires différés / rejetés / abandon</h4>
                        <p class="text-muted mb-0">Plans d'affaires ajournés, refusés ou ayant fait l'objet d'un abandon
                            pendant la commission de validation</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="filter-card text-center p-2 rounded-3" data-filter="deferred"
                        title="Cliquer pour filtrer par les dossiers différés">
                        <div class="badge bg-warning text-dark fs-6 px-3 py-2">
                            {{ $pas->where('status', 'deferred')->count() }}
                        </div>
                        <div class="small fw-semibold mt-1">Différés</div>
                    </div>
                    <div class="filter-card text-center p-2 rounded-3" data-filter="refused"
                        title="Cliquer pour filtrer par les dossiers refusés">
                        <div class="badge bg-danger fs-6 px-3 py-2">
                            {{ $pas->whereIn('status', ['refused', 'rejected'])->count() }}
                        </div>
                        <div class="small fw-semibold mt-1">Refusés</div>
                    </div>
                    <div class="filter-card text-center p-2 rounded-3" data-filter="resignation"
                        title="Cliquer pour filtrer par les abandons">
                        <div class="badge bg-secondary fs-6 px-3 py-2">
                            {{ $pas->where('status', 'resignation')->count() }}
                        </div>
                        <div class="small fw-semibold mt-1">Abandons</div>
                    </div>
                    <div class="border-start ps-2">
                        <div class="filter-card text-center p-2 rounded-3 active" data-filter="all"
                            title="Cliquer pour afficher tous les dossiers">
                            <div class="badge bg-dark fs-6 px-3 py-2">
                                {{ $pas->count() }}
                            </div>
                            <div class="small fw-semibold mt-1">Tous</div>
                        </div>
                    </div>
                    <a href="{{ route('export.pdf.deferred') }}" class="btn btn-danger btn-sm text-white shadow-sm ms-2">
                        <i class="bx bxs-file-pdf me-1"></i> Télécharger en PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-none">
            <div class="p-4">
                <div class="table-responsive">
                    <table class="dt-responsive table table-hover" id="datatable--barm" style="width:100%">
                        <thead>
                            <tr class="table-warning">
                                <th class="border-0">
                                    <i class="bx bx-layer-group text-warning me-1"></i>
                                    Cohorte
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-gavel text-warning me-1"></i>
                                    Commission
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-user text-warning me-1"></i>
                                    Candidat
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-briefcase text-warning me-1"></i>
                                    Partenaire technique
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-folder text-warning me-1"></i>
                                    Projet
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-check-shield text-warning me-1"></i>
                                    Décision
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-comment-detail text-warning me-1"></i>
                                    Motif / Observation
                                </th>
                                <th class="border-0">
                                    <i class="bx bx-file-blank text-warning me-1"></i>
                                    Plan d'affaire
                                </th>
                                <th class="border-0 text-center">
                                    <i class="bx bx-cog text-warning me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pas as $index => $pa)
                                @php
                                    $adherent = $pa->candidature;
                                @endphp
                                <tr class="align-middle">
                                    <td>
                                        <div class="border-start border-info border-3 ps-2 py-1">
                                            <div class="fw-bold text-info">{{ $adherent->cohort->title ?? 'Non assignée' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($pa->commission)
                                            <div class="border-start border-warning border-3 ps-2 py-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-gavel text-warning me-2"></i>
                                                    <div>
                                                        <div class="fw-bold text-dark">
                                                            {{ $pa->commission->number }}
                                                        </div>
                                                        <div class="small text-muted">
                                                            {{ dateFr($pa->commission->date) }}
                                                        </div>
                                                        @if ($pa->commission->lieu)
                                                            <div class="small text-muted">
                                                                {{ $pa->commission->lieu }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-gavel text-muted me-2"></i>
                                                <span class="text-muted">Pré-commission</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($adherent && $adherent->user)
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $adherent->user->fullName() }}</div>
                                                    <div class="small text-muted">
                                                        @if ($adherent->user->mecano)
                                                            <span class="badge bg-secondary me-1">{{ $adherent->user->mecano }}</span>
                                                        @endif
                                                        <span>{{ $adherent->phone_number ?? $adherent->user->phone }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Candidat non trouvé</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($adherent && $adherent->partnerTechnical && $adherent->partnerTechnical->user)
                                            <div class="border-start border-primary border-3 ps-2 py-1">
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge bg-primary">{{ $adherent->partnerTechnical->user->username }}</span>
                                                </div>
                                                <small class="text-muted">Partenaire technique</small>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Non assigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="border-start border-warning border-3 ps-2 py-1">
                                            <div class="fw-medium text-dark">
                                                {{ $pa->title ?? 'Projet non défini' }}
                                            </div>
                                            @if ($pa->location)
                                                <div class="small text-muted">
                                                    <i class="bx bx-map-pin me-1"></i>{{ $pa->location }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($pa->status == 'deferred')
                                            <span class="badge bg-warning text-dark px-2 py-1">
                                                <i class="bx bx-time-five me-1"></i>Différé
                                            </span>
                                        @elseif ($pa->status == 'refused' || $pa->status == 'rejected')
                                            <span class="badge bg-danger px-2 py-1">
                                                <i class="bx bx-x-circle me-1"></i>Refusé
                                            </span>
                                        @elseif ($pa->status == 'resignation')
                                            <span class="badge bg-secondary px-2 py-1">
                                                <i class="bx bx-user-x me-1"></i>Abandon
                                            </span>
                                        @else
                                            <span class="badge bg-info px-2 py-1">{{ statusCandidature($pa->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="max-width: 250px;">
                                            <div class="small text-dark">{{ $pa->sentence_reason ?? 'Aucun motif renseigné' }}
                                            </div>
                                            @if ($pa->sentence_at)
                                                <div class="small text-muted fst-italic">
                                                    Le {{ dateFr($pa->sentence_at) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($pa->url)
                                            <div class="border-start border-primary border-3 ps-2 py-1">
                                                <a href="{{ asset($pa->url) }}" title="Télécharger le plan d'affaire"
                                                    target="_blank" class="text-primary text-decoration-none fw-medium">
                                                    <i class="bx bx-download me-1"></i>Télécharger
                                                </a>
                                                @if ($pa->credit ?? $pa->amount)
                                                    <div class="small text-muted">
                                                        <i class="bx bx-money me-1"></i>
                                                        {{ amount($pa->credit ?? $pa->amount, true) }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted small">Non disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($adherent && $adherent->user)
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('adherent.show', $adherent->user->id) }}"
                                                    class="btn btn-outline-primary btn-sm" title="Voir le profil">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('css-push')
        <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}" />
        <style>
            .filter-card {
                cursor: pointer;
                border: 2px solid transparent;
                background-color: transparent;
                transition: all 0.2s ease-in-out;
                user-select: none;
                min-width: 80px;
            }

            .filter-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                background-color: rgba(0, 0, 0, 0.02);
            }

            .filter-card.active {
                border-color: #5a8dee !important;
                background-color: #f2f4f8 !important;
                box-shadow: 0 4px 12px rgba(90, 141, 238, 0.2) !important;
                transform: translateY(-2px);
            }

            .filter-card .badge {
                transition: transform 0.2s ease;
            }

            .filter-card:hover .badge {
                transform: scale(1.05);
            }
        </style>
    @endpush

    @push('js-push')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const setupTableFilter = function () {
                    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#datatable--barm')) {
                        const table = $('#datatable--barm').DataTable();
                        let currentFilter = 'all';

                        $('.filter-card').on('click', function () {
                            const filter = $(this).data('filter');

                            if (currentFilter === filter && filter !== 'all') {
                                currentFilter = 'all';
                            } else {
                                currentFilter = filter;
                            }

                            $('.filter-card').removeClass('active');
                            $(`.filter-card[data-filter="${currentFilter}"]`).addClass('active');

                            if (currentFilter === 'deferred') {
                                table.column(5).search('Différé').draw();
                            } else if (currentFilter === 'refused') {
                                table.column(5).search('Refusé').draw();
                            } else if (currentFilter === 'resignation') {
                                table.column(5).search('Abandon').draw();
                            } else {
                                table.column(5).search('').draw();
                            }
                        });
                    } else {
                        setTimeout(setupTableFilter, 100);
                    }
                };

                setupTableFilter();
            });
        </script>
    @endpush
@endsection