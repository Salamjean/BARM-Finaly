<!DOCTYPE html>
<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-semi-dark"
    data-assets-path="../../assets/" data-template="vertical-menu-template-semi-dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title . ' | ' . setting()  }}</title>


    <meta name="description" content="Bureau d'Accompagnement à la Reconversion des Militaires" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://1.envato.market/frest_admin">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ asset(setting('app_logo'))  }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-semi-dark.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/%40form-validation/umd/styles/index.min.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

</head>

<body>

    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex @if ($type == 'register') col-lg-6 col-xl-7 @else col-lg-7 col-xl-8 @endif   align-items-center">
                <div class="flex-row text-center mx-auto">

                    <img src="{{ asset($asset) }}" alt="BARM" width="auto" height="auto" class="img-fluid authentication-cover-img">

                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 @if ($type == 'register') col-lg-6 col-xl-5  @else  col-lg-5 col-xl-4 @endif align-items-center authentication-bg p-sm-5 p-4">
                <div class="@if ($type == 'register') w-px-500 @else w-px-400 @endif mx-auto">
                    <div class="app-brand justify-content-center mb-2">
                        <a href="/" class="app-brand-link gap-2">
                            <img src="{{ asset(setting('app_logo')) }}" alt="" srcset=""
                                width="200">
                        </a>
                    </div>
                    <br>
                    <!-- Logo -->

                    @yield('content')
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
    <!-- / Content -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>


    <!-- Page JS -->
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
    <script src="{{ asset('assets/js/pages-auth-two-steps.js') }}"></script>
    <script>
        document.getElementById('showPassword').addEventListener('click', function() {
            var passwordInput = document.getElementById('password');
            var icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        });
    </script>

    @include('partials.script.sweetalert')

</body>
<!-- Mirrored from demos.pixinvent.com/frest-html-admin-template/html/vertical-menu-template-semi-dark/auth-login-cover.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Feb 2024 09:12:54 GMT -->

</html>
<!-- beautify ignore:end -->
