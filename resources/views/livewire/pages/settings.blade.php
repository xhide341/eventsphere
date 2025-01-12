<div>
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
                        Settings
                    </li>
                </ol>
                <h2 class="font-semibold text-3xl capitalize mt-2">
                    {{ __('Settings') }}
                </h2>
            </nav>
        </div>
    </x-slot>
    <div class="mt-4 font-poppins">
        <div class="space-y-6 overflow-hidden">
            <div class="bg-white shadow-sm rounded-lg flex flex-col p-4 sm:p-8">
                <h2 class="text-lg font-medium text-primary-dark align-middle">
                    {{ __('Notifications') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Configure your notification preferences.') }}
                </p>

                <div class="mt-6 flex flex-col gap-4">
                    <!-- Event Notifications Toggle -->
                    <div class="h-px w-full bg-gray-200"></div>
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col flex-grow">
                            <span class="text-sm font-medium text-primary-dark">Event Notifications</span>
                            <span class="text-sm text-gray-500">
                                Receive email notifications for event registrations and cancellations
                            </span>
                        </div>
                        <button wire:click="toggleNotifications" type="button"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 {{ auth()->user()->event_notifications_enabled ? 'bg-primary' : 'bg-gray-200' }}"
                            role="switch"
                            aria-checked="{{ auth()->user()->event_notifications_enabled ? 'true' : 'false' }}">
                            <span aria-hidden="true"
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ auth()->user()->event_notifications_enabled ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>

                    <!-- Success Message -->
                    @if (session()->has('message'))
                        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Logout Section -->
            <div class="bg-white shadow-sm rounded-lg p-4 sm:p-8">
                <h2 class="text-lg font-medium text-primary-dark">
                    {{ __('Account') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Manage your account session.') }}
                </p>

                <div class="mt-6">
                    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')">
                        {{ __('Logout') }}
                    </x-danger-button>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-logout" :show="false" focusable>
        <form wire:submit="logout" class="p-6">
            <h2 class="text-lg font-medium text-primary-dark">
                {{ __('Are you sure you want to logout?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('You will be redirected to the login page.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Logout') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>