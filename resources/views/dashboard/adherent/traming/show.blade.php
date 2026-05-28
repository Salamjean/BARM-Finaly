@extends('layouts.app')

@section('content')
    <div class="container pt-2">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Candidatures/</span> {{ $title }}/ <span
                @php echo statusCandidature($training->status, 'css'); @endphp>{{ statusCandidature($training->status) }}</span>
        </h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-content-center align-items-center text-info">
                            <div class="px-1">Voir infos</div>
                            <div>
                                @include('partials.adherent', ['candidature' => $training->candidature])
                            </div>
                        </div>


                        <h5 class="pb-2 border-bottom mt-4">Informations personnelles</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Nom et prénoms:</span>
                                    <span>{{ $training->candidature->user->fullName() }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Mecano / Matricule:</span>
                                    <span>{{ $training->candidature->user->mecano }}</span>
                                </li>
                                @if ($training->candidature->birth_date)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Date de naissance:</span>
                                        <span>{{ dateFr($training->candidature->birth_date) }}</span>
                                    </li>
                                @endif
                                @if ($training->candidature->phone_number)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Numéro de téléphone:</span>
                                        <span>{{ $training->candidature->phone_number }}</span>
                                    </li>
                                @endif
                                @if ($training->candidature->user->email)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Email:</span>
                                        <span>{{ $training->candidature->user->email }}</span>
                                    </li>
                                @endif
                                @if ($training->candidature->orientation)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Orientation:</span>
                                        <span
                                            class="text-info text-uppercase">{{ statusCandidature($training->candidature->orientation, 'orientation') }}</span>
                                    </li>
                                @endif
                                @if ($training->candidature->gender)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Genre:</span>
                                        <span>{{ $training->candidature->gender }}</span>
                                    </li>
                                @endif
                                @if ($training->candidature->religion)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Réligion:</span>
                                        <span>{{ $training->candidature->religion }}</span>
                                    </li>
                                @endif
                                @if ($training->candidature->ethnic)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Ethnie:</span>
                                        <span>{{ $training->candidature->ethnic }}</span>
                                    </li>
                                @endif

                                @if ($training->candidature->situation_matrimoniale)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Sitatuation matrimoniale:</span>
                                        <span>{{ $training->candidature->situation_matrimoniale }}</span>
                                    </li>
                                @endif

                                @if ($training->candidature->residence)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Résidence:</span>
                                        <span>{{ $training->candidature->residence }}</span>
                                    </li>
                                @endif

                                @if (count($training->candidature->childs) > 0)
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">Nombre d'enfant:</span>
                                        <span>{{ count($training->candidature->childs) }}</span>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @if (can('partner-technical'))

                    @if ($training->status !== 'search_financial_partner' && $training->status !== 'finish')
                        <form action="{{ route('adherent.training.update', $training->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mt-4">
                                        @if ($training->status === 'pending')
                                            <div class="col-md-12">
                                                <label for="date_debut" class="form-label">Entrez la date de début de
                                                    formation<span class="text-danger">
                                                        *</span></label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="date_debut"
                                                        name="date_debut" value="{{ date('Y-m-d') }}" required />
                                                </div>
                                            </div>
                                        @endif
                                        @if ($training->status === 'in_progress')
                                            <div class="col-md-12">
                                                <label for="date_debut" class="form-label">Date début de formation</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control"
                                                        value="{{ $training->date_debut }}" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="date_fin" class="form-label">Date fin de formation<span
                                                        class="text-danger">
                                                        *</span></label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="date_fin"
                                                        name="date_fin" value="{{ old('date_fin') ?? date('Y-m-d') }}"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="observation" class="form-label">Observation<span
                                                        class="text-danger">
                                                        *</span></label>
                                                <div class="input-group">
                                                    <textarea class="form-control" rows="10" id="observation" name="observation" placeholder="Votre observation"
                                                        required>{{ old('observation') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="file_attachment" class="form-label">Plan d&apos;affaire<span
                                                        class="text-danger">
                                                        *</span></label>
                                                <div class="input-group">
                                                    <input type="file" accept=".pdf" class="form-control"
                                                        id="file_attachment" name="file_attachment" required />
                                                </div>
                                            </div>
                                        @endif
                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-4" style="gap: 20px;">
                                    <div class="col-md-12">
                                        <label for="date_debut" class="form-label">Date début de formation</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                value="{{ $training->date_debut }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="date_fin" class="form-label">Date fin de formation</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="date_fin" name="date_fin"
                                                value="{{ $training->date_fin }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="observation" class="form-label">Observation</label>
                                        <div class="input-group">
                                            <textarea class="form-control" rows="10" id="observation" name="observation" placeholder="Votre observation"
                                                readonly>{{ $training->observation }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div
                                            class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                            <div>Plan d&apos;affaire</div>
                                            <div>
                                                <a href="{{ asset($training->file_attachment) }}" download>
                                                    <i class='bx bx-cloud-download fs-2'></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    @if ($training->candidature->orientation === 'auto-emploi')
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-4" style="gap: 20px;">
                                    @if ($training->date_debut)
                                        <div class="col-md-12">
                                            <label for="date_debut" class="form-label">Date début de formation</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control"
                                                    value="{{ $training->date_debut }}" readonly />
                                            </div>
                                        </div>
                                    @endif

                                    @if ($training->date_fin)
                                        <div class="col-md-12">
                                            <label for="date_fin" class="form-label">Date fin de formation</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="date_fin"
                                                    name="date_fin" value="{{ $training->date_fin }}" readonly />
                                            </div>
                                        </div>
                                    @endif

                                    @if ($training->observation)
                                        <div class="col-md-12">
                                            <label for="observation" class="form-label">Observation</label>
                                            <div class="input-group">
                                                <textarea class="form-control" rows="10" id="observation" name="observation" placeholder="Votre observation"
                                                    readonly>{{ $training->observation }}</textarea>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($training->file_attachment)
                                        <div class="col-md-12">
                                            <div
                                                class="border rounded-2 d-flex justify-content-between align-items-center p-1 px-2">
                                                <div>Plan d&apos;affaire</div>
                                                <div>
                                                    <a href="{{ asset($training->file_attachment) }}" download>
                                                        <i class='bx bx-cloud-download fs-2'></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif($training->candidature->orientation !== 'auto-emploi' && $training->status === 'finish')
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-4" style="gap: 20px;">
                                    @if ($training->date_debut)
                                        <div class="col-md-12">
                                            <label for="date_debut" class="form-label">Date début de formation</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control"
                                                    value="{{ $training->date_debut }}" readonly />
                                            </div>
                                        </div>
                                    @endif

                                    @if ($training->date_fin)
                                        <div class="col-md-12">
                                            <label for="date_fin" class="form-label">Date fin de formation</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="date_fin"
                                                    name="date_fin" value="{{ $training->date_fin }}" readonly />
                                            </div>
                                        </div>
                                    @endif

                                    @if ($training->observation)
                                        <div class="col-md-12">
                                            <label for="observation" class="form-label">Observation</label>
                                            <div class="input-group">
                                                <textarea class="form-control" rows="10" id="observation" name="observation" placeholder="Votre observation"
                                                    readonly>{{ $training->observation }}</textarea>
                                            </div>
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('adherent.training.update', $training->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mt-4" style="gap: 20px;">
                                        <div class="col-md-12">
                                            <label for="" class="form-label">Date début de formation</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control"
                                                    value="{{ $training->date_debut }}" readonly />
                                            </div>
                                        </div>

                                        @if ($training->lieu_form)
                                            <div class="col-md-12">
                                                <label for="" class="form-label">Lieu de la formation</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $training->lieu_form }}" readonly />
                                                </div>
                                            </div>
                                        @endif


                                        <div class="col-md-12">
                                            <label for="date_fin" class="form-label">Date fin de formation</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="date_fin"
                                                    name="date_fin" value="{{ $training->date_fin }}" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="observation" class="form-label">Observation</label>
                                            <div class="input-group">
                                                <textarea class="form-control" rows="10" id="observation" name="observation" placeholder="Votre observation">{{ $training->observation }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                                    <button type="submit"
                                                        class="btn btn-primary px-4">Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif

                @endif
            </div>
        </div>
    </div>
@endsection
