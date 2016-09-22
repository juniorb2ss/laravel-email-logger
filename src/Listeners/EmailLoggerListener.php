<?php namespace juniorb2ss\LaravelEmailLogger\Listeners;

use Illuminate\Mail\Events\MessageSending;
use jEmailLogger;
use juniorb2ss\LaravelEmailLogger\Events\EmailLoggerHit;
use juniorb2ss\LaravelEmailLogger\Services\MessageParser;

class EmailLoggerListener {
	/**
	 * Handle the event.
	 *
	 * @param MessageSending $event
	 */
	public function handle(MessageSending $event) {
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