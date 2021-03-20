<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - @yield('title') | {{ env('APP_NAME', 'ESHIP') }}</title>
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
    <!-- dashboard -->
    <div class="dashboard">
        <!-- loading-overlay -->
        <div class="loading-overlay"><div class="lds-ripple"><div></div><div></div></div></div>
        <!-- loading-overlay -->

        <!-- sidebar -->
        <x-sidebar />
        <!-- sidebar:end -->
        
        <!-- navbar -->
        <x-navbar />
        <!-- navbar:end -->
        
        <!-- content -->
        <div class="main">
            @yield('content')
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- library scripts -->
    @stack('scripts-library')
    <!-- custom scripts -->
    @stack('scripts')
</body>
</html>