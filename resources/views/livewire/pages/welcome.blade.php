<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Welcome! | eventsphere</title>
    <link rel="icon" href="{{ Vite::asset('resources/images/LCUP.ico') }}" type="image/x-icon" sizes="16x16">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/welcome.js'])
</head>

<body class="antialiased font-poppins">
    <div class="relative text-primary custom-bg">
        <div class="relative min-h-screen flex flex-col items-center justify-between pb-16 sm:px-0 sm:pb-20">
            <!-- header -->
            <div
                class="fixed top-0 w-full flex flex-col justify-center z-10 text-primary bg-white backdrop-blur shadow-md mx-auto sm:flex-row">
                <div class="w-full flex justify-center sm:max-w-7xl" x-data="{ expanded: false }">
                    <header class="p-4 flex items-center justify-between w-screen sm:flex-row md:p-6">
                        <div class="flex items-center">
                            <div class="flex flex-shrink-0 items-center">
                                <img src="{{ Vite::asset('resources/images/LCUP.png') }}" alt="Logo"
                                    class="w-10 h-10 rounded-full">
                                <p class="font-logo text-md ml-2">{{config('app.name')}}</p>
                            </div>
                        </div>

                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>
                </div>
            </div>
            <!-- home -->
            <section id="home" class="pt-12 sm:pt-20 mt-12 sm:mt-20">
                <div class="px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
                    <div class="max-w-3xl mx-auto text-center">
                        <h1 class="px-6 text-lg text-gray-600">Admin Dashboard and Event Management System</h1>
                        <div class="mt-5">
                            <div class="flex items-center justify-start text-center leading-normal">
                                <h1 id="typing-text" class="text-4xl font-bold text-primary sm:text-5xl lg:text-6xl">
                                    <span id="cursor" class="cursor">|</span>
                                </h1>
                            </div>
                        </div>
                        <div class="px-8 sm:items-center sm:justify-center sm:px-0 sm:space-x-5 sm:flex mt-9">
                            @if (!auth()->check())
                                <a href="{{ route('register') }}" title="Register"
                                    class="inline-flex items-center justify-center w-full px-8 py-3 text-lg font-semibold text-white transition-all duration-200 bg-primary border-2 border-transparent sm:w-auto rounded-lg hover:bg-primary-light focus:outline-none focus:ring-0 focus:ring-offset-0"
                                    role="button">
                                    Register now
                                </a>
                            @else
                                <a href="{{ route('events') }}" title="Events"
                                    class="inline-flex items-center justify-center w-full px-8 py-3 text-lg font-semibold text-white transition-all duration-200 bg-primary border-2 border-transparent sm:w-auto rounded-lg hover:bg-primary-light focus:outline-none focus:ring-0 focus:ring-offset-0"
                                    role="button">
                                    Browse Events
                                </a>
                            @endif
                        </div>
                        <p class="mt-8 text-sm text-gray-500">This website is not affiliated with the official campus of
                            La Consolacion University Philippines.</p>
                    </div>
                </div>
                <div class="pt-12">
                    <div class="relative">
                        <div class="absolute inset-0 h-2/3 bg-gray-50"></div>
                        <div class="relative mx-auto">
                            <div class="lg:max-w-6xl lg:mx-auto rounded-md">
                                <img src="{{ Vite::asset('resources/images/welcome-images/welcome-img.png') }}"
                                    alt="Eventsphere Admin Screenshot" class="rounded-md">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- how it works -->
        <section class="py-10 sm:py-16 lg:py-24">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-bold leading-tight text-primary sm:text-4xl lg:text-5xl">
                        How does it work?
                    </h2>
                    <p class="max-w-lg mx-auto mt-4 text-base leading-relaxed text-gray-600">Below are the simple steps
                        to get you started.</p>
                </div>

                <div class="relative mt-12 lg:mt-20">
                    <div class="absolute inset-x-0 hidden xl:px-44 top-2 md:block md:px-20 lg:px-28">
                        <svg width="875" height="48" viewBox="0 0 875 48" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2 29C20.2154 33.6961 38.9915 35.1324 57.6111 37.5555C80.2065 40.496 102.791 43.3231 125.556 44.5555C163.184 46.5927 201.26 45 238.944 45C312.75 45 385.368 30.7371 458.278 20.6666C495.231 15.5627 532.399 11.6429 569.278 6.11109C589.515 3.07551 609.767 2.09927 630.222 1.99998C655.606 1.87676 681.208 1.11809 706.556 2.44442C739.552 4.17096 772.539 6.75565 805.222 11.5C828 14.8064 850.34 20.2233 873 24"
                                stroke="#035AA6" stroke-width="3" stroke-linecap="round" stroke-dasharray="1 12" />
                        </svg>
                    </div>

                    <div class="relative grid grid-cols-1 text-center gap-y-12 md:grid-cols-3 gap-x-12">
                        <div>
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-primary rounded-full shadow">
                                <span class="text-xl font-semibold text-gray-700"> 1 </span>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold leading-tight text-primary md:mt-10">Create a free
                                account</h3>
                            <p class="mt-4 text-base text-gray-600">By creating an account, you can freely register to
                                campus events and manage them easily.</p>
                        </div>

                        <div>
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-primary rounded-full shadow">
                                <span class="text-xl font-semibold text-gray-700"> 2 </span>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold leading-tight text-primary md:mt-10">Browse events
                            </h3>
                            <p class="mt-4 text-base text-gray-600">You can browse events and find the one that suits
                                you best.</p>
                        </div>

                        <div>
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-primary rounded-full shadow">
                                <span class="text-xl font-semibold text-gray-700"> 3 </span>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold leading-tight text-primary md:mt-10">Leave a review
                            </h3>
                            <p class="mt-4 text-base text-gray-600">You can leave a review for the event you attended.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- meet the team -->
        <section class="py-10 sm:py-16 lg:py-24">
            <div
                class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 relative flex flex-col items-center justify-center text-primary">
                <h2 class="text-3xl font-bold leading-tight text-primary sm:text-4xl lg:text-5xl">
                    Meet the team
                </h2>
                <p class="max-w-xl mt-4 text-base leading-relaxed text-gray-600 text-justify">We are a team of 3
                    students from <a href="https://www.facebook.com/LaConsolacionU" target="_blank"
                        class="text-primary hover:underline">La Consolacion University Philippines</a>, taking up
                    Bachelor of Science in
                    Information Technology.</p>
                <div
                    class="flex flex-col mt-8 sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-20 text-primary text-center">
                    <div class="is-hidden avatar text-center flex flex-col items-center justify-center">
                        <img src="{{ Vite::asset('resources/images/welcome-images/boy1.png') }}" alt="Placeholder Image"
                            class="h-[150px] transition-transform duration-300 ease-in-out hover:scale-110 sm:h-[200px]">
                        <p class="text-lg font-bold mt-2 sm:text-2xl">Shawne Nuque</p>
                        <p class="text-sm sm:mt-2">Web Developer</p>
                    </div>
                    <div class="is-hidden avatar text-center flex flex-col items-center justify-center">
                        <img src="{{ Vite::asset('resources/images/welcome-images/girl1.png') }}"
                            alt="Placeholder Image"
                            class="h-[150px] transition-transform duration-300 ease-in-out hover:scale-110 sm:h-[200px]">
                        <p class="text-lg font-bold mt-2 sm:text-2xl">Lorrea Delos Reyes</p>
                        <p class="text-sm sm:mt-2">Project Researcher</p>
                    </div>
                    <div class="is-hidden avatar text-center flex flex-col items-center justify-center">
                        <img src="{{ Vite::asset('resources/images/welcome-images/girl2.png') }}"
                            alt="Placeholder Image"
                            class="h-[150px] transition-transform duration-300 ease-in-out hover:scale-110 sm:h-[200px]">
                        <p class="text-lg font-bold mt-2 sm:text-2xl">Pauline Joy Panillo</p>
                        <p class="text-sm sm:mt-2">Project Researcher</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- contact section -->
        <section class="py-10 sm:py-16 lg:py-24">
            <div
                class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 relative flex flex-col items-center justify-center text-primary">
                <h2 class="text-3xl font-bold leading-tight text-primary sm:text-4xl lg:text-5xl">
                    Contact us
                </h2>
                <div class="mt-4 text-center text-gray-600 sm:mb-10">
                    <p class="text-sm sm:text-base">For inquiries, you can reach us at:</p>
                    <p class="text-xs sm:text-sm hover:underline">Email: <a href="mailto:team@example.com"
                            class="text-primary">team@eventsphere.com</a></p>
                    <p class="text-xs sm:text-sm hover:underline">Phone: <a href="tel:+1234567890"
                            class="text-primary">+1 (234)
                            567-890</a></p>
                </div>
                <!-- Contact Form -->
                <livewire:welcome.contact-form />
            </div>
        </section>

        <!-- footer -->
        <footer
            class="py-6 px-4 sm:px-10 mx-auto flex flex-col items-center justify-between text-xs text-primary max-w-screen bg-white sm:text-sm sm:flex-row">
            <div class="flex items-center">
                <img src="{{ Vite::asset('resources/images/LCUP.png') }}" alt="Logo" class="w-10 h-10 rounded-full">
                <p class="font-logo text-lg ml-2">eventsphere</p>
            </div>
            <div class="flex items-center space-x-2">
                <p>&copy; 2024 eventsphere. All rights reserved.</p>
                <a href="https://github.com/xhide341/event-sphere.git" target="_blank"
                    class="hover:animate-spin-fast transition-transform">
                    <img src="{{ Vite::asset('resources/images/github-logo.svg') }}" alt="GitHub Logo"
                        class="w-8 h-8 inline-block">
                </a>
            </div>
        </footer>

    </div>
</body>

</html>