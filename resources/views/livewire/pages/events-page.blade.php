<div>
    <div x-data="screenWidth">
        <div x-show="isResizing"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-[100]">
            <div class="bg-custom-white p-8 rounded-lg shadow-lg flex flex-col items-center">
                <svg class="animate-spin h-16 w-16 text-primary mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <p class="text-md font-base text-gray-700">Resizing screen...</p>
            </div>
        </div>
    </div>

    <!-- Page Header -->
    <x-slot name="header">
        <div class="ml-1 rounded-lg flex flex-row flex-wrap items-center w-full">
            <nav class="bg-transparent antialiased text-primary-dark">
                <ol class="flex flex-wrap mr-8 bg-transparent items-center">
                    <li class="text-sm breadcrumb-item align-middle">
                        <x-heroicon-s-home class="w-5 h-5 text-primary-dark" />
                    </li>
                    <li class="text-sm capitalize leading-normal flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-600 mx-2" />
                        Pages
                    </li>
                    <li class="text-sm capitalize leading-normal flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-600 mx-2" />
                        Events
                    </li>
                </ol>
                <h2 class="font-semibold text-3xl capitalize mt-2">
                    {{ __('Events') }}
                </h2>
            </nav>
        </div>
    </x-slot>

    <div class="mt-4 font-poppins">
        <div class="space-y-6 overflow-hidden">
            <div class="bg-custom-white shadow-sm rounded-lg flex flex-col p-4 sm:p-8">
                <header>
                    <div class="flex flex-row items-center space-x-2">
                        <h2 class="text-xl font-medium text-primary-dark align-middle">
                            {{ __('My Events') }}
                        </h2>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Browse your registered events here.") }}
                    </p>
                    <hr class="w-full border-t border-gray-300 my-4">
                </header>

                <!-- Department buttons for Registered Events -->
                <div class="flex flex-wrap gap-2 mb-2">
                    <button wire:click="$set('registeredEventsDepartmentName', '')"
                        class="px-4 py-2 text-sm font-medium {{ $registeredEventsDepartmentName === '' ? 'bg-indigo-100 text-primary' : 'text-primary-dark bg-custom-white' }} border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none">
                        ALL
                    </button>
                    @foreach($uniqueDepartments as $departmentName)
                        <button wire:click="$set('registeredEventsDepartmentName', '{{ $departmentName }}')"
                            class="px-4 py-2 text-sm font-medium {{ $registeredEventsDepartmentName === $departmentName ? 'bg-indigo-100 text-primary' : 'text-primary-dark bg-custom-white' }} border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none">
                            {{ $departmentName }}
                        </button>
                    @endforeach
                </div>

                @if($registeredEvents->isEmpty())
                    <p class="text-center text-sm text-gray-500 mt-4">No registered events found.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 auto-rows-fr p-2 sm:p-4">
                        @foreach($registeredEvents as $event)
                            <div wire:key="registered-event-wrapper-{{ $event->id }}">
                                <livewire:components.event-card :event="$event" :type="'registered'"
                                    :key="'registered-' . $event->id" />
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $registeredEvents->appends(['allEventsPage' => request('allEventsPage')])->links() }}
                    </div>
                @endif
            </div>

            <div class="bg-custom-white shadow-sm rounded-lg flex flex-col p-4 sm:p-8">
                <header>
                    <div class="flex flex-row space-x-2">
                        <h2 class="text-xl font-medium text-primary-dark align-middle">
                            {{ __('All Events') }}
                        </h2>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Browse all the events here.") }}
                    </p>
                    <hr class="w-full border-t border-gray-300 my-4">
                </header>

                <!-- Department buttons for All Events -->
                <div class="flex flex-wrap gap-2 mb-2">
                    <button wire:click="$set('allEventsDepartmentName', '')"
                        class="px-4 py-2 text-sm font-medium {{ $allEventsDepartmentName === '' ? 'bg-indigo-100 text-primary' : 'text-primary-dark bg-custom-white' }} border border-gray-300 rounded-md hover:bg-gray-50">
                        ALL
                    </button>
                    @foreach($uniqueDepartments as $departmentName)
                        <button wire:click="$set('allEventsDepartmentName', '{{ $departmentName }}')"
                            class="px-4 py-2 text-sm font-medium {{ $allEventsDepartmentName === $departmentName ? 'bg-indigo-100 text-primary' : 'text-primary-dark bg-custom-white' }} border border-gray-300 rounded-md hover:bg-gray-50">
                            {{ $departmentName }}
                        </button>
                    @endforeach
                </div>

                @if($allEvents->isEmpty())
                    <p class="text-center text-sm text-gray-500 mt-4">No events found.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 auto-rows-fr p-2 sm:p-4">
                        @foreach($allEvents as $event)
                            <div wire:key="all-event-wrapper-{{ $event->id }}">
                                <livewire:components.event-card :event="$event" :type="'all'" :key="'all-' . $event->id" />
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $allEvents->appends(['registeredEventsPage' => request('registeredEventsPage')])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>