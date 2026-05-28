@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande ></span> Edition d'une demande
            </h4>
            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">MODIFICATION DE VOTRE DEMANDE</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" id="edit-leave-form" method="POST" action="{{ route('leave.update', $leaves->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="leave_type" class="form-label">Type de la demande</label>
                                <select class="form-select" aria-label="Type de la demande" name="leave_type"  disabled>
                                    <option {{ $leaves->leave_type == 'Permission' ? 'selected' : '' }}>Permission</option>
                                    <option {{ $leaves->leave_type == 'Congé' ? 'selected' : '' }}>Congé</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="leavefrom" class="form-label">Date départ</label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('leavefrom') is-invalid @enderror" id="leavefrom" name="leavefrom" value="{{ old('leavefrom') ?? $leaves->leavefrom }}">
                                </div>
                                @error('leavefrom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="leaveto" class="form-label">Date retour</label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('leaveto') is-invalid @enderror" id="leaveto" name="leaveto" value="{{ old('leaveto') ?? $leaves->leaveto }}">
                                </div>
                                @error('leaveto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="nb_day" class="form-label">Nbre de jours</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('nb_day') is-invalid @enderror" id="nb_day" name="nb_day" value="{{ old('nb_day') ?? $leaves->nb_day }}" readonly>
                                </div>
                                @error('nb_day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="returndate" class="form-label">Date reprise</label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('leave_recovery') is-invalid @enderror" id="returndate" name="returndate" value="{{ old('returndate') ?? $leaves->returndate }}" placeholder="Date de prise de service (BARM)">
                                </div>
                                @error('returndate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if ($leaves->leave_type == 'Permission')
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="reason" class="form-label">Raisons/Motif</label>
                                <div class="input-group">
                                    <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" placeholder="Préciser" name="reason" rows="5">{{ old('reason') ?? $leaves->reason }}</textarea>
                                </div>
                                @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                             @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="formFile" class="form-label">Pièce justificative</label>
                                <div class="input-group">
                                    <input class="form-control" type="file" id="formFile" name="file">
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row mt-2" style="display: none">
                        </div>
                        @endif
                        <div class="row mt-5">
                            <div class="footer">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                                <a href="{{ route('leave.leavelist') }}" class="btn btn-secondary">
                                    <span class="button-with-icon"> Annuler</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js-push')
    <script>
            document.addEventListener('DOMContentLoaded', function() {

                const leaveFromInput = document.getElementById('leavefrom');
                const leaveToInput = document.getElementById('leaveto');
                const nbDayInput = document.getElementById('nb_day');

                function calculateDays(startDate, endDate) {
                    const oneDay = 24 * 60 * 60 * 1000;
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const diffDays = Math.round(Math.abs((start - end) / oneDay));
                    return diffDays;
                }

                function updateNbDay() {
                    const startDate = leaveFromInput.value;
                    const endDate = leaveToInput.value;
                    if (startDate && endDate) {
                        const days = calculateDays(startDate, endDate);
                        nbDayInput.value = days;
                    } else {
                        nbDayInput.value = '';
                    }
                }

                leaveFromInput.addEventListener('change', updateNbDay);
                leaveToInput.addEventListener('change', updateNbDay);

                updateNbDay();
            });
    </script>
    <script>
        document.getElementById('edit-leave-form').addEventListener('submit', function(e) {
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'leave_type';
            hiddenInput.value = '{{ $leaves->leave_type }}'; // Assurez-vous que la valeur est correctement échappée
            e.target.appendChild(hiddenInput);
        });
    </script>
@endpush
@endsection
