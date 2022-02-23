<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset("favicon.ico")}}" type="image/x-icon">
        <link rel="icon" href="{{asset("favicon.ico")}}" type="image/x-icon">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset("favicon-32x32.png")}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset("favicon-16x16.png")}}">
        <title>{{ config('app.name', 'Tilt') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <script src="https://kit.fontawesome.com/c8d84f105a.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
        <link rel="stylesheet" href="{{ mix('css/login.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/bundle.js') }}" defer></script>
        @livewireStyles
    </head>
    <body class="auth-bg">
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

    @stack('scripts')
        @livewireScripts
    </body>
</html>
