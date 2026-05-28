<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-semi-dark" data-assets-path="../../assets/" data-template="vertical-menu-template-semi-dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting() }} {{ isset($title) ? ' - ' . $title : '' }} </title>


    <meta name="description" content="Project BARM" />
    <meta name="keywords" content="BARM">

    <link rel="icon" type="image/x-icon" href="{{ asset(setting('app_logo')) }}" />

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

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/%40form-validation/umd/styles/index.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/wizard.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />

    <style>
        .button-33 {
            z-index: 1000;
            position: fixed;
            font-size: 20px;
            top: 80px;
            right: 20px;
            background-color: #fbe7c2;
            border-radius: 100px;
            box-shadow: rgba(187, 44, 125, 0.2) 0 -25px 18px -14px inset, rgba(44, 187, 99, .15) 0 1px 2px, rgba(44, 187, 99, .15) 0 2px 4px, rgba(44, 187, 99, .15) 0 4px 8px, rgba(44, 187, 99, .15) 0 8px 16px, rgba(44, 187, 99, .15) 0 16px 32px;
            color: #312f2f;
            cursor: pointer;
            display: inline-block;
            font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto, sans-serif;
            padding: 7px 20px;
            text-align: center;
            text-decoration: none;
            transition: all 250ms;
            border: 0;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .button-33:hover {
            box-shadow: rgba(44, 187, 99, .35) 0 -25px 18px -14px inset, rgba(44, 187, 99, .25) 0 1px 2px, rgba(44, 187, 99, .25) 0 2px 4px, rgba(44, 187, 99, .25) 0 4px 8px, rgba(44, 187, 99, .25) 0 8px 16px, rgba(44, 187, 99, .25) 0 16px 32px;
            transform: scale(1.05) rotate(-1deg);
            color: #0d1d2c;
        }
    </style>
    <style>
        .loading_page {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.027);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>

    @stack('css-push')

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

</head>

<body>

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>

    <div class="{{ role() != 'candidat' ? 'layout-wrapper layout-content-navbar' : '' }}">
        <div class="layout-container">
            @if (role() != 'candidat')
                @include('partials.sidebar')
            @endif
            <!-- Layout container -->
            <div class="layout-page" @if (role() == 'candidat') style="padding: 50px 0 0 0 !important;" @endif>
                @include('partials.header')
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    @include('partials.footer')

                </div>
            </div>
        </div>
        <div id="loading_page" class="loading_page text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p>Chargement en cours...</p>
        </div>
    </div>

    {{-- @if (!can('chef-barm|admin|candidat|partner-financial|partner-employment|partner-technical'))

        @if (!in_array(pointingStatus(), ['finished', 'in_progress']))
            <a class="button-33" href="{{ route('pointing.create') }}">
                {{ pointingStatus() === 'start_from' ? 'Pointer mon arrivé' : 'Pointer mon départ' }}
            </a>
        @endif

    @endif --}}

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Flat Picker -->

    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    <!-- Form Validation -->
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>


    <script src="{{ asset('assets/js/dataTables.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            new DataTable('#datatable--barm', {
                "searching": true, 
                "ordering": false, 
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json"
                }
            });

            new DataTable('#datatable--barm2', {
                "searching": true, 
                "ordering": false, 
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json"
                }
            });

            new DataTable('#datatable-refused', {
                "searching": true, 
                "ordering": false, 
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json"
                }
            });

            new DataTable('#datatable-waiting', {
                "searching": true, 
                "ordering": false, 
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json"
                }
            });

        });
    </script>

    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>

    <script src="{{ asset('assets/js/form-wizard-numbered.js') }}"></script>
    <script src="{{ asset('assets/js/form-wizard-validation.js') }}"></script> --}}

    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-property-listing.js') }}"></script>
    <script src="{{ asset('assets/js/wizard.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/js/forms-editors.js') }}"></script>
    <script src="{{ asset('assets/js/validate.min.js') }}"></script>
    <script>
        function loading() {
            document.getElementById('loading_page').style.display = 'flex';
        }

        function endLoading() {
            document.getElementById('loading_page').style.display = 'none';
        }
    </script>
    @include('partials.script.sweetalert')
    @stack('js-push')

    @if (setting('tawk_to') != '')

        @if (role() == 'candidat')
            @php echo setting('tawk_to') @endphp
        @endif
    @endif
</body>

</html>
