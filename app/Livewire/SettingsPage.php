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

        session()->flash('message', 'Notification preferences updated successfully');
    }

    public function render()
    {
        return view('livewire.pages.settings');
    }
}
