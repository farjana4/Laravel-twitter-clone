<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class SendOtpSMSNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $otp;

    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable): array
    {
        return ['nexmo'];
    }

    public function toNexmo($notifiable): NexmoMessage
    {
        return (new NexmoMessage())
            ->content(sprintf('Your %s login OTP is %s', config('app.name'), $this->otp));
    }
}
