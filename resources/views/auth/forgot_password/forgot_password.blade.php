@extends('layouts.auth', ['title' => 'Mot de passe oublié', 'type' => 'login', 'asset' => 'assets/img/logo/10.gif'])

@section('content')
    <form id="formAuthentication" class="mb-3"
        action="{{ route('forgot-password.verification') }}"
        method="GET">
        <div class="mb-3">
            <input type="hidden" name="user" value="{{ $user }}">
            @if ($user === 'adherent')
                <label for="phone_number" class="form-label">Numéro de téléphone</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Entrez votre numéro de téléphone"
                    autofocus>
            @else
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Entrez votre email"
                    autofocus>
            @endif
        </div>
        <button class="btn btn-primary d-grid w-100">Envoyez</button>
    </form>
@endsection
