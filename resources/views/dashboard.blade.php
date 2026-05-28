@extends('layouts.app')
@section('content')
    @if (can('partner-technical') || can('partner-financial'))
        @include('partials.dashboard.partner')
    @elseif(can('chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-fonction-public|conseiller-entreprise-prive'))
        @include('partials.dashboard.cell-insertion')
    @else
        @include('partials.dashboard.other')
    @endif
@endsection
