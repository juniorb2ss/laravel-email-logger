<?php namespace juniorb2ss\LaravelEmailLogger\Events;

use juniorb2ss\LaravelEmailLogger\Services\MessageParser;

class EmailLoggerWritten {
	/**
	 * The key that was hit.
	 *
	 * @var string
	 */
	public $message;

	/**
	 * [__construct description]
	 * @param [type] $message [description]
	 */
	public function __construct(MessageParser $message) {
		$this->message = $message;
	}
}
