<div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
    <div class="container-fluid bg-white p-4">

        @if ($user->candidate->candidatentretiens()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-chat text-primary fs-4 me-3"></i>
                    <h4 class="mb-0 text-primary">Entretiens
                        <span class="badge bg-secondary ms-2">{{ count($user->candidate->candidatentretiens) }}</span>
                    </h4>
                </div>

                <div class="row g-4">
                    @foreach ($user->candidate->candidatentretiens as $key => $candidatentretien)
                        <div class="col-lg-6">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-info text-white fs-6 px-3 py-2">
                                        Entretien {{ $key + 1 }}
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="badge {{ $candidatentretien->presence == '1' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $candidatentretien->presence == '1' ? 'Présent' : 'Absent' }}
                                        </span>
                                        @if (can('chef-cellule-formation-et-insertion'))
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteEntretien({{ $candidatentretien->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="mb-2 text-dark">{{ $candidatentretien->entretien->type }}</h5>

                                <div class="table-responsive mb-3">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Date de tenue</td>
                                                <td class="text-end">
                                                    {{ dateFr($candidatentretien->entretien->date, 'letter') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Présence</td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge {{ $candidatentretien->presence == '1' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $candidatentretien->presence == '1' ? 'OUI' : 'NON' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($user->candidate->bilancompetences()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-chart text-info fs-4 me-3"></i>
                    <h4 class="mb-0 text-info">Bilans de Compétences
                        <span class="badge bg-secondary ms-2">{{ count($user->candidate->bilancompetences) }}</span>
                    </h4>
                </div>

                <div class="row g-4">
                    @foreach ($user->candidate->bilancompetences as $key => $bilancompetence)
                        <div class="col-lg-6">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                        Bilan {{ $key + 1 }}
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($bilancompetence->rapport)
                                            <a href="{{ asset($bilancompetence->rapport) }}"
                                                class="btn btn-primary btn-sm" download>
                                                <i class="bx bx-download me-1"></i> Rapport
                                            </a>
                                        @endif
                                        @if (can('chef-cellule-formation-et-insertion'))
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteBilan({{ $bilancompetence->id }})">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="mb-2 text-dark">{{ dateFr($bilancompetence->date, 'letter') }}</h5>

                                <div class="table-responsive mb-3">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Présence</td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge {{ $bilancompetence->presence == '1' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $bilancompetence->presence == '1' ? 'OUI' : 'NON' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Rapport</td>
                                                <td class="text-end">
                                                    @if ($bilancompetence->rapport)
                                                        <span class="badge bg-success">Disponible</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non disponible</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($user->candidate->soumissiondossiers()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-folder-open text-success fs-4 me-3"></i>
                    <h4 class="mb-0 text-success">Dépôts de Dossiers
                        <span class="badge bg-secondary ms-2">{{ count($user->candidate->soumissiondossiers) }}</span>
                    </h4>
                </div>

                @foreach ($user->candidate->soumissiondossiers as $key => $soumissiondossier)
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-primary fs-6 px-3 py-2">Dépôt {{ $key + 1 }}</span>
                            @if (can('chef-cellule-formation-et-insertion'))
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="deleteDossier({{ $soumissiondossier->id }})">
                                <i class="bx bx-trash"></i>
                            </button>
                            @endif
                        </div>

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border-start border-success border-3 ps-4 py-3 bg-light bg-opacity-25">
                                    <h5 class="mb-3 text-success">Premier Choix</h5>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Date de dépôt</td>
                                                    <td class="text-end">
                                                        {{ dateFr($soumissiondossier->date1, 'letter') }}</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Type de concours</td>
                                                    <td class="text-end">
                                                        <strong>{{ $soumissiondossier->type_concours1 }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Intitulé du concours</td>
                                                    <td class="text-end">{{ $soumissiondossier->intitule_concours1 }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="border-start border-info border-3 ps-4 py-3 bg-light bg-opacity-25">
                                    <h5 class="mb-3 text-info">Deuxième Choix</h5>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Date de dépôt</td>
                                                    <td class="text-end">
                                                        {{ dateFr($soumissiondossier->date2, 'letter') }}</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Type de concours</td>
                                                    <td class="text-end">
                                                        <strong>{{ $soumissiondossier->type_concours2 }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Intitulé du concours</td>
                                                    <td class="text-end">{{ $soumissiondossier->intitule_concours2 }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($user->candidate->choixconcour()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-target-lock text-warning fs-4 me-3"></i>
                    <h4 class="mb-0 text-warning">Choix Final</h4>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bx bx-check-circle text-success fs-5 me-2"></i>
                                <h5 class="mb-0 text-success">Choix Définitif</h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr class="border-bottom">
                                            <td class="text-muted">Type de concours</td>
                                            <td class="text-end"><strong
                                                    class="text-success">{{ $user->candidate->choixconcour->type_concours }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Intitulé du concours</td>
                                            <td class="text-end">
                                                {{ $user->candidate->choixconcour->intitule_concours }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($user->candidate->concours()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-trophy text-primary fs-4 me-3"></i>
                    <h4 class="mb-0 text-primary">Concours
                        <span class="badge bg-secondary ms-2">{{ count($user->candidate->concours) }}</span>
                    </h4>
                </div>

                <div class="row g-4">
                    @foreach ($user->candidate->concours as $key => $concour)
                        <div class="col-lg-6">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-primary text-white fs-6 px-3 py-2">
                                        Inscription {{ $key + 1 }}
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($concour->recu)
                                            <a href="{{ asset($concour->recu) }}" class="btn btn-primary btn-sm"
                                                download>
                                                <i class="bx bx-download me-1"></i> Reçu
                                            </a>
                                        @endif
                                        <span
                                            class="badge {{ $concour->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $concour->status == '1' ? 'Admis' : 'Refusé' }}
                                        </span>
                                        @if (can('chef-cellule-formation-et-insertion'))
                                        @if ($concour->status != '1')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteConcour({{ $concour->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        @endif
                                        @endif
                                    </div>
                                </div>

                                <h5 class="mb-2 text-dark">{{ $concour->type_concours }}</h5>
                                <h6 class="mb-4 text-muted">{{ $concour->intitule_concours }}</h6>

                                <div class="table-responsive mb-3">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Date d'inscription</td>
                                                <td class="text-end">{{ dateFr($concour->date, 'letter') }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Reçu</td>
                                                <td class="text-end">
                                                    @if ($concour->recu)
                                                        <span class="badge bg-success">Disponible</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non disponible</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr class="border-bottom">
                                                <td class="text-muted">Statut</td>
                                                @if ($concour->status !== null)
                                                    <td class="text-end">
                                                        <span
                                                            class="badge {{ $concour->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $concour->status == '1' ? 'Admis' : 'Refusé' }}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td class="text-end">
                                                        <span class="badge bg-warning">En attente</span>
                                                    </td>
                                                @endif

                                            </tr>


                                            @if ($concour->admi)
                                                <tr>
                                                    <td class="text-muted">Lieu d'affectation</td>
                                                    <td class="text-end">
                                                        <span>
                                                            {{ $concour->admi->affectation }}
                                                        </span>

                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

@if (can('chef-cellule-formation-et-insertion'))
<script>
    // Fonction pour supprimer un entretien
    function deleteEntretien(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/entretiens/candidatentretiens/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            'Supprimé !',
                            'L\'entretien a été supprimé avec succès.',
                            'success'
                        );
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                });
            }
        });
    }

    // Fonction pour supprimer un bilan de compétences
    function deleteBilan(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/bilancompetences/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            'Supprimé !',
                            'Le bilan de compétences a été supprimé avec succès.',
                            'success'
                        );
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                });
            }
        });
    }


    function deleteDossier(id) {

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/soumissiondossiers/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            'Supprimé !',
                            'Le dossier a été supprimé avec succès.',
                            'success'
                        );
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                });
            }
        });
    }

    function deleteConcour(id) {
        
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/inscriptionconcours/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            'Supprimé !',
                            'Le concours a été supprimé avec succès.',
                            'success'
                        );
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                });
            }
        });
    }
</script>
@endif