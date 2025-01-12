<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'eventsphere') }} |
        @php
            $routeName = Route::currentRouteName();
            $formattedName = str_replace('.', ' ', $routeName);
            $formattedName = ucwords($formattedName);
        @endphp
        {{ $formattedName }}
    </title>
    <link rel="icon" href="{{ Vite::asset('resources/images/LCUP.ico') }}" type="image/x-icon" sizes="16x16">

    <!-- Add Livewire Styles -->
    @livewireStyles
    @notifyCss
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins antialiased relative flex bg-gray-300 max-w-full w-full">
    @livewire('layout.sidebar')

    <div class="max-w-full w-full py-4 p-4 xl:py-6 xl:pl-0 xl:pr-6 xl:ml-[280px] overflow-x-hidden">
        <!-- Page Heading -->
        @if (isset($header))
            <header x-data="{ isToggled: false }" @toggle-sidebar.window="isToggled = !isToggled"
                class="flex items-center mb-4 relative">
                <div class="px-4 xl:px-0 flex-grow w-full">
                    {{ $header }}
                </div>
                <div x-show="!isToggled" class="block xl:hidden">
                    <livewire:layout.toggle-sidebar />
                </div>
            </header>
        @endif
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <x-notify::notify />
    @notifyJs
    @livewireScripts
</body>

</html>