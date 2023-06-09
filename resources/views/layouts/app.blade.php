<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">

    <!-- JavaScript -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>


</head>

<body>
    @include('layouts.header')

    <div class="container-fluid">
        @hasSection('breadcrumbs')
            <nav class="mx-5 mt-3" aria-label="breadcrumb">
                <ol class="breadcrumb bg-light rounded-pill p-2">
                    <x-nav.breadcrumb href="{{ route('dashboard') }}">{{ __('Homepage') }}</x-nav.breadcrumb>
                    @yield('breadcrumbs')
                </ol>
            </nav>
        @endif

        <main class="mx-5 my-3">
            @include('layouts.alerts')
            @section('main')
                @hasSection('headline-buttons')
                    <div class="hstack gap-3">
                        @section('headline')
                            <h1>@yield('title')</h1>
                        @show
                        <div class="ms-auto">
                            @section('headline-buttons')
                            @show
                        </div>
                    </div>
                @else
                    @section('headline')
                        <h1>@yield('title')</h1>
                    @show
                @endif

                @yield('content')
            @show
        </main>
    </div>

    @include('layouts.footer')

    @section('scripts')
        <script src="{{ mix('/lib/bootstrap.bundle.min.js') }}"></script>
        @stack('scripts')
    @show
</body>

</html>
