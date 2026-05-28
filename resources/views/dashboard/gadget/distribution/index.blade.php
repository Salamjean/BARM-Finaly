@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <h4 class="py-3 breadcrumb-wrapper mb-4">
                        <span class="text-muted fw-light">Gestion de gadget / Distributions / </span> {{ $title }}
                    </h4>
                </nav>
            </div>

        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <a href="{{ route('gadget.distribution.create') }}" class="addBtn btn btn-primary">
                    <i class='bx bx-plus'></i> Ajouter
                </a>
            </div>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start">#</th>
                                <th>Date</th>
                                <th>Cellule / Service</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($distributions as $distribution)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>{{ dateFr($distribution->created_at, 'complet') }}</td>
                                    <td>{{ $distribution->title }}</td>

                                    <td class="d-flex justify-content-center gap-4 " >
                                        <a href="{{ route('gadget.pdf_distribution', $distribution->id) }}" class="text-warning">
                                            <i class='bx bx-folder-open fs-4'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
