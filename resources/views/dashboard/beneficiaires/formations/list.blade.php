@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">FORMATIONS > </span> {{$title}}
        </h4>
        <div class="card">
            <h5 class="card-header">Formations enregistrés</h5>
            <div class="card-body">
                <form action="{{route('beneficiaire.formSearch')}}" method="POST" class="form-inline responsive-filter-form needs-validation mb-2" novalidate autocomplete="off" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12">
                      <div class="row g-1">
                            <div class="col-sm-4">
                                <select class="form-control form-control-sm mr-1 @error('listbenef') is-invalid @enderror" aria-label="Liste de bénéficiaire" name="listbenef" required>
                                    <option value="">Sélectionner</option>
                                    @foreach ($candidatures as $cand)
                                        <option value="{{ $cand->id }}">{{ $cand->user->fullName() }}</option>
                                    @endforeach
                                </select>
                                @error('listbenef')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <input name="date_insertion" type="date" class="airdatepicker form-control form-control-sm mr-1 @error('date_insertion') is-invalid @enderror" required>
                                @error('date_insertion')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                          <div class="col-sm-4">
                            <button class="btn btn-secondary btn-sm">
                                <i class="fas fa-filter">&nbsp;&nbsp;</i><span class="button-with-icon"> Filtrer</span>
                            </button>
                          </div>
                      </div>
                      <br>
                    </div>
                </form>
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
                                <th>Effectuée par</th>
                                <th>Crée le</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if($formations->isEmpty())
                                <tr><td colspan="10" class="text-center">Aucune données trouvées.</td></tr>
                            @else
                                @foreach($formations as $form)
                                    @if ($form->formation == 'Oui')
                                    <tr>
                                        @php
                                            $beneficiaire = $form->formationBeneficiaire->user->fullName();
                                        @endphp
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="text-dark fw-bold fs-6">{{$form->reference}}</td>
                                        <td class="fw-bold">{{ $beneficiaire }}</td>
                                        <td class="text-center fw-bold">
                                            @if ($form->orientation == 'auto-emploi')<span class="badge bg-info">{{$form->orientation}}</span>
                                                @else<span class="badge bg-warning">{{$form->orientation}}</span>@endif
                                        </td>
                                        <td>
                                            @if ($form->Validation_PA == NULL)
                                            <span class="badge bg-label-danger me-1"> Non-validé</span>@else<span class="badge bg-success me-1">Validé</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($form->Approbation_PA == NULL)
                                            <span class="badge bg-label-danger me-1"> Non-approuvé</span>@else<span class="badge bg-success me-1">Approuvé</span>
                                            @endif</td>
                                        <td><span class="badge bg-label-dark me-1">{{ $form->operateur->username }}</span></td>
                                        <td>{{ date('d/m/Y - H:i', strtotime($form->created_at)) }}</td>
                                        <td><span class="badge bg-label-warning me-1">{{$form->status}}</span></td>
                                        <td class="text-right">
                                            @if (($form->file_attachment1 ?? null) != null)
                                            <a href="{{ asset('assets/faces/pj/' . $form->file_attachment1) }}" class="btn btn-sm btn-primary btn-rounded" title="Télécharger le plan d'affaire" download="{{ $form->file_attachment1 }}"><i class="fas fa-paperclip"></i></a>
                                            @elseif (($form->file_attachment2 ?? null) != null)
                                            <a href="{{ asset('assets/faces/pj/' . $form->file_attachment2) }}" class="btn btn-sm btn-outline-primary btn-rounded" title="Télécharger le plan d'affaire" download="{{ $form->file_attachment2 }}"><i class="fas fa-paperclip"></i></a>
                                            @endif
                                            {{-- @if ($form->formation == 'Oui')
                                            <a href="#" class="btn btn-sm btn-info btn-rounded" title="Voir détails de la formation"><i class="fas fa-eye"></i></a>
                                            @endif --}}
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
