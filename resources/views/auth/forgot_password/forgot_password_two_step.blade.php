@extends('layouts.auth', ['title' => 'Verification de code', 'type' => 'login', 'asset' => 'assets/img/logo/10.gif'])

@section('content')
    <form id="twoStepsForm"
                action="{{ route('forgot-password.send') }}"
                method="POST">
                @csrf

                <div class="mb-3">
                    <div
                        class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                        <input type="hidden" name="phoneOrEmail" value="{{ $phoneOrEmail }}" />
                        <input type="hidden" name="user" value="{{ $user }}" />
                        <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                            maxlength="1" autofocus />
                        <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                            maxlength="1" />
                        <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                            maxlength="1" />
                        <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                            maxlength="1" />
                        <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                            maxlength="1" />
                    </div>
                    <input type="hidden" name="otp" />
                </div>
                <button class="btn btn-primary d-grid w-100 mb-3">
                    Verification du compte
                </button>

            </form>
@endsection
