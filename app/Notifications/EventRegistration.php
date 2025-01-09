<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventRegistration extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;
    protected $type;

    public function __construct(Event $event, string $type = 'registration')
    {
        $this->event = $event;
        $this->type = $type;
    }

    public function via(object $notifiable): array
    {
        \Log::info('Notification channels being used:', [
            'channels' => ['mail', 'database'],
            'notifiable_id' => $notifiable->id,
            'event_id' => $this->event->id,
            'type' => $this->type
        ]);

        // Make sure both channels are included in the serialized job
        $channels = ['mail', 'database'];
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        \Log::info('toMail method called', [
            'user' => $notifiable->email,
            'event' => $this->event->name,
            'route' => route('event.details', $this->event->id)
        ]);
        return (new MailMessage)
            ->subject($this->type === 'registration' ? 'Event Registration Confirmation' : 'Registration Cancelled')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->type === 'registration'
                ? 'You have successfully registered for ' . $this->event->name
                : 'Your registration for ' . $this->event->name . ' has been cancelled.')
            ->line('Event Details:')
            ->line('Date: ' . $this->event->start_date)
            ->line('Location: ' . $this->event->venue->name)
            ->action('View Event Details', route('event.details', $this->event->id))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable): array
    {
        \Log::info('toDatabase method called', [
            'user' => $notifiable->email,
            'event' => $this->event->name
        ]);
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->name,
            'type' => $this->type,
            'message' => $this->type === 'registration'
                ? 'You have registered for ' . $this->event->name
                : 'Your registration for ' . $this->event->name . ' has been cancelled'
        ];
    }
}
