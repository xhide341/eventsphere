<x-app-layout>
    <div x-data="{ verified: false, resending: false }" x-init="setInterval(() => {
            fetch('/check-verification-status')
                .then(response => response.json())
                .then(data => {
                    if (data.verified) {
                        window.location.href = '/events';
                    }
                });
         }, 10000)"> <!-- Check every 10 seconds -->

        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Please click the link in your email to verify your account.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}" x-on:submit="resending = true"
                x-on:verification-sent.window="resending = false">
                @csrf
                <button type="submit" class="btn-primary inline-flex items-center" :disabled="resending">
                    <span x-show="!resending">Resend Verification Email</span>
                    <span x-show="resending" class="flex items-center justify-center">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</x-app-layout>