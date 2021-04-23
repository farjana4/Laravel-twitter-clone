<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PhoneNumberUpdateRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $phoneNumber;
    public string $otp;

    public function __construct(string $phoneNumber, string $otp)
    {
        $this->phoneNumber = $phoneNumber;
        $this->otp = $otp;
    }
}
