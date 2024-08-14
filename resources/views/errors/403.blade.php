<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/adminkit/static/css/app-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/font/bootstrap-icons.css') }}">
</head>

<body>
    <div class="container text-center mt-5">
        <h1 class="display-1">403</h1>
        <p class="lead">Forbidden</p>
        <p>You don't have permission to access this resource.</p>
        <a href="{{ url('/') }}" class="btn btn-sm btn-outline-primary fw-bold">Go Home</a>
    </div>
    <script src="{{ asset('assets/adminkit/static/js/app-pro.js') }}"></script>
</body>

</html>
