<?php namespace juniorb2ss\LaravelEmailLogger\Services;

use Carbon\Carbon;
use juniorb2ss\LaravelEmailLogger\Contracts\Message;
use Swift_Message;

/**
 *
 */
class MessageParser implements Message {
	/**
	 * Message instance
	 * @var Swift_Message $message
	 */
	protected $message;

	/**
	 * From Address
	 * @var string
	 */
	protected $from = '';

	/**
	 * To Address
	 * @var string
	 */
	protected $to = '';

	/**
	 * Bcc Address
	 * @var string
	 */
	protected $bcc = '';

	/**
	 * Cc Address
	 * @var string
	 */
	protected $cc = '';

	/**
	 * Priority
	 * @var string
	 */
	protected $priority = '';

	/**
	 * Message-Id
	 * @var string
	 */
	protected $messageId = '';

	/**
	 * Sender Address
	 * @var string
	 */
	protected $sender = '';

	/**
	 * Reply-To Address
	 * @var string
	 */
	protected $replyTo = '';

	/**
	 * Subject
	 * @var string
	 */
	protected $subject = '';

	/**
	 * Body
	 * @var string
	 */
	protected $body = '';

	/**
	 * Date
	 * @var \Carbon\Carbon $date
	 */
	protected $date;

	/**
	 * [__construct description]
	 * @param [type] $message [description]
	 */
	public function __construct(Swift_Message $message) {
		$this->message = $message;
	}

	/**
	 * Get From Address
	 * @return string
	 */
	public function getFrom() {
		$this->from = $this->getPropertyFieldBody('From');

		return $this->from;
	}

	/**
	 * @param  string  $property
	 * @return boolean
	 */
	protected function hasProperty($property) {
		$property = $this->message->getHeaders()->get($property);

		return (isset($property) && !empty($property));
	}

	/**
	 * Return property in email if exists.
	 *
	 * @param  string $property
	 * @return string
	 */
	protected function getPropertyFieldBody($property) {
		return (
			$this->hasProperty($property) ? $this->message->getHeaders()->get($property)->getFieldBody() : null
		);
	}

	/**
	 * Get Sender Address
	 * @return string
	 */
	public function getSender() {
		$this->sender = $this->getPropertyFieldBody('Sender');

		return $this->sender;
	}

	/**
	 * Get To Address
	 * @return string
	 */
	public function getTo() {
		$this->to = $this->getPropertyFieldBody('To');

		return $this->to;
	}

	/**
	 * Get Bcc Address
	 * @return string
	 */
	public function getBcc() {
		$this->bcc = $this->getPropertyFieldBody('Bcc');

		return $this->bcc;
	}

	/**
	 * Get Cc Address
	 * @return string
	 */
	public function getCc() {
		$this->cc = $this->getPropertyFieldBody('Cc');

		return $this->cc;
	}

	/**
	 * Get Reply-To Address
	 * @return string
	 */
	public function getReplyTo() {
		$this->replyTo = $this->getPropertyFieldBody('Reply-To');

		return $this->replyTo;
	}

	/**
	 * Get Email Subject
	 * @return string
	 */
	public function getSubject() {
		$this->subject = $this->getPropertyFieldBody('Subject');

		return $this->subject;
	}

	/**
	 * Get Email Priority
	 * @return string
	 */
	public function getPriority() {
		$this->priority = $this->getPropertyFieldBody('X-Priority');

		return $this->priority;
	}

	/**
	 * Get Email String Body
	 * @return string
	 */
	public function getStringBody() {
		$this->body = $this->getMimeEntityString();

		return $this->body;
	}

	/**
	 * Get Message ID
	 * @return string
	 */
	public function getMessageId() {
		$this->messageId = $this->getPropertyFieldBody('Message-Id');

		return $this->messageId;
	}

	/**
	 * Get date
	 * @return \Carbon\Carbon $date
	 */
	public function getDate() {
		$this->date = Carbon::parse($this->getPropertyFieldBody('Date'));

		return $this->date;
	}

	/**
	 * Get a loggable string out of a Swiftmailer entity.
	 * @author Alexander Shvets @neochief
	 *
	 * @return string
	 */
	protected function getMimeEntityString() {
		$string = (string) $this->message->getHeaders() . PHP_EOL . $this->message->getBody();
		foreach ($this->message->getChildren() as $children) {
			$string .= PHP_EOL . PHP_EOL . $this->getMimeEntityString($children);
		}
		return $string;
	}
}