@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Candidatures/</span> {{ $title }}
    </h4>

    <div class="card">
        <h5 class="card-header mt-2">{{ $title }}</h5>
        <div class="card-header d-flex justify-content-end">
            <div class="btn-group">
                @if ($formation_beneficiaire->partner_financial_id == null)
                    <a data-bs-toggle="modal" data-bs-target="#addNewCCModal" type="button" class="btn btn-primary">Choisir un partenaires
                        financier</a>
                @endif
                
                
                <!-- Add New Credit Card Modal -->
                <div class="modal fade" id="addNewCCModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-body">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                <div class="text-center mb-4">
                                    <h3>Choisir un partenaire financier</h3>
                                    {{-- <p>Add new card to complete payment</p> --}}
                                </div>
                                <form action="{{route('adherent.training.choice_partner_financial',$formation_beneficiaire->id)}}" method="POST" class="row g-3">
                                    @csrf
                                    <div class="col-12 col-md-12">
                                        <label class="form-label" for="modalAddCardName1">Candidat</label>
                                        <input type="text" id="modalAddCardName1" value="{{ $formation_beneficiaire->candidature->user->firstname }} {{ $formation_beneficiaire->candidature->user->lastname }}" class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <label class="form-label" for="modalAddCardName">Partenaires techniques</label>
                                        <select name="partner_financial_id" class="form-control" id="">
                                            <option value="">Selectionner un partenaire technique</option>
                                            @foreach ($financial_partners as $financial_partner)
                                                <option value="{{ $financial_partner->partnerFinancial->id }}">{{ $financial_partner->partnerFinancial->user->username }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-info me-sm-3 me-1">Envoyer</button>
                                        <button type="reset" class="btn btn-danger btn-reset" data-bs-dismiss="modal"
                                            aria-label="Close">Retour</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-body mt-4">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                    <thead class="table-dark">
                        <tr>

                            <th>Date</th>
                            <th>Adhérents</th>
                            <th class="text-center">Statut</th>
                            {{-- <th class="text-center"></th> --}}
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($formations as $formation)
                        <tr>
                            <td>{{ dateFr($formation->created_at, 'complet') }}</td>
                            <td>{{ $formation->partnerFinancial->user->username }}</td>
                            <td class="text-center">
                                @if ($formation->status == 'approuved')
                                    <span class="badge bg-info mb-2">Plan d'affaire approuvé</span>
                                @else
                                    <span class="badge bg-danger mb-2">Plan d'affaire désapprouvé</span>
                                @endif

                                @if ($formation_beneficiaire->partner_financial_id != null)
                                    @php
                                    $partenaire_id = $formations->where('partner_financial_id',$formation_beneficiaire->partner_financial->id)->first()->partner_financial_id;
                                    @endphp
                                    @if ($formation->partner_financial_id == $partenaire_id)
                                        <span class="badge bg-success mb-2">Partenaire choisi</span>
                                    @endif
                                @endif
                            </td>

                            {{-- <td class="d-flex justify-content-center gap-2">

                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection