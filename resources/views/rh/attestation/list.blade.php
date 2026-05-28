@extends('layouts.app', ['title' => $title])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">CERTIFICAT > </span> {{$title}}
    </h4>
    <div class="card">
        <h5 class="card-header">Personnels enregistrés</h5>
        <div class="card-body">
            <form action="{{route('certificat.attestationSearch')}}" method="POST" class="form-inline responsive-filter-form needs-validation mb-2" novalidate autocomplete="off" accept-charset="utf-8">
                @csrf

            </form>
              <br>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-striped" style="width:100%" id="datatable--barm">
                    <thead class="table-dark">
                        <tr>
                            <th>N°</th>
                            <th>Matricule BARM</th>
                            <th>Nom & Prénom(s)</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Prise de service</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                     @if($pers->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center">Aucune données trouvées.</td>
                        </tr>
                      @else
                             @foreach($pers as $personnel)
                                <tr>
                                    <td class="text-dark fw-bold fs-6">{{ $loop->index + 1 }}</td>
                                    <td>{{$personnel->matricule_barm}}</td>
                                    <td>{{$personnel->fullName()}}</td>
                                    <td>{{$personnel->phone}}</td>
                                    <td>{{$personnel->email}}</td>
                                    <td>{{$personnel->date_prise_service_barm}}</td>
                                    <td class="text-right">
                                        <select class="certificate-select form-control btn-outline-secondary btn-sm">
                                            <option value="">Télécharger</option>
                                            <option value="{{ route('certificat.attestationPdf', $personnel->id) }}">Attestation travail</option>
                                            <option value="{{ route('certificat.postPdf', $personnel->id) }}">Attestation présence</option>
                                            {{--
                                                <option value="{{ route('certificat.repriseServicePdf', $personnel->id) }}">Certificat reprise service</option>
                                                <option value="{{ route('certificat.demandeCongePdf', $personnel->id) }}">Attestation congé</option>
                                                <option value="{{ route('certificat.travailPdf', $personnel->id) }}">Attestation</option>
                                                <option value="{{ route('certificat.noteservicePdf', $personnel->id) }}">Note de service</option> --}}
                                        </select>
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
@push('js-push')
<script>
    document.querySelectorAll('.certificate-select').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                window.location.href = selectedOption.value;
            }
        });
    });
</script>
@endpush
@endsection
