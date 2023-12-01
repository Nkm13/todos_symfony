<?php

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class SendEmailEvent extends Event
{
    const SEND_EMAIL = "send.email";

    public function sendEmail()
    {
    }
}
