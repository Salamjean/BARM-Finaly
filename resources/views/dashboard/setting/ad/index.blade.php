@extends('layouts.app')

@section('content')
    <div class="container bg-white py-4">
        <div class=" ">
            <div class="card-header d-flex justify-content-end">
                <div class="btn-group">
                    <a href="{{ route('ad.create') }}" type="button" class="btn btn-primary">
                        <i class='bx bx-edit me-2'></i>
                        Ajouter
                    </a>
                </div>
            </div>
            <div class="card-body row py-4">
                @foreach ($ads as $ad)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('ad.show', $ad->id) }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="text-end">{{ dateFr($ad->created_at) }}</h6>
                                    <h5 class="card-title text-one">{{ $ad->title }}</h5>
                                    <h6 class="card-subtitle text-muted">{{ $ad->description }}</h6>
                                </div>
                                <img class="img-fluid" src="{{ asset($ad->images[0]->image) }}"
                                    alt="{{ $ad->images[0]->id }}" />

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
