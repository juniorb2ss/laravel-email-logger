<?php namespace juniorb2ss\LaravelEmailLogger\Services;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use juniorb2ss\LaravelEmailLogger\Contracts\Store;
use juniorb2ss\LaravelEmailLogger\Events\EmailLoggerWritten;
use juniorb2ss\LaravelEmailLogger\Services\MessageParser;

/**
 *
 */
class EloquentService extends EloquentModel implements Store
{
    protected $table = 'email_log';

    /**
     * Save log email to database
     * @param  juniorb2ss\LaravelEmailLogger\Services\MessageParser $message
     * @return void
     */
    public function put(MessageParser $message)
    {
        $this->to = $message->getTo();
        $this->bcc = $message->getBcc();
        $this->cc = $message->getCc();
        $this->replyTo = $message->getReplyTo();
        $this->priority = $message->getPriority();
        $this->messageId = $message->getMessageId();
        $this->sender = $message->getSender();
        $this->subject = $message->getSubject();
        $this->body = $message->getStringBody();
        $this->date = $message->getDate();

        // set connection for model
        $connection = config('emaillogger.connections.eloquent.connection');

        $this->setConnection($connection)
             ->save(); // Save

        // Hit event
        event(new EmailLoggerWritten($message));
    }
}
