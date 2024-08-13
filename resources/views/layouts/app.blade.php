<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- <link rel="stylesheet" href="{{ asset('assets/adminkit/static/css/app.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/adminkit/static/css/app-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/font/bootstrap-icons.css') }}">
    @stack('customcss')
    @livewireStyles
</head>

<body>
    @include('sweetalert::alert')
    <div class="wrapper">
        @auth
            @include('layouts.sidebar')
        @endauth
        <div class="main">
            @include('layouts.navigation')
            <main class="content">
                <div class="p-0">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="{{ asset('assets/adminkit/static/js/app.js') }}"></script>
    @stack('customjs')
    @livewireScripts
</body>

</html>
