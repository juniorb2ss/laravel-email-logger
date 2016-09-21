<?php
namespace juniorb2ss\LaravelEmailLogger\Providers;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Juniorb2ss\LaravelEmailLogger\EmailLoggerListener;

class LaravelEmailLoggerServiceProvider extends EventServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		MessageSending::class => [
			EmailLoggerListener::class,
		],
	];
	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events) {
		parent::boot($events);
		$this->publishes([
			__DIR__ . '/../../database/migrations/' => database_path('migrations'),
		], 'migrations');
	}
}