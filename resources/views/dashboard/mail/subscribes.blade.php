@extends('layouts.app', ['title' => $title])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Pointages/</span> {{$title}}
        </h4>
        <div class="card">
            <h5 class="card-header">{{$title}}</h5>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-dark">
                        <tr>
                            <th>Date d'abonnement</th>
                            <th>Email </th>
                            <th>IP</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($subscribes as $subscribe)
                                <tr>
                                    <td>{{ dateFr($subscribe->created_at)  }}</td>
                                    <td>{{ $subscribe->email  }}</td>
                                    <td>
                                        <a
                                            href="{{ route('map', ['subscribe',$subscribe->id])  }}"
                                            target="_blank"
                                        >
                                            {{ json_decode($subscribe->address)->ip }}
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
