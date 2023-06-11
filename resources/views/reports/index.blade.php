<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Include AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/css/adminlte.min.css">

    <!-- Optional AdminLTE plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.header')

        <!-- AdminLTE Main Sidebar Container -->
        @include('layouts.sidebar')

        <!-- AdminLTE Content Wrapper -->
        <div class="content-wrapper">

            <!-- AdminLTE Content Header (Page header) -->
            <section class="content-header">
                @hasSection('breadcrumbs')
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <x-nav.breadcrumb href="{{ route('dashboard') }}">{{ __('Dashboard') }}</x-nav.breadcrumb>
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                @endif

                <h1>@yield('title')</h1>
            </section>

            <!-- AdminLTE Main content -->
            <section class="content">
                @include('layouts.alerts')
                @yield('content')
            </section>
        </div>

        @include('layouts.footer')
    </div>

    <!-- AdminLTE JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/js/adminlte.min.js"></script>

    @section('scripts')
        <script src="{{ mix('/lib/bootstrap.bundle.min.js') }}"></script>
        @stack('scripts')
    @show
</body>

</html>
