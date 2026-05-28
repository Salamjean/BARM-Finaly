@extends('layouts.app')

@section('content')
    <div class="container bg-white card pb-5">

        <h6 class="text-end pt-4">Date de crétion : {{ dateFr($team->created_at) }}</h6>
        <h1 class="my-4">{{ $team->title }}</h1>

        <div class="row">

            <div class="col-md-5">
                <div class="py-4" style="position: relative;">
                    @if ($team->personal == 'dg')
                        <i class='bx bxs-castle fs-1 text-warning' style="position: absolute; top:0;"></i>
                    @endif
                    <img class="img-fluid" src="{{ asset($team->image) }}" alt="" width="750" height="500">
                </div>

            </div>

            <div class="col-md-7">
                <div class="my-3 d-flex justify-content-between gap-1">
                    <div class="d-flex">

                        <a href="{{ route('team.chief', $team->id) }}" class="btn {{ $team->personal == 'dg' ? 'btn-outline-warning' : 'btn-warning' }} me-2">Definir comme {{ $team->personal == 'personal' ? 'Directeur Générale' : 'Membre' }}</a>
                        <a href="{{ route('team.edit', $team->id) }}" class="btn btn-outline-secondary me-2">Modifier</a>
                        <form action="{{ route('team.destroy', $team->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="Supprimer" class="btn btn-outline-danger">
                        </form>
                    </div>
                </div>
                <div class="">
                    <h4 class="my-3 mt-5">Poste</h4>
                    <p>{{ $team->job }}</p>
                </div>

                @if ($team->facebook)
                    <div class="">
                        <h4 class="my-3">Lien facebook</h4>
                        <p><a target="_blank" href="{{ $team->facebook }}"><i
                                    class='me-2 bx bxl-facebook-circle'></i>{{ $team->facebook }}
                        </p>
                    </div>
                @endif
                @if ($team->x)
                    <div class="">
                        <h4 class="my-3">Lien x</h4>
                        <p><a target="_blank" href="{{ $team->x }}"><i
                                    class='me-2 bx bxl-xing'></i>{{ $team->x }}
                        </p>
                    </div>
                @endif
                @if ($team->linkedin)
                    <div class="">
                        <h4 class="my-3">Lien LinkedIn</h4>
                        <p><a target="_blank" href="{{ $team->linkedin }}"><i
                                    class='me-2 bx bxl-linkedin'></i>{{ $team->linkedin }}</p>
                    </div>
                @endif
                @if ($team->insta)
                    <div class="">
                        <h4 class="my-3">Lien Instagram</h4>
                        <p><a target="_blank" href="{{ $team->insta }}"><i
                                    class='me-2 bx bxl-instagram'></i>{{ $team->insta }}</p>
                    </div>
                @endif

            </div>

        </div>
        <!-- /.row -->

    </div>
@endsection
