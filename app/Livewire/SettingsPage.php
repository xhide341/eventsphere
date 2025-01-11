<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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
        $user = auth()->user();
        $user->event_notifications_enabled = !$user->event_notifications_enabled;
        $user->save();

        try {
            notify()->success('Notification preferences updated successfully.');
        } catch (\Exception $e) {
            notify()->error('Failed to update notification preferences.');
        }
    }

    public function render()
    {
        return view('livewire.pages.settings');
    }
}
