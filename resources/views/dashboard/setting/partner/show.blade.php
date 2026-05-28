@extends('layouts.app')

@section('content')
    <div class="container bg-white card pb-5">

        <h6 class="text-end pt-4">Date de crétion : {{ dateFr($partner->created_at) }}</h6>
        <h1 class="my-4">{{ $partner->title }}</h1>

        <div class="row">

            <div class="col-md-12">
                <div class="d-flex gap-2">
                     <a href="{{ route('partner.edit', $partner->id) }}" class="btn btn-outline-success">Modifier</a>
                    <form action="{{ route('partner.destroy', $partner->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Supprimer" class="btn btn-outline-danger">
                    </form>
                </div>
                <div class="py-4 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset($partner->image) }}" alt="" width="750"
                        height="500">
                </div>

            </div>



        </div>
        <!-- /.row -->

    </div>
@endsection
