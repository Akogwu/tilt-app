<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tilt') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
{{--        <script src="https://use.fontawesome.com/b1f9168bbf.js"></script>--}}
        <script src="https://use.fontawesome.com/2cf7cdc790.js"></script>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
        @livewireStyles
        @if(Auth::user()->role_id =="SCHOOL_ADMIN")

         <link rel="stylesheet" href="/css/main.css">
    @else
            <style>
                .swal2-confirm{
                    margin-left: 20px !important;
                }
                .btn-danger {
                    color: #fff;
                    background-color: #fa5252;
                    border-color: #fa5252;
                    padding: 5px;
                }

                .btn-success {
                    color: #fff;
                    background-color: #00bf9a;
                    border-color: #00bf9a;
                    padding: 5px;
                }
            </style>
        @endif
    @stack('styles')
        <!-- Scripts -->
        <script src="{{ mix('js/bundle.js') }}" defer></script>

    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow" style="height: 75px">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        @stack('scripts')
    </body>
</html>
