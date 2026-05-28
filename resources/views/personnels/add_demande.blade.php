@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">Demande ></span> Enregistrement d'une demande
            </h4>

            <div class="card">
                <div class="card-header px-4 py-3 border-bottom">
                    <h5 class="mb-0">SOUMISSION D'UNE DEMANDE</h5>
                </div>
                <div class="row"><br></div>
                <div class="card-body p-4">
                    <form class="row g-3" method="POST" action="{{ route('leave.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="leave_type" class="form-label">Type de la demande<span class="text-danger"> *</span></label>
                                <select class="form-select leave-type-select @error('leave_type') is-invalid @enderror" aria-label="Type de la demande" name="leave_type">
                                    <option value="" disabled {{ old('leave_type') == '' ? 'selected' : '' }}>Sélectionner</option>
                                    <option value="Permission" {{ old('leave_type') == 'Permission' ? 'selected' : '' }}>Permission</option>
                                    <option value="Congé" {{ old('leave_type') == 'Congé' ? 'selected' : '' }}>Congé</option>
                                </select>
                                @error('leave_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="leavefrom" class="form-label">Date départ<span class="text-danger"> *</span></label></label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('leavefrom') is-invalid @enderror" id="leavefrom" name="leavefrom" value="{{ old('leavefrom') }}" placeholder="Date de prise de service (BARM)">
                                    @error('leavefrom')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="leaveto" class="form-label">Date retour<span class="text-danger"> *</span></label></label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('leaveto') is-invalid @enderror" id="leaveto" name="leaveto" value="{{ old('leaveto') }}" placeholder="Date de prise de service (BARM)">
                                    @error('leaveto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="nb_day" class="form-label">Nbre de jours</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nb_day" name="nb_day" value="{{ old('nb_day') }}" placeholder="Nombre de jours" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="returndate" class="form-label">Date reprise<span class="text-danger"> *</span></label></label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('returndate') is-invalid @enderror" id="returndate" name="returndate" value="{{ old('returndate') }}" placeholder="Date de prise de service (BARM)">
                                    @error('returndate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="reason" class="form-label label">Raisons/Motif<span class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <textarea class="form-control reason @error('reason') is-invalid @enderror" id="reason" placeholder="Préciser" name="reason" rows="5">{{ old('reason') }}</textarea>
                                    @error('reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="formFile" class="form-label label">Pièce justificative</label>
                                <div class="input-group">
                                        <input class="form-control fileAttachment" type="file" name="fileAttachment" id="fileAttachment" accept=".pdf">
                                    </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                    <a href="{{ route('leave.leavelist') }}" type="reset" class="btn btn-danger px-4">Annuler</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js-push')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        $(document).ready(function() {
            $('.leave-type-select').change(function() {
                if ($(this).val() === 'Congé') {
                    $('.reason,.fileAttachment').hide();
                    $('.label').hide();
                } else {
                    $('.reason,.fileAttachment').show();
                    $('.label').show();
                }
            });
        });
    </script>
@endpush
@endsection
