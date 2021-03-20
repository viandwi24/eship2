<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{ env('APP_NAME', 'ESHIP') }}</title>
    <!-- dashboard styles -->
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <!-- library styles -->
    @stack('styles-library')
    <!-- theme styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <!-- content -->
    @yield('content')

    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- library scripts -->
    @stack('scripts-library')
    <!-- custom scripts -->
    @stack('scripts')
</body>
</html>