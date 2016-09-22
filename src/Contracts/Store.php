<?php namespace juniorb2ss\LaravelEmailLogger\Contracts;

use juniorb2ss\LaravelEmailLogger\Services\MessageParser;

interface Store {
	/**
	 * Store an email in the logger.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function put(MessageParser $message);
}
