<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends BaseVerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * @param string $url
     * @return MailMessage
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Hello, Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $url)
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }
}
