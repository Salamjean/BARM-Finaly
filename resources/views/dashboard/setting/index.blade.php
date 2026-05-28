@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4 class="pt-5 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Paramèttre /</span>
        </h4>
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <div class="btn-group">
                    <a href="{{ route('setting.create') }}" type="button" class="btn btn-primary">
                        <i class='bx bx-edit me-2'></i>
                        Modifier
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <table class=" table table-bordered">
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
                            <tr>
                                <td style="text-align: start;" class="text-warning" colspan="2">
                                    HORAIRE DU PERSONEL
                                </td>
                            </tr>
                            @foreach ($settings as $setting)
                                @if ($setting->type == 'pointing')
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
                <div class="card-datatable table-responsive">
                    <table class=" table table-bordered">
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
