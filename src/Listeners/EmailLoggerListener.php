<?php

namespace juniorb2ss\LaravelEmailLogger\Listeners;

use jEmailLogger;
use Illuminate\Mail\Events\MessageSent;
use juniorb2ss\LaravelEmailLogger\Events\EmailLoggerHit;
use juniorb2ss\LaravelEmailLogger\Services\MessageParser;

class EmailLoggerListener
{
    /**
     * Handle the event.
     *
     * @param MessageSent $event
     */
    public function handle(MessageSent $event)
    {
        // Get email
        $message = $event->message;

        // Parser Message
        $messageParsed = new MessageParser($message);

        // Hit event
        event(new EmailLoggerHit($messageParsed));

        // Save log message
        jEmailLogger::put($messageParsed);
    }
}
