<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quick Access</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Simplebar -->
    <link type="text/css" href="{{asset('template/vendor/simplebar.min.css')}}" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{{asset('template/css/app.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('template/css/app.rtl.css')}}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{asset('template/css/vendor-material-icons.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('template/css/vendor-material-icons.rtl.css')}}" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="{{asset('template/css/vendor-fontawesome-free.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('template/css/vendor-fontawesome-free.rtl.css')}}" rel="stylesheet">

    @stack('css')

</head>

<body class="layout-default">

    <div class="preloader"></div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

        <!-- Header -->

      @include('layouts._header')

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
                @yield('content')

                @include('layouts._menu')
            </div>
            <!-- // END drawer-layout -->

        </div>
        <!-- // END header-layout__content -->

    </div>
    <!-- // END header-layout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <!-- jQuery -->
    <script src="{{asset('template/vendor/jquery.min.js')}}"></script>

    <!-- Bootstrap -->
    <script src="{{asset('template/vendor/popper.min.js')}}"></script>
    <script src="{{asset('template/vendor/bootstrap.min.js')}}"></script>

    <!-- Simplebar -->
    <script src="{{asset('template/vendor/simplebar.min.js')}}"></script>

    <!-- DOM Factory -->
    <script src="{{asset('template/vendor/dom-factory.js')}}"></script>

    <!-- MDK -->
    <script src="{{asset('template/vendor/material-design-kit.js')}}"></script>

    <!-- App -->
    <script src="{{asset('template/js/toggle-check-all.js')}}"></script>
    <script src="{{asset('template/js/check-selected-row.js')}}"></script>
    <script src="{{asset('template/js/dropdown.js')}}"></script>
    <script src="{{asset('template/js/sidebar-mini.js')}}"></script>
    <script src="{{asset('template/js/app.js')}}"></script>

    <!-- App Settings (safe to remove) -->
    {{-- <script src="{{asset('template/js/app-settings.js')}}"></script> --}}
    @stack('script')
    @include('layouts.alert');




</body>

</html>
