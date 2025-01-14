<?php

namespace App\Notifications;

use Illuminate\Notifications\Notifiable;

class PendingUserNotifiable
{
    use Notifiable;

    private $tempId;
    private $email;

    public function __construct($tempId, $email)
    {
        $this->tempId = $tempId;
        $this->email = $email;
    }

    public function getKey()
    {
        return $this->tempId;
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}