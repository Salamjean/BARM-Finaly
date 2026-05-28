@extends('layouts.app')

@section('content')
    <div class="container bg-white py-4">
        <div class=" ">
            <div class="card-header d-flex justify-content-end">
                <div class="btn-group">
                    <a href="{{ route('partner.create') }}" type="button" class="btn btn-primary">
                        <i class='bx bx-edit me-2'></i>
                        Ajouter
                    </a>
                </div>
            </div>
            <div class="card-body row py-4">
                @foreach ($partners as $partner)
                    <div class="col-md-4 col-lg-3 mb-3">
                        <a href="{{ route('partner.show', $partner->id) }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="text-end">{{ dateFr($partner->created_at) }}</h6>
                                    <h5 class="card-title text-one text-center">{{ $partner->name }}</h5>
                                </div>
                                <img class="img-fluid" src="{{ asset($partner->image) }}"
                                    alt="{{ $partner->id }}" />

                            </div>
                        </a>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
    @push('css-push')
        <style>
            .text-muted {
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 5;
                line-clamp: 5;
                -webkit-box-orient: vertical;
            }

            .text-one{
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                line-clamp: 3;
                -webkit-box-orient: vertical;
            }
        </style>
    @endpush
@endsection
