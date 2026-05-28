@extends('layouts.app')

@section('content')
    <div class="container bg-white card pb-5">

        <h6 class="text-end pt-4">Date de crétion : {{ dateFr($ad->created_at) }}</h6>
        <h1 class="my-4">{{ $ad->title }}</h1>

        <div class="row">

            <div class="col-md-5">
                <div class="py-4">
                    <img class="img-fluid" src="{{ asset($ad->images[0]->image) }}" alt="" width="750"
                        height="500">
                </div>
                <div class="row">

                    @foreach ($ad->images as $image)
                        <div class="col-md-3 col-sm-6 mb-4">
                            <a href="#">
                                <img class="img-fluid" src="{{ asset($image->image) }}" width="500" height="300"
                                    alt="">
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>

            <div class="col-md-7">
                <div class="my-3 d-flex gap-1">
                    <a href="{{ route('ad.edit', $ad->id) }}" class="btn btn-outline-secondary">Modifier</a>
                    <form action="{{ route('ad.destroy', $ad->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Supprimer" class="btn btn-outline-danger">
                    </form>
                </div>
                <h3 class="my-3">Description</h3>
                <p>
                    @php
                        echo $ad->description;
                    @endphp
                </p>

            </div>

        </div>
        <!-- /.row -->

    </div>
@endsection
