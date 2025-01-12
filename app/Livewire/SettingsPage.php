<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingsPage extends Component
{
    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect('/', navigate: true);
    }

    public function toggleNotifications()
    {
        try {
            $user = auth()->user();
            $user->event_notifications_enabled = !$user->event_notifications_enabled;
            $user->save();
        } catch (\Exception $e) {
            Log::error('Failed to update notification preferences: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pages.settings');
    }
}
