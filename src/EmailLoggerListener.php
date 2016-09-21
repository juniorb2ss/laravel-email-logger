<?php namespace Juniorb2ss\LaravelEmailLogger;

use Illuminate\Mail\Events\MessageSending;

class EmailLoggerListener {
	/**
	 * Handle the event.
	 *
	 * @param MessageSending $event
	 */
	public function handle(MessageSending $event) {
		$message = $event->message;
	}

	/**
	 * Get a loggable string out of a Swiftmailer entity.
	 *
	 * @param  \Swift_Mime_MimeEntity $entity
	 * @return string
	 */
	protected function getMimeEntityString(\Swift_Mime_MimeEntity $entity) {
		$string = (string) $entity->getHeaders() . PHP_EOL . $entity->getBody();
		foreach ($entity->getChildren() as $children) {
			$string .= PHP_EOL . PHP_EOL . $this->getMimeEntityString($children);
		}
		return $string;
	}
}