<div x-data="{ 
  showModal: false,
  imageLoaded: false,
  modalImageLoaded: false 
}" x-cloak>
  <div class="h-full">
    <div
      class="relative flex h-full flex-col rounded-xl bg-gray-300 bg-clip-border text-gray-700 shadow-lg border-2 border-muted-teal"
      @click="showModal = true; imageLoaded = false; modalImageLoaded = false;">
      <div
        class="relative mx-4 mt-4 overflow-hidden rounded-md bg-blue-gray-500 bg-clip-border text-white shadow-lg shadow-blue-gray-500/40">
        <div class="relative w-full h-[10rem]">
          <div x-data="{ imageLoaded: false }" class="w-full h-full">
            <div x-show="!imageLoaded" class="absolute inset-0 flex items-center justify-center bg-gray-200">
              <svg class="animate-spin h-8 w-8 text-primary-dark" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
            </div>
            <img src="{{ $modalContent['image'] }}" alt="{{ $modalContent['event_name'] }}"
              class="w-full h-full object-cover shadow-md" x-on:load="imageLoaded = true"
              x-bind:class="{ 'opacity-0': !imageLoaded, 'opacity-100': imageLoaded }" />
          </div>
        </div>
        <div
          class="to-bg-black-10 absolute inset-0 h-full w-full bg-gradient-to-tr from-transparent via-transparent to-black/60">
        </div>
        @if($modalContent['is_user_registered'])
      <button
        class="!absolute top-4 right-4 h-8 max-h-[32px] w-8 max-w-[32px] select-none rounded-full text-center align-middle text-xs font-medium uppercase text-red-500 transition-all hover:bg-red-500/10 active:bg-red-500/30 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
        type="button" data-ripple-dark="true" wire:poll.5s>
        <span class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 transform">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
          class="h-6 w-6">
          <path
          d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z">
          </path>
        </svg>
        </span>
      </button>
    @endif
        <div class="absolute bottom-0 left-0 p-2">
          <span class="bg-white rounded-full px-3 py-1 text-sm font-semibold text-primary-dark">
            {{ $modalContent['department_name'] }}
          </span>
        </div>
      </div>
      <div class="pt-6 px-6 pb-0 2xl:pb-4">
        <div class="mb-3 flex flex-col justify-between">
          <h5
            class="block text-lg 2xl:text-xl font-medium leading-snug tracking-normal text-blue-gray-900 antialiased truncate">
            {{ $modalContent['event_name'] }}
          </h5>
          <p class="text-sm font-normal text-primary-dark-dark overflow-hidden truncate">
            {{ $modalContent['venue_name'] }}
          </p>
        </div>
        <div class="min-h-10">
          <p class="line-clamp-2 2xl:line-clamp-3 text-pretty text-xs 2xl:text-sm font-normal text-gray-700 p-0">
            {{ $modalContent['description'] }}
          </p>
        </div>
      </div>

      <!-- Separated SVG container with full width and padding -->
      <div class="flex w-full p-6 lg:hidden 2xl:block">
        <div class="flex justify-evenly w-full">
          <span data-tooltip-target="money"
            class="cursor-pointer rounded-full border border-patten-blue bg-white p-2 sm:p-3 text-primary-dark-500 transition-colors hover:border-primary-500/10 hover:bg-primary-500/10 hover:!opacity-100 group-hover:opacity-70">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
              class="h-4 w-4 sm:h-5 sm:w-5">
              <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
              <path fill-rule="evenodd"
                d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z"
                clip-rule="evenodd"></path>
              <path
                d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z">
              </path>
            </svg>
          </span>
          <span data-tooltip-target="wifi"
            class="cursor-pointer rounded-full border border-patten-blue bg-white p-2 sm:p-3 text-primary-dark-500 transition-colors hover:border-primary-500/10 hover:bg-primary-500/10 hover:!opacity-100 group-hover:opacity-70">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
              class="h-4 w-4 sm:h-5 sm:w-5">
              <path fill-rule="evenodd"
                d="M1.371 8.143c5.858-5.857 15.356-5.857 21.213 0a.75.75 0 010 1.061l-.53.53a.75.75 0 01-1.06 0c-4.98-4.979-13.053-4.979-18.032 0a.75.75 0 01-1.06 0l-.53-.53a.75.75 0 010-1.06zm3.182 3.182c4.1-4.1 10.749-4.1 14.85 0a.75.75 0 010 1.061l-.53.53a.75.75 0 01-1.062 0 8.25 8.25 0 00-11.667 0 .75.75 0 01-1.06 0l-.53-.53a.75.75 0 010-1.06zm3.204 3.182a6 6 0 018.486 0 .75.75 0 010 1.061l-.53.53a.75.75 0 01-1.061 0l-.53-.53a.75.75 0 010-1.06zm3.182 3.182a1.5 1.5 0 012.122 0 .75.75 0 010 1.061l-.53.53a.75.75 0 01-1.061 0l-.53-.53a.75.75 0 010-1.06z"
                clip-rule="evenodd"></path>
            </svg>
          </span>
          <span data-tooltip-target="bedrooms"
            class="cursor-pointer rounded-full border border-patten-blue bg-white p-2 sm:p-3 text-primary-dark-500 transition-colors hover:border-primary-500/10 hover:bg-primary-500/10 hover:!opacity-100 group-hover:opacity-70">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
              class="h-4 w-4 sm:h-5 sm:w-5">
              <path
                d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z">
              </path>
              <path
                d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z">
              </path>
            </svg>
          </span>
          <span data-tooltip-target="tv"
            class="cursor-pointer rounded-full border border-patten-blue bg-white p-2 sm:p-3 text-primary-dark-500 transition-colors hover:border-primary-500/10 hover:bg-primary-500/10 hover:!opacity-100 group-hover:opacity-70">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
              class="h-4 w-4 sm:h-5 sm:w-5">
              <path d="M19.5 6h-15v9h15V6z"></path>
              <path fill-rule="evenodd"
                d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v11.25C1.5 17.16 2.34 18 3.375 18H9.75v1.5H6A.75.75 0 006 21h12a.75.75 0 000-1.5h-3.75V18h6.375c1.035 0 1.875-.84 1.875-1.875V4.875C22.5 3.839 21.66 3 20.625 3H3.375zm0 13.5h17.25a.375.375 0 00.375-.375V4.875a.375.375 0 00-.375-.375H3.375A.375.375 0 003 4.875v11.25c0 .207.168.375.375.375z"
                clip-rule="evenodd"></path>
            </svg>
          </span>
          <span data-tooltip-target="fire"
            class="cursor-pointer rounded-full border border-patten-blue bg-white p-2 sm:p-3 text-primary-dark-500 transition-colors hover:border-primary-500/10 hover:bg-primary-500/10 hover:!opacity-100 group-hover:opacity-70">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
              class="h-4 w-4 sm:h-5 sm:w-5">
              <path fill-rule="evenodd"
                d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177A7.547 7.547 0 016.648 6.61a.75.75 0 00-1.152-.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248zM15.75 14.25a3.75 3.75 0 11-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 011.925-3.545 3.75 3.75 0 013.255 3.717z"
                clip-rule="evenodd"></path>
            </svg>
          </span>
        </div>
      </div>
      <div class="p-6 pt-3">
        <button @click="showModal = true; imageLoaded = false; modalImageLoaded = false;"
          class="w-full block relative overflow-hidden rounded-md bg-primary hover:bg-primary-light py-3 px-7 text-center text-sm font-semibold text-white transition-all duration-500 ease-out wave-effect">
          <span class="relative z-10">View</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!-- Backdrop -->
      <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <!-- Modal content -->
      <div x-show="showModal"
        class="inline-block align-bottom bg-white rounded-lg border-2 border-primary-dark text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full max-w-[95%] sm:max-w-lg">
        <div class="leading-normal font-poppins bg-white px-3 pt-4 pb-3 sm:p-6 sm:pb-4">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl leading-6 font-semibold text-primary-dark" id="modal-title">
              {{ $modalContent['event_name'] }}
            </h3>
            <button type="button" class="text-gray-400 transition-colors duration-200 hover:text-gray-500"
              @click="showModal = false; imageLoaded = false; modalImageLoaded = false;">
              <span class="sr-only">Close</span>
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="mt-2 break-words text-pretty font-normal">
            <div class="relative mb-4">
              <div x-data="{ modalImageLoaded: false }" class="w-full h-64 rounded-lg overflow-hidden shadow-md">
                <div x-show="!modalImageLoaded" class="absolute inset-0 flex items-center justify-center bg-gray-200">
                  <svg class="animate-spin h-8 w-8 text-primary-dark" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                  </svg>
                </div>
                <div class="w-full h-64 rounded-md overflow-hidden">
                  <img src="{{ $modalContent['image'] }}" alt="{{ $modalContent['event_name'] }}"
                    class="w-full h-full object-cover" x-on:load="modalImageLoaded = true"
                    x-bind:class="{ 'opacity-0': !modalImageLoaded, 'opacity-100': modalImageLoaded }">
                </div>
              </div>
              <p
                class="absolute bottom-2 left-2 bg-white rounded-full px-3 py-1 text-sm font-semibold text-primary-dark shadow">
                {{ $modalContent['department_name'] }}
              </p>

              <!-- New countdown section -->
              <div
                class="absolute top-2 right-2 bg-white rounded-full px-3 py-1 text-sm font-semibold text-primary-dark shadow flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $modalContent['countdown'] }}</span>
              </div>
            </div>
            <div class="mt-4">
              <h5 class="text-xl font-semibold text-primary-dark mb-3">Event Details</h5>
              <div class="bg-gray-100 rounded-lg p-4 shadow-sm">
                <p class="text-xs sm:text-sm text-primary-dark font-normal mb-4 text-wrap p-0">
                  {{ $modalContent['description'] }}
                </p>
                <div class="flex justify-between">
                  <div class="grid grid-cols-1 gap-x-5 gap-y-4 md:grid-cols-2 w-full">
                    <div class="flex items-center space-x-3">
                      <div class="bg-primary bg-opacity-10 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500 font-medium">Venue</p>
                        <p class="text-sm font-semibold text-primary-dark">{{ $modalContent['venue_name'] }}</p>
                      </div>
                    </div>
                    <div class="flex items-center space-x-3">
                      <div class="bg-primary bg-opacity-10 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500 font-medium">Schedule</p>
                        <p class="text-sm font-semibold text-primary-dark text-nowrap">{{ $modalContent['schedule'] }}
                        </p>
                      </div>
                    </div>
                    <div class="flex items-center space-x-3">
                      <div class="bg-primary bg-opacity-10 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500 font-medium">Status</p>
                        <p
                          class="text-sm font-semibold {{ $modalContent['status'] === 'Postponed' ? 'text-red-500' : ($modalContent['status'] === 'Delayed' ? 'text-yellow-500' : ($modalContent['status'] === 'Scheduled' ? 'text-green-500' : 'text-primary-dark')) }}">
                          {{ $modalContent['status'] }}
                        </p>
                      </div>
                    </div>
                    <div class="flex items-center space-x-3">
                      <div class="bg-primary bg-opacity-10 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500 font-medium">Department</p>
                        <p class="text-sm font-semibold text-primary-dark">{{ $modalContent['department_name'] }}</p>
                      </div>
                    </div>
                    <div class="flex items-center space-x-3">
                      <div class="bg-primary bg-opacity-10 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500 font-medium">Capacity</p>
                        <p class="text-sm font-semibold text-primary-dark">{{ $modalContent['participant_count'] }} /
                          {{ $modalContent['capacity'] }}
                        </p>
                      </div>
                    </div>
                    <div class="flex items-center space-x-3">
                      <div class="bg-primary bg-opacity-10 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500 font-medium">Speaker</p>
                        <p class="text-sm font-semibold text-primary-dark">{{ $modalContent['speaker'] }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-3 py-3 sm:px-6 sm:flex sm:flex-row-reverse space-y-2 sm:space-y-0">
          <a href="{{ route('event.details', $modalContent['event_id']) }}"
            class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2.5 text-base font-medium text-white bg-primary hover:bg-primary-light focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
            View Full Detail
          </a>
        </div>
      </div>
    </div>
  </div>
</div>