<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    // Add method to validate single field
    public function validateField($field)
    {
        // Only validate if the field has a value
        if (!empty($this->form->{$field})) {
            $this->validateOnly('form.' . $field);
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('events', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email *')" />
            <x-text-input 
                wire:model.blur="form.email"
                wire:blur="validateField('email')"
                id="email" 
                class="block mt-1 w-full text-custom-black text-sm" 
                type="email" 
                name="email" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="{{ __('email@example.com') }}"
                minlength="3"
                maxlength="254"
            />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-xs" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password *')" />
            <div class="relative">
                <x-text-input 
                    wire:model.blur="form.password"
                    wire:blur="validateField('password')"
                    id="password" 
                    x-ref="passwordInput"
                    class="block mt-1 w-full pr-10 text-custom-black text-sm" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="{{ __('********') }}"
                    minlength="8"
                    maxlength="64"
                />
                <button 
                    type="button" 
                    x-data="{ show: false }"
                    @click="
                        show = !show;
                        $refs.passwordInput.type = show ? 'text' : 'password';
                    "
                    :class="show ? 'text-gray-600' : 'text-gray-400'"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            x-show="!show"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round"
                            x-show="show" 
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                        />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs" />
            <p class="text-xs text-gray-500 mt-1">{{ __('Minimum 8 characters') }}</p>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center">
                <input 
                    wire:model="form.remember" 
                    id="remember" 
                    type="checkbox" 
                    class="rounded border-gray-400 text-accent shadow-sm ring-0 focus:ring-0 focus:ring-offset-0"
                    name="remember"
                >
                <span class="ml-2 text-xs md:text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-xs md:text-sm text-accent hover:underline transition-colors duration-200" 
                   href="{{ route('password.request') }}" 
                   wire:navigate>
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div>
            <x-primary-button 
                class="w-full flex justify-center items-center relative"
                wire:loading.attr="disabled"
                wire:target="login"
            >
                <span wire:loading.remove wire:target="login">{{ __('Log in') }}</span>
                <span wire:loading wire:target="login" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="relative mt-6">
        <div class="relative flex justify-center text-sm">
            <span class="px-2 text-gray-500">{{ __('Or continue with') }}</span>
        </div>
    </div>

    <!-- Google Login Button -->
    <div class="mt-6">
        <a href="{{ route('auth.google') }}" 
           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors duration-200"
        >
            <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            {{ __('Sign in with Google') }}
        </a>
    </div>

    <div class="mt-6 sm:mt-8 flex text-center justify-center">
        <p class="text-gray-600 text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-accent hover:text-accent/80 hover:underline transition-colors duration-200">Sign up</a></p>
    </div>
</div>