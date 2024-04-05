<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

     
            <!-- Page nav bar -->
                
            <!-- Page Content -->
            <main class="flex  relative justify-between">
                <div class="w-full ">
                            {{ $slot }}
                </div>
                
                @if (auth()->user())
                    @if (auth()->user()->role == 2)
                    <div class="w-1/4 relative xsmr:hidden smr:hidden">
                        @livewire('users.hrofficer.admindashboard')
                    </div>
                    @elseif(auth()->user()->role == 1)
                    <div class="w-1/4  relative xsmr:hidden smr:hidden">
                        @livewire('users.employee.dashboard')
                    </div>
                    @endif
                @endif

            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
