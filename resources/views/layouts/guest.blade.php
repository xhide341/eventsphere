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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins text-primary antialiased">
    <div class="min-h-screen flex">
        @if (Route::currentRouteName() === 'register' || Route::currentRouteName() === 'login')
            <div class="w-full px-0 md:w-1/2 flex justify-center items-center bg-patten-blue">
                <div
                    class="flex flex-col items-center justify-center shadow-lg md:shadow-none bg-white md:bg-transparent p-4 md:p-6 rounded-lg">
                    @if (Route::currentRouteName() === 'login')
                        <div class="flex flex-col items-center justify-center">
                            <h1 class="lg:text-4xl md:text-3xl text-2xl text-accent font-bold mb-2">Welcome back</h1>
                            <p class="md:text-base text-sm text-gray-600 font-xs">Enter your credentials to sign in.</p>
                        </div>
                    @elseif (Route::currentRouteName() === 'register')
                        <div class="flex flex-col items-center justify-center">
                            <h1 class="lg:text-4xl md:text-3xl text-2xl text-accent font-bold mb-2">Create an account</h1>
                            <p class="md:text-base text-sm text-gray-600 font-xs">Fill in the form to create an account.</p>
                        </div>
                    @endif

                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg z-10">
                        {{ $slot }}
                    </div>

                    <div class="mt-16">
                        @if (Route::currentRouteName() === 'login' || Route::currentRouteName() === 'register')
                            <footer class="text-center text-sm text-gray-600">
                                By continuing, you agree to eventsphere's
                                <a href="#" class="text-accent hover:underline">terms of service</a> and
                                <a href="#" class="text-accent hover:underline">privacy policy</a>.
                            </footer>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Centered layout for password reset -->
            <div class="px-0 w-full flex justify-center items-center bg-patten-blue">
                <!-- Back Button -->
                @if (Route::currentRouteName() === 'password.request')
                    <a href="{{ route('login') }}"
                        class="absolute top-4 left-4 p-2 text-gray-600 hover:text-accent transition-colors duration-200"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                @elseif (Route::currentRouteName() === 'verification.notice')
                    <a href="{{ route('register') }}"
                        class="absolute top-4 left-4 p-2 text-gray-600 hover:text-accent transition-colors duration-200"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                @endif


                <div
                    class="flex flex-col items-center justify-center shadow-lg bg-white px-4 py-6 md:px-6 md:py-8 lg:py-10 rounded-lg mx-4">
                    @if (Route::currentRouteName() === 'password.request' || Route::currentRouteName() === 'password.reset')
                        <div class="flex flex-col items-center justify-center">
                            <h1 class="md:text-3xl text-2xl text-accent font-bold mb-2">Reset Password</h1>
                        </div>
                    @elseif (Route::currentRouteName() === 'verification.notice')
                        <div class="flex flex-col items-center justify-center">
                            <h1 class="md:text-3xl text-2xl text-accent font-bold mb-2">Verify Your Email</h1>
                        </div>
                    @endif
                    <div class="w-full sm:max-w-md sm:px-6 sm:pt-4 overflow-hidden sm:rounded-lg z-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Image section - Only show for login and register -->
        @if (Route::currentRouteName() === 'login' || Route::currentRouteName() === 'register')
            <div class="fixed top-0 right-0 h-screen w-1/2 hidden md:block bg-patten-blue pb-4 pt-4 pr-4">
                <div class="relative w-full h-full bg-primary-dark rounded-lg">
                    <img src="{{ Vite::asset('resources/images/guest-images/' . Route::currentRouteName() . '.png') }}"
                        alt="Illustration for {{ ucfirst(Route::currentRouteName()) }}" loading="lazy"
                        class="w-full h-full object-contain absolute">
                    <p class="absolute bottom-4 right-4 text-white text-sm flex items-center gap-2">
                        Illustration by
                        <a href="https://www.freepik.com" class="text-white hover:underline inline-flex items-center gap-1">
                            © Freepik
                        </a>
                    </p>
                </div>
            </div>
        @endif
    </div>
</body>

</html>