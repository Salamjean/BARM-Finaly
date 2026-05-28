@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Gestion de gadget / </span> {{ $title }}
                    </h4>
                </nav>
            </div>

        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <button data-toggle="modal" data-target="#addModal" class="addBtn btn btn-primary">
                    <i class='bx bx-plus'></i> Ajouter
                </button>
            </div>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start">#</th>
                                <th>Date</th>
                                <th>Intitulé</th>
                                <th>Quantité</th>
                                <th>Disponibilité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gadgets as $gadget)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>{{ dateFr($gadget->created_at) }}</td>
                                    <td>{{ $gadget->name }}</td>
                                    <td>{{ $gadget->quantity }}</td>
                                    <td>
                                        @if ($gadget->quantity == 0)
                                            <span class="badge bg-label-danger">En rupture</span>
                                        @elseif ($gadget->quantity < 5)
                                            <span class="badge bg-label-warning">Presque en rupture</span>
                                        @else
                                            <span class="badge bg-label-success">En stock</span>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center gap-4 " >
                                        <a href="{{ route('gadget.pdf_gadget', $gadget->id) }}" class="text-warning">
                                            <i class='bx bx-folder-open fs-4'></i>
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#edit-gadget"
                                            class="editBtn text-primary" data-gadget="{{ $gadget }}"
                                            data-action="{{ route('gadget.update', $gadget->id) }}">
                                            <i class='bx bx-edit-alt fs-4'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajout de gadget</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('gadget.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Intitulé<span class="text-danger">*</span>
                                        :
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">Quantité<span class="text-danger">*</span>
                                        :
                                    </label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
                                    @error('quantity')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description :</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edition de gadget</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Intitulé<span class="text-danger">*</span>
                                        :
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">Quantité<span class="text-danger">*</span>
                                        :
                                    </label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
                                    @error('quantity')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description :</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" besoin="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    @push('js-push')
        <script>
            (function($) {
                "use strict";
                $('.addBtn').on('click', function() {
                    var modal = $('#addModal');
                    modal.modal('show');
                });
                $('.editBtn').on('click', function() {
                    var modal = $('#editModal');
                    var gadget = $(this).data('gadget');
                    modal.find('form').attr('action', $(this).data('action'));
                    modal.find('input[name=name]').val(gadget.name);
                    modal.find('input[name=quantity]').val(gadget.quantity);
                    modal.find('textarea[name=description]').val(gadget.description);
                    modal.modal('show');
                });
            })(jQuery);
        </script>
    @endpush
@endsection
