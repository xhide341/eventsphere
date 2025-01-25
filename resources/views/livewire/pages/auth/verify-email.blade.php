<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as DefaultVerifyEmail;
use App\Notifications\PendingUserNotifiable;

new #[Layout('layouts.guest')] class extends Component
{
    public function mount()
    {
        // Check both regular and flashed session data
        if (!Session::has('pending_user') && !Session::has('_pending_user')) {
            return redirect()->route('register');
        }

        // Restore from flash if needed
        if (!Session::has('pending_user') && Session::has('_pending_user')) {
            Session::put('pending_user', Session::get('_pending_user'));
        }

        Session::save();
    }

    public function resendVerification(): void
    {
        $pendingUser = Session::get('pending_user');
        
        if (!$pendingUser) {
            return;
        }

        // Check resend limit
        $resendCount = Session::get('resend_count', 0);
        $resendLimit = 6;

        if ($resendCount >= $resendLimit) {
            Session::flash('status', 'resend-limit-reached');
            return;
        }

        // Create temporary notifiable object
        $notifiable = new PendingUserNotifiable($pendingUser['id'], $pendingUser['email']);

        // Send verification using Laravel's default notification
        Notification::send($notifiable, new DefaultVerifyEmail);

        // Increment resend count
        Session::put('resend_count', $resendCount + 1);

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div>
    <div class="space-y-6">
        <p class="text-sm text-gray-600 text-center">
        Thanks for signing up! Please check your email for a verification link we just sent to <span
        class="font-medium text-primary">{{ Session::get('pending_user.email', 'your email address') }}</span>.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                <p class="text-sm text-green-700">
                    A new verification link has been sent to your email address.
                </p>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <x-primary-button 
                class="w-full flex justify-center items-center relative"
                wire:click="resendVerification"
                wire:loading.attr="disabled"
                wire:target="resendVerification"
            >
                <span wire:loading.remove wire:target="resendVerification">{{ __('Resend Verification Email') }}</span>
                <span wire:loading wire:target="resendVerification" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </x-primary-button>
        </div>
    </div>
</div>
