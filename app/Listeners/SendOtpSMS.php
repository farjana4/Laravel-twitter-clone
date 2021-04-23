<?php

namespace App\Listeners;

use App\Notifications\SendOtpSMSNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOtpSMS implements ShouldQueue
{
    public function handle($event)
    {
        Notification::route('nexmo', $event->phoneNumber)->notify(new SendOtpSMSNotification($event->otp));
    }
}
