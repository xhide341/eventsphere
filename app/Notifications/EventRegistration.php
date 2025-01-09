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

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->type === 'registration' ? 'Event Registration Confirmation' : 'Registration Cancelled')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->type === 'registration'
                ? 'You have successfully registered for ' . $this->event->title
                : 'Your registration for ' . $this->event->title . ' has been cancelled.')
            ->line('Event Details:')
            ->line('Date: ' . $this->event->start_date)
            ->line('Location: ' . $this->event->location)
            ->action('View Event Details', route('events.show', $this->event->id))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'type' => $this->type,
            'message' => $this->type === 'registration'
                ? 'You have registered for this event'
                : 'Your registration has been cancelled'
        ];
    }
}
