@extends('layouts.app')
@section('content')
<div class="containt">
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">{{$title}}</span>
        </div>
            <center>
                <a href="{{route('admin.attestation.postePdf')}}"><i class="fa fa-print"></i>
                    imprimer présence</a>
            </center>
    </div>
</div>
@endsection