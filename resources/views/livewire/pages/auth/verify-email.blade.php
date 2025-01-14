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

        // Create temporary notifiable object
        $notifiable = new PendingUserNotifiable($pendingUser['id'], $pendingUser['email']);

        // Send verification using Laravel's default notification
        Notification::send($notifiable, new DefaultVerifyEmail);

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-sm">
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Verify Your Email</h2>
            <p class="text-sm text-gray-600">
                Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent to <span class="font-medium text-primary">{{ Session::get('pending_user.email', 'your email address') }}</span>.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                <p class="text-sm text-green-700">
                    A new verification link has been sent to your email address.
                </p>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <button wire:click="resendVerification" type="button" class="btn-primary">
                Resend Verification Email
            </button>

            <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                Start Over
            </a>
        </div>
    </div>
</div>
