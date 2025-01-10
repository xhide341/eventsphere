<?php

use App\Models\User;
use App\Models\Student;
use App\Models\Organizer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'student'; // Default role

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,organizer'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('events', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register" class="space-y-6">
        <!-- Name and Email wrapper -->
        <div class="lg:flex lg:space-x-4 lg:space-y-0 space-y-6">
            <!-- Name -->
            <div class="lg:w-1/2">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input 
                    wire:model="name" 
                    id="name" 
                    class="block mt-1 w-full text-custom-black text-sm" 
                    type="text" 
                    name="name" 
                    required 
                    autofocus 
                    autocomplete="name"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="lg:w-1/2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input 
                    wire:model="email" 
                    id="email" 
                    class="block mt-1 w-full text-custom-black text-sm" 
                    type="email" 
                    name="email" 
                    required 
                    autocomplete="username"                
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input 
                wire:model="password" 
                id="password" 
                class="block mt-1 w-full text-custom-black text-sm"
                type="password"
                name="password"
                required 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input 
                wire:model="password_confirmation" 
                id="password_confirmation" 
                class="block mt-1 w-full text-custom-black text-sm"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button 
                class="w-full flex justify-center items-center relative mt-4"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>{{ __('Register') }}</span>
                <span wire:loading class="flex items-center">
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
            {{ __('Sign up with Google') }}
        </a>
    </div>

    <div class="mt-6 md:mt-8 flex text-center justify-center">
        <p class="text-gray-600 text-sm">Already have an account? <a href="{{ route('login') }}" class="text-accent hover:text-accent/80 hover:underline transition-colors duration-200">Log in</a></p>
    </div>
</div>