<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\Log;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $avatar;
    public $avatarUrl;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->generateAvatarUrl();
    }

    /**
     * Generate a temporary URL for the user's avatar.
     */
    public function generateAvatarUrl(): void
    {
        $user = Auth::user();
        if ($user->avatar_type === 'google') {
            $this->avatarUrl = $user->avatar;
        } elseif ($user->avatar_type === 's3') {
            $this->avatarUrl = Storage::disk('s3')->temporaryUrl($user->avatar, now()->addMinutes(120));
        } else {
            $this->avatarUrl = "https://api.dicebear.com/9.x/initials/svg?seed=" . urlencode($user->name);
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        if ($this->avatar) {
            $this->validate(['avatar' => ['image', 'max:1024']]);
            try {
                // Assign path to a filename
                $filename = 'avatar-' . $user->id . '-' . time() . '.webp';

                // Get file contents from temporary URL
                $contents = file_get_contents($this->avatar->temporaryUrl());

                // Use the temporary path
                $image = Image::read($contents);

                // Encode the image to WebP format
                $encoded = $image->encode(new WebpEncoder(65));

                // Store the encoded image content in S3
                $success = Storage::disk('s3')->put('avatars/' . $filename, $encoded->toString(), 'public');

                if ($success) {
                    // Update the user's avatar field with the S3 filename and type
                    $user->avatar = 'avatars/' . $filename;
                    $user->avatar_type = 's3';  // Set avatar type to 's3'
                    Log::info('Avatar uploaded successfully to S3', ['user_id' => $user->id, 'filename' => $filename]);
                } else {
                    throw new \Exception('Failed to store file in S3');
                }

            } catch (\Exception $e) {
                Log::error('Avatar upload failed', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id,
                    'file_path' => $this->avatar->path(),
                    'file_exists' => file_exists($this->avatar->path()) ? 'Yes' : 'No',
                    'mime_type' => $this->avatar->getMimeType()
                ]);
                session()->flash('error', 'Failed to upload avatar: ' . $e->getMessage());
            }
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        try {
            $user->save();
            Log::info('User profile updated successfully', [
                'user_id' => $user->id, 
                'avatar' => $user->avatar,
                'avatar_type' => $user->avatar_type
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save user profile', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            session()->flash('error', 'Failed to update profile: ' . $e->getMessage());
            return;
        }

        // Regenerate the avatar URL after successful update
        $this->generateAvatarUrl();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6" enctype="multipart/form-data">
        <!-- Avatar Display and Upload Field -->
        <div x-data="{ 
            dragOver: false,
            handleDrop(e) {
                this.dragOver = false;
                if (e.dataTransfer.files.length) {
                    this.$refs.fileInput.files = e.dataTransfer.files;
                    this.$refs.fileInput.dispatchEvent(new Event('change'));
                }
            }
        }" class="mb-6">
            <x-input-label for="avatar" :value="__('Avatar')" />
            
            <!-- Current Avatar Display -->
            <div class="mt-2 mb-4 flex items-center">
                <div class="mr-4 relative">
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" alt="New Avatar" class="h-20 w-20 rounded-full object-cover mb-4 border-0">
                    @else
                        <img src="{{ $avatarUrl }}" alt="Current Avatar" class="h-20 w-20 rounded-full object-cover mb-4 border-0">                    
                    @endif
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ __('Avatar Preview') }}</p>
                    <p class="text-xs text-gray-500">{{ $avatarUrl || $avatar ? __('Your current profile picture') : __('No avatar set') }}</p>
                </div>
            </div>

            <!-- Drag and Drop Upload Area -->
            <div
                x-on:dragover.prevent="dragOver = true"
                x-on:dragleave.prevent="dragOver = false"
                x-on:drop.prevent="handleDrop($event)"
                :class="{ 'border-blue-500 bg-blue-50': dragOver }"
                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-primary-dark border-dashed rounded-md relative"
            >
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="avatar" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                            <span>{{ __('Upload a new avatar') }}</span>
                            <input 
                                id="avatar" 
                                name="avatar" 
                                type="file" 
                                wire:model="avatar"
                                x-ref="fileInput"
                                class="sr-only"
                                accept="image/*"
                            >
                        </label>
                        <p class="pl-1">{{ __('or drag and drop') }}</p>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ __('PNG, JPG, WEBP up to 1MB') }}
                    </p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button 
                wire:loading.attr="disabled" 
                wire:target="updateProfileInformation" 
                class="flex items-center relative leading-none text-sm px-4 py-2 tracking-normal"
            >
                <span wire:loading.remove wire:target="updateProfileInformation">
                    {{ __('Save') }}
                </span>
                <span wire:loading wire:target="updateProfileInformation" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>                    
                </span>
            </x-primary-button>

            <x-action-message class="me-3 text-success" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>

        <!-- Loading Modal -->
        <div 
            wire:loading.flex 
            wire:target="avatar" 
            class="fixed inset-0 items-center justify-center z-50 bg-black bg-opacity-50 backdrop-blur-sm"
            style="margin: 0; padding: 0; top: 0; left: 0; right: 0; bottom: 0;"
        >
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <svg class="animate-spin h-12 w-12 text-primary mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-gray-700">{{ __('Uploading avatar...') }}</p>
            </div>
        </div>
    </form>
</section>
