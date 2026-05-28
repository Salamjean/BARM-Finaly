@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4 class="pt-5 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Paramèttre / Edition</span>
        </h4>
        <div class="card">
            <div class="card-header d-flex">
                <div class="btn-group">
                    <a href="{{ route('setting.index') }}" type="button" class="btn btn-warning">
                        <i class='bx bx-arrow-back me-2'></i>
                        Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <form action="{{ route('setting.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Valeur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: start;" class="text-warning" colspan="2">
                                        INFORMATIONS SUR LE SITE
                                    </td>
                                </tr>
                                @foreach ($settings as $setting)
                                    @if ($setting->type == 'other')
                                        <tr>
                                            <th>{{ $setting->name }}</th>
                                            <td style="text-align: center;">
                                                @if ($setting->name == 'app_logo' || $setting->name == 'meta_image')
                                                    <input type="file" class="form-control" accept=".jpeg, .png, .jpg"
                                                        name="{{ $setting->name }}">
                                                    <img src="{{ asset($setting->value) }}" alt="{{ $setting->value }}"
                                                        width="50" height="50">
                                                @else
                                                    <input type="text" name="{{ $setting->name }}" class=" form-control"
                                                        value="{{ $setting->value }}">
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td style="text-align: start;" class="text-warning" colspan="2">
                                        PLUGINS
                                    </td>
                                </tr>
                                @foreach ($settings as $setting)
                                    @if ($setting->type == 'plugin')
                                        <tr>
                                            <th>{{ $setting->name }}</th>
                                            <td style="text-align: center;">
                                                    <textarea name="{{ $setting->name }}" class=" form-control" rows="5">{{ $setting->value }}</textarea>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td style="text-align: start;" class="text-warning" colspan="2">
                                        HORAIRE DU PERSONEL
                                    </td>
                                </tr>
                                @foreach ($settings as $setting)
                                    @if ($setting->type == 'pointing')
                                        <tr>
                                            <th>{{ $setting->name }}</th>
                                            <td style="text-align: center;">
                                                <input type="time" name="{{ $setting->name }}" class=" form-control"
                                                       value="{{ $setting->value }}">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td style="text-align: end;" colspan="2">
                                        <button type="submit" class="btn btn-outline-success">MODIFIER</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Valeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settings as $setting)
                                @if ($setting->type == 'system')
                                    <tr>
                                        <th>{{ $setting->name }}</th>
                                        <td style="text-align: end;">
                                            @if ($setting->name == 'app_logo' || $setting->name == 'meta_image')
                                                <img src="{{ asset($setting->value) }}" alt="{{ $setting->value }}"
                                                    width="50" height="50">
                                            @else
                                                {{ $setting->value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
