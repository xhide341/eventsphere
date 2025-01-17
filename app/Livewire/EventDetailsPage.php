<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Event;
use App\Models\Feedback;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EventRegistration;

#[Layout('layouts.app')]
class EventDetailsPage extends Component
{
    public Event $event;
    public $rating = 0;
    public $comment = '';
    public $showFeedbackForm = false;
    public $isRegistered = false;
    public $userFeedbackExists = false;
    public $recentFeedbacks;
    public $averageRating;
    public $feedbackCount;
    public $eventData;
    public $showAllFeedback = false;
    public $showConfirmationModal = false;
    public $modalAction = ''; // 'register' or 'cancel'
    public $eventCompleted = false;

    public function mount(Event $event)
    {
        $this->event = $event;

        $eventEndDateTime = Carbon::parse($this->event->end_date)
            ->setTimeFrom(Carbon::parse($this->event->end_time));

        $this->eventCompleted = $eventEndDateTime->isPast();

        if (Auth::check()) {
            $this->isRegistered = $this->event->users()->where('user_id', Auth::id())->exists();
        }

        $this->loadEventData();
        $this->eventData = $this->getEventData();
    }

    protected function getEventData()
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
        ];
    }

    protected function getSchedule()
    {
        try {
            $dateTime = Carbon::parse($this->event->start_date->toDateString());

            $dateTime->setHour($this->event->start_time->hour)
                ->setMinute($this->event->start_time->minute)
                ->setSecond($this->event->start_time->second);

            return $dateTime->format('M j, Y g:i A');
        } catch (\Exception $e) {
            return 'Invalid date format';
        }
    }

    protected function getParticipantCount()
    {
        return $this->event->users()->count();
    }

    public function loadEventData()
    {
        if (Auth::check()) {
            $this->isRegistered = $this->event->users()->where('user_id', Auth::id())->exists();

            $userFeedback = $this->event->feedbacks()
                ->where('user_id', Auth::id())
                ->first();

            if ($userFeedback) {
                $this->userFeedbackExists = true;
                $this->rating = $userFeedback->rating;
                $this->comment = $userFeedback->comment;
            }
        }

        $this->recentFeedbacks = $this->event->feedbacks()
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        $avgRating = (float) $this->event->feedbacks()->avg('rating') ?? 0;
        $this->averageRating = number_format($avgRating, 1);

        $this->feedbackCount = $this->event->feedbacks()->count();
    }

    public function loadMoreFeedback()
    {
        $this->showAllFeedback = true;

        $this->recentFeedbacks = $this->event->feedbacks()
            ->with('user')
            ->latest()
            ->get();
    }

    public function confirmRegistration()
    {
        \Log::info('Confirm Registration called');
        $this->modalAction = $this->isRegistered ? 'cancel' : 'register';
        $this->showConfirmationModal = true;
        \Log::info('Modal state:', [
            'showConfirmationModal' => $this->showConfirmationModal,
            'modalAction' => $this->modalAction
        ]);
    }

    public function closeModal()
    {
        $this->showConfirmationModal = false;
    }

    public function handleRegistration()
    {
        \Log::info('Handle Registration called');

        try {
            if (!Auth::check()) {
                \Log::info('User not authenticated');
                return redirect()->route('login');
            }


            if ($this->isRegistered) {
                \Log::info('Cancelling registration for event: ' . $this->event->id);
                $this->event->users()->detach(Auth::id());
                // Add debug for cancellation notification
                try {
                    Auth::user()->notify(new EventRegistration($this->event, 'cancellation'));
                    \Log::info('Cancellation notification sent successfully');
                } catch (\Exception $e) {
                    \Log::error('Failed to send cancellation notification:', ['error' => $e->getMessage()]);
                }
            } else {
                // Check if event is at capacity using venue capacity
                $currentParticipants = $this->event->users()->count();
                if ($currentParticipants >= $this->event->venue->capacity) {
                    \Log::info('Event at capacity: ' . $this->event->id . ', Venue capacity: ' . $this->event->venue->capacity);
                    session()->flash('error', 'This event has reached its capacity.');
                    $this->showConfirmationModal = false;
                    return;
                }

                \Log::info('Registering for event: ' . $this->event->id);
                $this->event->users()->attach(Auth::id(), [
                    'registration_date' => now()
                ]);
                try {
                    $notification = new EventRegistration($this->event, 'registration');
                    \Log::info('Attempting to send notification:', [
                        'user_id' => Auth::id(),
                        'event_id' => $this->event->id,
                        'notification_class' => get_class($notification),
                        'channels' => $notification->via(Auth::user())
                    ]);

                    Auth::user()->notify($notification);

                    \Log::info('Notification sent successfully');
                } catch (\Exception $e) {
                    \Log::error('Failed to send notification:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'user_id' => Auth::id(),
                        'event_id' => $this->event->id
                    ]);
                }
            }

            $this->event->refresh();
            $this->isRegistered = !$this->isRegistered;
            $this->showConfirmationModal = false;

            session()->flash('message', $this->isRegistered
                ? 'Successfully registered for the event.'
                : 'Registration cancelled successfully.');

        } catch (\Exception $e) {
            \Log::error('Registration error:', [
                'event_id' => $this->event->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'There was an error processing your registration.');
            $this->showConfirmationModal = false;
        }
    }

    public function editFeedback()
    {
        $userFeedback = $this->event->feedbacks()
            ->where('user_id', Auth::id())
            ->first();

        if ($userFeedback) {
            $this->rating = $userFeedback->rating;
            $this->comment = $userFeedback->comment;
            $this->showFeedbackForm = true;
        }
    }

    public function cancelFeedback()
    {
        $this->reset(['rating', 'comment', 'showFeedbackForm']);

        // If editing, restore original values
        if ($this->userFeedbackExists) {
            $this->loadEventData();
        }
    }

    public function saveFeedback()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
        ]);

        $this->event->feedbacks()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]
        );

        $this->showFeedbackForm = false;
        $this->userFeedbackExists = true;

        // Refresh the feedback data
        $this->loadEventData();

        $this->dispatch('notify', [
            'message' => $this->userFeedbackExists ? 'Review updated successfully!' : 'Review submitted successfully!',
            'type' => 'success'
        ]);
    }

    public function toggleFeedbackForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->showFeedbackForm) {
            $this->cancelFeedback();
        }

        $this->showFeedbackForm = !$this->showFeedbackForm;
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Please select a rating.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot be more than 5 stars.',
            'comment.max' => 'Comment cannot be longer than 1000 characters.',
        ];
    }

    public function render()
    {
        return view('livewire.pages.event-details-page', [
            'event' => $this->event,
            'eventData' => $this->eventData,
            'isRegistered' => $this->isRegistered,
            'userFeedbackExists' => $this->userFeedbackExists,
            'recentFeedbacks' => $this->recentFeedbacks,
            'averageRating' => $this->averageRating,
            'feedbackCount' => $this->feedbackCount,
        ]);
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }
}
