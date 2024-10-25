<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'eventsphere') }} | {{ ucfirst(Route::currentRouteName()) }}</title>
        <link rel="icon" href="{{ Vite::asset('resources/images/LCUP.ico') }}" type="image/x-icon" sizes="16x16">

        <!-- Add Livewire Styles -->
        @livewireStyles
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-poppins antialiased bg-muted-teal">
        <div class="relative flex bg-muted-teal max-w-full w-full">
            @livewire('layout.sidebar')
            
            <div class="max-w-full w-full py-4 p-4 xl:py-6 xl:pl-0 xl:pr-6 xl:ml-[280px] overflow-x-hidden">
                <!-- Page Heading -->
                @if (isset($header))
                <header x-data="{ isToggled: false }" @toggle-sidebar.window="isToggled = !isToggled"
                    class="transition-all duration-300 ease-in-out"
                    :class="{ 'ml-64': isToggled, 'ml-0': !isToggled }">
                    <div class="px-4 xl:px-0">
                        {{ $header }}
                    </div>
                </header>
                @endif
                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
        @livewireScripts
    </body>
</html>
