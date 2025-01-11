<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Event;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventCard extends Component
{
    public Event $event;
    public $type;
    public $modalContent;
    public $eventCompleted;

    public function mount(Event $event, $type)
    {
        $this->event = $event;
        $this->type = $type;

        // Add event completion check
        $eventEndDateTime = Carbon::parse($this->event->end_date)
            ->setTimeFrom(Carbon::parse($this->event->end_time));

        $this->eventCompleted = $eventEndDateTime->isPast();

        $this->modalContent = $this->getModalContent();
    }

    #[Computed]
    public function getModalContent()
    {
        return [
            'event_id' => $this->event->id,
            'event_name' => $this->event->name ?? 'No name assigned',
            'description' => $this->event->description,
            'image' => $this->event->image,
            'department_name' => $this->event->department->name ?? 'No department assigned',
            'venue_name' => $this->event->venue->name ?? 'No venue assigned',
            'capacity' => $this->event->venue->capacity ?? 'No capacity',
            'status' => $this->event->status,
            'schedule' => $this->getSchedule(),
            'speaker' => $this->event->speaker ? $this->event->speaker->name : 'No speaker assigned',
            'participant_count' => $this->getParticipantCount(),
            'is_user_registered' => $this->isUserRegistered(),
            'countdown' => $this->getCountdown(),
            'event_completed' => $this->eventCompleted
        ];
    }

    public function getParticipantCount()
    {
        return $this->event->users()->count();
    }

    public function isUserRegistered()
    {
        return Auth::check() && $this->event->isUserRegistered(Auth::user()->id);
    }

    public function getCountdown()
    {
        try {
            // Start DateTime
            $startDateTime = Carbon::parse($this->event->start_date)
                ->setTimeFrom(Carbon::parse($this->event->start_time));

            // End DateTime
            $endDateTime = Carbon::parse($this->event->end_date)
                ->setTimeFrom(Carbon::parse($this->event->end_time));

            $now = Carbon::now();

            if ($now->gt($endDateTime)) {
                return 'Event has ended';
            }

            if ($now->gt($startDateTime)) {
                return 'Event in progress';
            }

            $diff = $now->diff($startDateTime);

            if ($diff->days > 0) {
                return 'Starts in: ' . $diff->format('%d days, %h hrs');
            } elseif ($diff->h > 0) {
                return 'Starts in: ' . $diff->format('%h hrs, %i mins');
            } else {
                return 'Starts in: ' . $diff->format('%i mins');
            }
        } catch (\Exception $e) {
            return 'Invalid date format';
        }
    }

    public function toggleRegistration()
    {
        if (!Auth::check()) {
            return;
        }

        if ($this->isUserRegistered()) {
            $this->event->users()->detach(Auth::user()->id);
        } else {
            $this->event->users()->attach(Auth::user()->id, ['registration_date' => now()]);
        }

        $this->event->refresh();
        $this->dispatch('eventUpdated');
    }

    public function getSchedule()
    {
        try {
            // Create a new Carbon instance from the date
            $dateTime = Carbon::parse($this->event->start_date->toDateString());

            // Set the time from the time object
            $dateTime->setHour($this->event->start_time->hour)
                ->setMinute($this->event->start_time->minute)
                ->setSecond($this->event->start_time->second);

            return $dateTime->format('M j, Y g:i A');
        } catch (\Exception $e) {
            return 'Invalid date format';
        }
    }

    public function render()
    {
        return view('livewire.components.event-card');
    }
}
