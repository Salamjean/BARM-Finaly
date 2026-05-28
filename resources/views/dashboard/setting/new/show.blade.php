@extends('layouts.app')

@section('content')
    <div class="container bg-white card pb-5">

        <h6 class="text-end pt-4">Date de crétion : {{ dateFr($new->created_at) }}</h6>
        <h1 class="my-4">{{ $new->title }}</h1>

        <div class="row">

            <div class="col-md-7">
                <div class="py-4">
                    <img class="img-fluid" src="{{ asset($new->image) }}" alt="" width="750" height="500">
                </div>

            </div>

            <div class="col-md-5">
                <div class="my-3 d-flex gap-1">
                    <a href="{{ route('new.edit', $new->id) }}" class="btn btn-outline-secondary">Modifier</a>
                    <form action="{{ route('new.destroy', $new->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Supprimer" class="btn btn-outline-danger">
                    </form>
                </div>
                @if ($new->description)
                    <h3 class="my-3">Description</h3>
                    <p>{{ $new->description }}</p>
                @endif

            </div>

        </div>
        <!-- /.row -->

    </div>
@endsection
