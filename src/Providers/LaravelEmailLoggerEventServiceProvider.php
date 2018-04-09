<?php

namespace juniorb2ss\LaravelEmailLogger\Providers;

use Illuminate\Mail\Events\MessageSent;
use juniorb2ss\LaravelEmailLogger\Listeners\EmailLoggerListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class LaravelEmailLoggerEventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MessageSent::class => [
            EmailLoggerListener::class,
        ],
    ];
}
