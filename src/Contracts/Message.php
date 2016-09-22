<?php namespace juniorb2ss\LaravelEmailLogger\Contracts;

use Swift_Message;

/**
 *
 */
interface Message {
	public function __construct(Swift_Message $message);
	public function getFrom();
	public function getSender();
	public function getTo();
	public function getBcc();
	public function getCc();
	public function getReplyTo();
	public function getSubject();
	public function getPriority();
	public function getMessageId();
	public function getDate();
	public function getStringBody();
}
