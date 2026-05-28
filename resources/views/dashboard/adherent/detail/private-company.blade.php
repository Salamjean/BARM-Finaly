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
                                            <tr class="border-bottom">
                                                <td class="text-muted">Présence</td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge {{ $candidatentretien->presence == '1' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $candidatentretien->presence == '1' ? 'OUI' : 'NON' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Commentaire</td>
                                                <td class="text-end">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#eModal{{ $candidatentretien->id }}"
                                                        class="badge bg-warning text-dark">
                                                        <i class="bx bx-comment me-1"></i> Voir commentaire
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal -->
                                <div id="eModal{{ $candidatentretien->id }}" class="modal fade" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Commentaire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('candidatentretiens.update-comment', $candidatentretien->id) }}" method="POST" class="row g-3"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Commentaire: </label>
                                                            <textarea name="comment" class="form-control" cols="10" rows="5">{{ $candidatentretien->comment }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">Retour</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                                            <tr class="border-bottom">
                                                <td class="text-muted">Rapport</td>
                                                <td class="text-end">
                                                    @if ($bilancompetence->rapport)
                                                        <span class="badge bg-success">Disponible</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non disponible</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Commentaire</td>
                                                <td class="text-end">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#bcModal{{ $bilancompetence->id }}"
                                                        class="badge bg-warning text-dark">
                                                        <i class="bx bx-comment me-1"></i> Voir commentaire
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal -->
                                <div id="bcModal{{ $bilancompetence->id }}" class="modal fade" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Commentaire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('bilancompetences.update-comment', $bilancompetence->id) }}" method="POST" class="row g-3"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Commentaire: </label>
                                                            <textarea name="comment" class="form-control" cols="10" rows="5">{{ $bilancompetence->comment }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">Retour</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($user->candidate->candidatformations()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-book text-success fs-4 me-3"></i>
                    <h4 class="mb-0 text-success">Formations
                        <span class="badge bg-secondary ms-2">{{ count($user->candidate->candidatformations) }}</span>
                    </h4>
                </div>

                <div class="row g-4">
                    @foreach ($user->candidate->candidatformations as $key => $formation)
                        <div class="col-lg-6">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-success text-white fs-6 px-3 py-2">
                                        Formation {{ $key + 1 }}
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($formation->attestation)
                                            <a href="{{ asset($formation->attestation) }}"
                                                class="btn btn-primary btn-sm" download>
                                                <i class="bx bx-download me-1"></i> Attestation
                                            </a>
                                        @endif
                                        <span
                                            class="badge {{ $formation->presence == '1' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $formation->presence == '1' ? 'Présent' : 'Absent' }}
                                        </span>
                                        @if (can('chef-cellule-formation-et-insertion'))
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteFormation({{ $formation->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="mb-2 text-dark">{{ $formation->formation->intitule }}</h5>
                                <h6 class="mb-4 text-muted">{{ $formation->formation->entreprise }}</h6>

                                <div class="table-responsive mb-3">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Période</td>
                                                <td class="text-end">
                                                    <div><strong>Du:</strong>
                                                        {{ dateFr($formation->formation->date_db, 'letter') }}</div>
                                                    <div><strong>Au:</strong>
                                                        {{ dateFr($formation->formation->date_fin, 'letter') }}</div>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Lieu</td>
                                                <td class="text-end">{{ $formation->formation->lieu }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Présence</td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge {{ $formation->presence == '1' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $formation->presence == '1' ? 'OUI' : 'NON' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Attestation</td>
                                                <td class="text-end">
                                                    @if ($formation->attestation)
                                                        <span class="badge bg-success">Disponible</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non disponible</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Commentaire</td>
                                                <td class="text-end">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#formationModal{{ $formation->id }}"
                                                        class="badge bg-warning text-dark">
                                                        <i class="bx bx-comment me-1"></i> Voir commentaire
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal -->
                                <div id="formationModal{{ $formation->id }}" class="modal fade" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Commentaire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('candidatformations.update-comment', $formation->id) }}" method="POST" class="row g-3"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Commentaire: </label>
                                                            <textarea name="commentaire" class="form-control" cols="10" rows="5">{{ $formation->commentaire }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">Retour</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($user->candidate->cvlms()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-file-blank text-warning fs-4 me-3"></i>
                    <h4 class="mb-0 text-warning">CV et Lettres de Motivation
                        <span class="badge bg-secondary ms-2">{{ count($user->candidate->cvlms) }}</span>
                    </h4>
                </div>

                <div class="row g-4">
                    @foreach ($user->candidate->cvlms as $key => $cvlm)
                        <div class="col-lg-6">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                        CV/LM {{ $key + 1 }}
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($cvlm->cv)
                                            <a href="{{ asset($cvlm->cv) }}" class="btn btn-primary btn-sm" download>
                                                <i class="bx bx-download me-1"></i> CV
                                            </a>
                                        @endif
                                        @if ($cvlm->lm)
                                            <a href="{{ asset($cvlm->lm) }}" class="btn btn-info btn-sm" download>
                                                <i class="bx bx-download me-1"></i> LM
                                            </a>
                                        @endif
                                        @if (can('chef-cellule-formation-et-insertion'))
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteCvlm({{ $cvlm->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="mb-2 text-dark">{{ $cvlm->poste }}</h5>

                                <div class="table-responsive mb-3">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted">CV</td>
                                                <td class="text-end">
                                                    @if ($cvlm->cv)
                                                        <span class="badge bg-success">Disponible</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non disponible</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Lettre de Motivation</td>
                                                <td class="text-end">
                                                    @if ($cvlm->lm)
                                                        <span class="badge bg-success">Disponible</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non disponible</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Commentaire</td>
                                                <td class="text-end">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#cvModal{{ $cvlm->id }}"
                                                        class="badge bg-warning text-dark">
                                                        <i class="bx bx-comment me-1"></i> Voir commentaire
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal -->
                                <div id="cvModal{{ $cvlm->id }}" class="modal fade" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Commentaire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('cvlms.update-comment', $cvlm->id) }}" method="POST" class="row g-3"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Commentaire: </label>
                                                            <textarea name="commentaire" class="form-control" cols="10" rows="5">{{ $cvlm->commentaire }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">Retour</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($user->candidate->prepaentretiens()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-user-voice text-info fs-4 me-3"></i>
                    <h4 class="mb-0 text-info">Préparations d'Entretien
                        <span class="badge bg-secondary ms-2">{{ count($user->candidate->prepaentretiens) }}</span>
                    </h4>
                </div>

                <div class="row g-4">
                    @foreach ($user->candidate->prepaentretiens as $key => $prepaentretien)
                        <div class="col-lg-6">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-info text-white fs-6 px-3 py-2">
                                        Prépa-Entretien {{ $key + 1 }}
                                    </span>
                                    @if (can('chef-cellule-formation-et-insertion'))
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deletePrepaEntretien({{ $prepaentretien->id }})">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    @endif
                                </div>

                                <div class="table-responsive mb-3">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Date</td>
                                                <td class="text-end">{{ dateFr($prepaentretien->date, 'letter') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Commentaire</td>
                                                <td class="text-end">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#commentModal{{ $prepaentretien->id }}"
                                                        class="badge bg-warning text-dark">
                                                        <i class="bx bx-comment me-1"></i> Voir commentaire
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal -->
                                <div id="commentModal{{ $prepaentretien->id }}" class="modal fade" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Commentaire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('prepaentretiens.update-comment', $prepaentretien->id) }}" method="POST" class="row g-3"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Commentaire: </label>
                                                            <textarea name="commentaire" class="form-control" cols="10" rows="5">{{ $prepaentretien->commentaire }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">Retour</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($user->candidate->candidatentreprises()->exists())
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <i class="bx bx-send text-primary fs-4 me-3"></i>
                    <h4 class="mb-0 text-primary">Candidatures Envoyées
                        <span
                            class="badge bg-secondary ms-2">{{ count($user->candidate->candidatentreprises) }}</span>
                    </h4>
                </div>

                <div class="row g-4">
                    @foreach ($user->candidate->candidatentreprises as $key => $candidatentreprise)
                        <div class="col-lg-6">
                            <div class="border rounded-3 p-4 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-primary text-white fs-6 px-3 py-2">
                                        Candidature {{ $key + 1 }}
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($candidatentreprise->statut === 'accepted' && $candidatentreprise->contrat)
                                            <a href="{{ asset($candidatentreprise->contrat) }}"
                                                class="btn btn-primary btn-sm" download>
                                                <i class="bx bx-download me-1"></i> Attestation
                                            </a>
                                        @endif
                                        @if ($candidatentreprise->statut === 'pending')
                                            <span class="badge bg-info">Envoyé</span>
                                        @elseif($candidatentreprise->statut === 'refused')
                                            <span class="badge bg-danger">Refusé</span>
                                        @elseif($candidatentreprise->statut === 'finished')
                                            <span class="badge bg-secondary">Terminé</span>
                                        @elseif($candidatentreprise->statut === 'accepted')
                                            <span class="badge bg-success">Accepté</span>
                                        @endif
                                        @if (can('chef-cellule-formation-et-insertion'))
                                            @if ($candidatentreprise->statut !== 'accepted')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteCandidature({{ $candidatentreprise->id }})">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <h5 class="mb-2 text-dark">{{ $candidatentreprise->poste }}</h5>
                                <h6 class="mb-4 text-muted">{{ $candidatentreprise->entreprise }}</h6>

                                <div class="table-responsive mb-3">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Date de mise à disposition</td>
                                                <td class="text-end">
                                                    {{ dateFr($candidatentreprise->date_mise_disposition, 'letter') }}
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted">Statut</td>
                                                <td class="text-end">
                                                    @if ($candidatentreprise->statut === 'pending')
                                                        <span class="badge bg-info">Envoyé</span>
                                                    @elseif($candidatentreprise->statut === 'refused')
                                                        <span class="badge bg-danger">Refusé</span>
                                                    @elseif($candidatentreprise->statut === 'finished')
                                                        <span class="badge bg-secondary">Terminé</span>
                                                    @elseif($candidatentreprise->statut === 'accepted')
                                                        <span class="badge bg-success">Accepté</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($candidatentreprise->statut === 'accepted')
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Type de contrat</td>
                                                    <td class="text-end"><strong
                                                            class="text-success">{{ $candidatentreprise->type_contrat }}</strong>
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Période</td>
                                                    <td class="text-end">
                                                        <div><strong>Du:</strong>
                                                            {{ dateFr($candidatentreprise->date_db, 'letter') }}</div>
                                                        <div><strong>Au:</strong>
                                                            {{ dateFr($candidatentreprise->date_fin, 'letter') }}</div>
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Lieu</td>
                                                    <td class="text-end">{{ $candidatentreprise->localisation }}</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted">Attestation de travail</td>
                                                    <td class="text-end">
                                                        @if ($candidatentreprise->contrat)
                                                            <span class="badge bg-success">Disponible</span>
                                                        @else
                                                            <span class="badge bg-secondary">Non disponible</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted">Commentaire</td>
                                                <td class="text-end">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#candidatModal{{ $candidatentreprise->id }}"
                                                        class="badge bg-warning text-dark">
                                                        <i class="bx bx-comment me-1"></i> Voir commentaire
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal -->
                                <div id="candidatModal{{ $candidatentreprise->id }}" class="modal fade"
                                    tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Commentaire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('candidatentreprises.update-comment', $candidatentreprise->id) }}" method="POST" class="row g-3"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <textarea name="commentaire" class="form-control" cols="15" rows="10">{{ $candidatentreprise->commentaire }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">Retour</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                    //route('entretiens.destroy_candidatentretiens', id)
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

        // Fonction pour supprimer une formation
        function deleteFormation(id) {
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
                        url: '/formations/candidatformations/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            Swal.fire(
                                'Supprimé !',
                                'La formation a été supprimée avec succès.',
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

        // Fonction pour supprimer un CV/LM
        function deleteCvlm(id) {
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
                        url: '/cvlms/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire(
                                'Supprimé !',
                                'Le CV/Lettre de motivation a été supprimé avec succès.',
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

        // Fonction pour supprimer une préparation d'entretien
        function deletePrepaEntretien(id) {
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
                        url: '/prepaentretiens/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire(
                                'Supprimé !',
                                'La préparation d\'entretien a été supprimée avec succès.',
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

        // Fonction pour supprimer une candidature
        function deleteCandidature(id) {
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
                        url: '/candidatentreprises/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire(
                                'Supprimé !',
                                'La candidature a été supprimée avec succès.',
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
