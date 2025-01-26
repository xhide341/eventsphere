<div>
    <x-slot name="header">
        <div class="ml-1 rounded-lg flex flex-row flex-wrap items-center w-full">
            <nav class="bg-transparent antialiased text-primary-dark">
                <ol class="flex flex-wrap mr-8 bg-transparent items-center">
                    <li class="text-sm align-middle">
                        <x-heroicon-s-home class="w-5 h-5 text-primary-dark" />
                    </li>
                    <li class="text-sm capitalize leading-normal flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-600 mx-2" />
                        Pages
                    </li>
                    <li class="text-sm capitalize leading-normal flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-600 mx-2" />
                        Speakers
                    </li>
                </ol>
                <h2 class="font-semibold text-3xl capitalize mt-2">
                    {{ __('Speakers') }}
                </h2>
            </nav>
        </div>
    </x-slot>
    <div class="mt-4 font-poppins">
        <div class="space-y-6 overflow-hidden">
            <div class="bg-white shadow-sm rounded-lg flex flex-col p-4 sm:p-8">
                <header>
                    <div class="flex flex-row items-center space-x-2">
                        <h2 class="text-xl font-medium text-primary-dark align-middle">
                            {{ __('Speakers') }}
                        </h2>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Browse our list of speakers here.") }}
                    </p>
                </header>

                <div class="mt-6 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900">
                                            Avatar
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Name
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Email
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Phone
                                            Number
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($speakers as $speaker)
                                        <tr>
                                            <td
                                                class="whitespace-nowrap text-center py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <div class="flex justify-center">
                                                    <img src="{{ $speaker->avatar }}" alt="{{ $speaker->name }}'s avatar"
                                                        class="h-10 w-10 rounded-full object-cover border-2 border-primary" />
                                                </div>
                                            </td>
                                            <td
                                                class="whitespace-nowrap text-center py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                {{ $speaker->name }}
                                            </td>
                                            <td class="whitespace-nowrap text-center px-3 py-4 text-sm text-gray-500">
                                                {{ $speaker->email }}
                                            </td>
                                            <td class="whitespace-nowrap text-center px-3 py-4 text-sm text-gray-500">
                                                {{ $speaker->phone_number }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-3 py-4 text-sm text-gray-500 text-center">
                                                {{ __('No speakers found.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $speakers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>