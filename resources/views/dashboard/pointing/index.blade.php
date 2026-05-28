@extends('layouts.app', ['title' => $title])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Pointages/</span> {{ $title }}
        </h4>
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-body">
                <div  class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                @if (can('chef-barm|responsable-gestionnaire-des-ressources-humaines|assistant-gestionnaire-des-ressources-humaines'))
                                    <th>Personnels</th>
                                @endif
                                <th>Date</th>
                                <th>Heure d'arrivée </th>
                                <th>Heure de départ</th>
                                <th>Status</th>
                                @if (can('chef-barm|responsable-gestionnaire-des-ressources-humaines|assistant-gestionnaire-des-ressources-humaines'))
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($pointings as $pointing)
                                <tr>
                                    @if (can('chef-barm|responsable-gestionnaire-des-ressources-humaines|assistant-gestionnaire-des-ressources-humaines'))
                                        <td>@<a href="#">{{ $pointing->personal->fullName() }}</a></td>
                                    @endif
                                    <td>{{ dateFr($pointing->date) }}</td>
                                    <td>
                                        <span
                                            class=" {{ $data['start_from'] <= $pointing->start_from ? 'text-danger' : '' }}">
                                            {{ dateFr($pointing->start_from, 'hour') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class=" {{ $data['end_to'] >= $pointing->end_to ? 'text-danger' : '' }}">
                                            {{ dateFr($pointing->end_to, 'hour') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $pointing->status == 'in_progress' ? 'text-bg-secondary' : 'text-bg-success' }}">
                                            {{ status($pointing->status) }}
                                        </span>
                                    </td>

                                    @if (can('chef-barm|responsable-gestionnaire-des-ressources-humaines|assistant-gestionnaire-des-ressources-humaines'))
                                        <td>
                                            @if ($pointing->status !== 'finished')
                                                <div data-target="#editModal" data-pointing="{{ $pointing }}"
                                                    class="editBtn badge bg-primary text-white float-end cursor-pointer">
                                                    <i class='bx bx-edit'></i>Modifier
                                                </div>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> FORMULAIRE DE MODIFICATION </h5>
                </div>
                <form action="{{ route('pointing.edit') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="_id" />

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold"> Date</label>
                            <input type="date" class="form-control" name="date" disabled />
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold"> Heure d'arrivée</label>
                            <input type="time" class="form-control" name="start_from" />
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold"> Heure de départ</label>
                            <input type="time" class="form-control" name="end_to" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js-push')
        <script>
            (function($) {
                "use strict";
                $('.editBtn').on('click', function() {
                    var modal = $('#editModal');
                    var pointing = $(this).data('pointing');
                    console.log(pointing)
                    modal.find('form').attr('action', $(this).data('action'));
                    modal.find('input[name=_id]').val(pointing.id);
                    modal.find('input[name=date]').val(pointing.date);
                    modal.find('input[name=start_from]').val(pointing.start_from);
                    modal.find('input[name=end_to]').val(pointing.end_to);
                    modal.modal('show');
                });

            })(jQuery);
        </script>
    @endpush
@endsection
