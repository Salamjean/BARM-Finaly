<!DOCTYPE html>

<html lang="en">


<!-- Mirrored from demos.pixinvent.com/frest-html-admin-template/html/vertical-menu-template-semi-dark/pages-misc-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Feb 2024 09:12:51 GMT -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ setting() }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset(setting('app_logo')) }}" />
    <meta name="description" content="Project BARM" />
    <meta name="keywords" content="BARM">
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

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">

</head>

<body>

    <!-- Error -->
    <div class="">
        <div class="misc-wrapper" style="">
            <h1 class="mb-2 mx-2">Page non trouvée :(</h1>
            <p class="mb-4 mx-2">We couldn't find the page you are looking for</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Accueil</a>
            <div class="mt-3">
                <img
                    src="{{ asset('assets/img/illustrations/page-misc-error-light.png') }}"
                    alt="page-misc-error-light" width="500" class="img-fluid"
                />
            </div>
        </div>
    </div>

</body>

</html>

<!-- beautify ignore:end -->
