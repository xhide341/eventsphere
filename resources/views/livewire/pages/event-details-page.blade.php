<div>
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
                    <li class="text-sm capitalize leading-normal flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-600 mx-2" />
                        {{ $eventData['event_name'] }}
                    </li>
                </ol>
                <h2 class="font-semibold text-3xl capitalize mt-2">
                    {{ $eventData['event_name'] }}
                </h2>
            </nav>
        </div>
    </x-slot>

    <div class="mt-4 font-poppins">
        <!-- Event Details Section -->
        <div class="space-y-6 max-w-5xl overflow-hidden">
            <div class="bg-gray-100 shadow-sm rounded-lg flex flex-col p-4 sm:p-8">
                <!-- Event Header -->
                <div class="relative mb-6">
                    <div class="max-w-5xl h-96 rounded-lg shadow-xl overflow-hidden"
                         x-data="{ imageLoaded: false }">
                        <div
                            x-show="!imageLoaded"
                            class="absolute inset-0 flex items-center justify-center bg-gray-200"
                        >
                            <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <img
                            src="{{ $eventData['image'] }}"
                            alt="{{ $eventData['event_name'] }}"
                            class="w-full h-full object-cover transition-opacity duration-300"
                            x-on:load="imageLoaded = true"
                            x-bind:class="{ 'opacity-0': !imageLoaded, 'opacity-100': imageLoaded }"
                        >
                    </div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-white rounded-full px-4 py-2 text-sm font-semibold text-primary shadow">
                            {{ $eventData['department_name'] }}
                        </span>
                    </div>
                    @if($isRegistered)
                        <div class="absolute top-4 right-4">
                            <span class="bg-success text-white rounded-full px-4 py-2 text-sm font-semibold shadow">
                                Registered
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Event Title and Description -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-accent mb-4">{{ $eventData['event_name'] }}</h1>
                    <p class="text-gray-600">{{ $eventData['description'] }}</p>
                </div>

                <!-- Event Details Grid Container -->
                <div class="w-full mx-auto sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-3 auto-rows-fr">
                        <!-- Venue -->
                        <div class="flex items-center space-x-3">
                            <div class="bg-primary bg-opacity-10 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Venue</p>
                                <p class="text-sm font-semibold text-primary">{{ $eventData['venue_name'] }}</p>
                            </div>
                        </div>
                        <!-- Schedule -->
                        <div class="flex items-center space-x-3">
                            <div class="bg-primary bg-opacity-10 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Schedule</p>
                                <p class="text-sm font-semibold text-primary">{{ $eventData['schedule'] }}</p>
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="flex items-center space-x-3">
                            <div class="bg-primary bg-opacity-10 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Status</p>
                                <p class="text-sm font-semibold {{ $eventData['status'] === 'Postponed' ? 'text-red-500' : ($eventData['status'] === 'Delayed' ? 'text-yellow-500' : 'text-green-500') }}">
                                    {{ $eventData['status'] }}
                                </p>
                            </div>
                        </div>
                        <!-- Department -->
                        <div class="flex items-center space-x-3">
                            <div class="bg-primary bg-opacity-10 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Department</p>
                                <p class="text-sm font-semibold text-primary">{{ $eventData['department_name'] }}</p>
                            </div>
                        </div>
                        <!-- Capacity -->
                        <div class="flex items-center space-x-3">
                            <div class="bg-primary bg-opacity-10 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Capacity</p>
                                <p class="text-sm font-semibold text-primary">{{ $eventData['participant_count'] }} / {{ $eventData['capacity'] }}</p>
                            </div>
                        </div>
                        <!-- Speaker -->
                        <div class="flex items-center space-x-3">
                            <div class="bg-primary bg-opacity-10 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Speaker</p>
                                <p class="text-sm font-semibold text-primary">{{ $eventData['speaker'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Button -->
                <div class="flex justify-end">
                    @if($eventCompleted)
                        <button 
                            disabled
                            class="bg-gray-500 text-white rounded-lg ml-2 text-sm px-4 py-3 font-semibold cursor-not-allowed"
                        >
                            Event Completed
                        </button>
                    @else
                        @if($isRegistered)
                            <button 
                                wire:click="confirmRegistration"
                                wire:loading.attr="disabled"
                                wire:target="confirmRegistration"
                                class="bg-red-600 text-white rounded-lg ml-2 text-sm px-4 py-3 font-semibold hover:bg-red-700 transition-colors inline-flex items-center"
                            >
                                <span wire:loading.remove wire:target="confirmRegistration">Cancel Registration</span>
                                <span wire:loading wire:target="confirmRegistration" class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        @else
                            <button 
                                wire:click="confirmRegistration"
                                wire:loading.attr="disabled"
                                wire:target="confirmRegistration"
                                class="bg-primary text-white rounded-lg ml-2 text-sm px-4 py-3 font-semibold hover:bg-primary-dark transition-colors inline-flex items-center"
                            >
                                <span wire:loading.remove wire:target="confirmRegistration">Register for Event</span>
                                <span wire:loading wire:target="confirmRegistration" class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Feedback Section - Moved to separate section -->
        <div class="space-y-6 max-w-5xl overflow-hidden mt-6">
            <div class="bg-white shadow-sm rounded-lg flex flex-col p-4 sm:p-8">
                <!-- Feedback Section Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">Event Feedback</h2>
                        <div class="flex items-center mt-2">
                            <div class="text-2xl text-yellow-400">
                                {{ number_format($averageRating, 1) }} ★
                            </div>
                            <span class="ml-2 text-gray-600">({{ $feedbackCount }} reviews)</span>
                        </div>
                    </div>
                    @if(Auth::check())
                        @if($showFeedbackForm)
                            <button 
                                wire:click="toggleFeedbackForm"
                                class="p-2 text-gray-500 hover:text-gray-700 rounded-full transition-colors"
                                title="Close"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @elseif(!$userFeedbackExists)
                            <button 
                                wire:click="$toggle('showFeedbackForm')"
                                class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-dark transition-colors"
                            >
                                Write a Review
                            </button>
                        @else
                            <button 
                                wire:click="editFeedback"
                                class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-dark transition-colors"
                            >
                                Edit Your Review
                            </button>
                        @endif
                    @endif
                </div>

                <!-- Feedback Form -->
                @if($showFeedbackForm)
                    <div class="p-4 mb-8 bg-gray-50 rounded-lg">
                        <form wire:submit.prevent="saveFeedback">
                            <!-- Form Header -->
                            <h3 class="text-lg font-semibold mb-4">
                                {{ $userFeedbackExists ? 'Edit Your Review' : 'Write a Review' }}
                            </h3>
                            
                            <!-- Rating -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                <div class="flex space-x-2" 
                                    x-data="{ 
                                        hoveredRating: 0, 
                                        selectedRating: {{ $rating ?? 0 }},
                                        setHovered(rating) {
                                            this.hoveredRating = rating;
                                        },
                                        clearHovered() {
                                            this.hoveredRating = 0;
                                        },
                                        isStarred(star) {
                                            return this.hoveredRating ? star <= this.hoveredRating : star <= this.selectedRating;
                                        }
                                    }"
                                >
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            wire:click="setRating({{ $i }})"
                                            @click="selectedRating = {{ $i }}"
                                            @mouseover="setHovered({{ $i }})"
                                            @mouseleave="clearHovered()"
                                            class="text-3xl focus:outline-none transition-colors duration-150"
                                        >
                                            <span class="transition-colors duration-150" 
                                                :class="{
                                                    'text-yellow-400': isStarred({{ $i }}),
                                                    'text-gray-300': !isStarred({{ $i }})
                                                }"
                                            >★</span>
                                        </button>
                                    @endfor
                                </div>
                                @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Comment -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Comment</label>
                                <textarea
                                    wire:model="comment"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                    rows="4"
                                    placeholder="Share your thoughts about this event..."
                                ></textarea>
                                @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button"
                                        wire:click="cancelFeedback"
                                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                                    {{ $userFeedbackExists ? 'Update Review' : 'Submit Review' }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Recent Reviews -->
                @if($recentFeedbacks->isNotEmpty())
                    <div class="space-y-6">
                        @foreach($recentFeedbacks as $feedback)
                            <div class="border-b border-gray-200 pb-6 last:border-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-3">
                                        <!-- User Avatar -->
                                        <img 
                                            src="{{ $feedback->user->id === 1 
                                                ? Storage::disk('s3')->temporaryUrl($feedback->user->avatar, now()->addMinutes(60))
                                                : ($feedback->user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($feedback->user->name)) }}"
                                            alt="{{ $feedback->user->name }}"
                                            class="w-10 h-10 rounded-full object-cover"
                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($feedback->user->name) }}'"
                                        />
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $feedback->user->name }}</span>
                                            <div class="flex items-center">
                                                <div class="text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="{{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                                    @endfor
                                                </div>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span class="text-sm text-gray-500">
                                                    {{ $feedback->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 ml-13">{{ $feedback->comment }}</p>
                            </div>
                        @endforeach

                        @if($feedbackCount > 3)
                            <div class="text-center pt-4">
                                <button 
                                    wire:click="loadMoreFeedback"
                                    class="text-primary hover:text-primary-dark font-medium transition-colors"
                                >
                                    View all {{ $feedbackCount }} reviews
                                </button>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center text-gray-500 py-8">
                        No reviews yet. Be the first to leave a review!
                    </div>
                @endif                
            </div>
        </div>
    </div>

    @if($showConfirmationModal)
        <!-- Modal Backdrop -->
        <div 
            x-data
            @click="$wire.closeModal()"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-40">
        </div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                     @click.stop>
                    <!-- Close button -->
                    <button 
                        type="button" 
                        wire:click="closeModal"
                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Modal Content -->
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-{{ $modalAction === 'register' ? 'green' : 'red' }}-100 sm:mx-0 sm:h-10 sm:w-10">
                            @if($modalAction === 'register')
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            @endif
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">
                                {{ $modalAction === 'register' ? 'Confirm Registration' : 'Cancel Registration' }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ $modalAction === 'register' 
                                        ? 'Are you sure you want to register for this event?' 
                                        : 'Are you sure you want to cancel your registration?' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button" 
                                wire:click="handleRegistration"
                                wire:loading.attr="disabled"
                                wire:target="handleRegistration"
                                class="inline-flex w-full justify-center rounded-md {{ $modalAction === 'register' ? 'bg-primary hover:bg-primary-dark' : 'bg-red-600 hover:bg-red-500' }} px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto">
                            <span wire:loading.remove wire:target="handleRegistration">
                                {{ $modalAction === 'register' ? 'Register' : 'Cancel Registration' }}
                            </span>
                            <span wire:loading wire:target="handleRegistration" class="flex items-center justify-center">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                        <button type="button" 
                                wire:click="closeModal"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
