@extends('layouts.app')
@section('content')
    @push('css-push')
        <style>
            td {
                text-align: center;
            }

            input {
                color: red;
                background-color: white;
                border: none;
                font-size: 16px;
                outline: none;
                box-shadow: none;
            }
        </style>
    @endpush
    <div class="container py-4">
        <h4 class="pt-5 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Offre d'emploi / </span> Liste des offres
        </h4>
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <div class="btn-group">
                    <a href="{{ route('job.create') }}" type="button" class="btn btn-primary">Ajouter d'un offre</a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <table class=" table table-bordered">
                        <thead>
                            <tr>
                                <th>Date d'ajout</th>
                                <th>Code</th>
                                <th>Intitulé</th>
                                <th>Type de contrat</th>
                                <th>Lieu de travail</th>
                                <th>Status</th>
                                <th>Date de cloture</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr>
                                    <td>{{ dateFr($job->created_at) }}</td>
                                    <td>{{ $job->reference }}</td>
                                    <td>{{ $job->title }}</td>
                                    <td>{{ $job->job_type }}</td>
                                    <td>{{ $job->location }}</td>
                                    <td class="{{ status($job->status, 'css') }}">{{ status($job->status) }}</td>
                                    <td>{{ dateFr($job->end_date) }}</td>
                                    <td class="d-flex justify-content-between">
                                        <div class="">
                                            <a href="{{ route('job.show', $job->id) }}">
                                                <i class='bx bxs-show'></i>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('job.edit', $job->id) }}">
                                                <i class='bx bx-edit-alt text-secondary'></i>
                                            </a>
                                        </div>
                                        <div>

                                            <form action="{{ route('job.destroy', $job->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <input type="submit" value="♻" >
                                            </form>
                                        </div>
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
