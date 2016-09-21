<?php namespace juniorb2ss\LaravelEmailLogger\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\ServiceProvider;
use juniorb2ss\EmailLogger\Services\ServiceManager;
use juniorb2ss\LaravelEmailLogger\EmailLoggerListener;

class LaravelEmailLoggerServiceProvider extends ServiceProvider {
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
	 * The subscriber classes to register.
	 *
	 * @var array
	 */
	protected $subscribe = [];

	/**
	 * Register the application's event listeners.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events) {
		parent::boot($events);

		foreach ($this->listens() as $event => $listeners) {
			foreach ($listeners as $listener) {
				$events->listen($event, $listener);
			}
		}

		foreach ($this->subscribe as $subscriber) {
			$events->subscribe($subscriber);
		}

		$this->publishes([
			__DIR__ . '/../../database/migrations/' => database_path('migrations'),
		], 'migrations');
	}

	/**
	 * {@inheritdoc}
	 */
	public function register() {
		$this->app->singleton('juniorb2ss\EmailLogger\Services\ServiceManager', function ($app) {
			return new ServiceManager($app);
		});
	}

	/**
	 * Get the events and handlers.
	 *
	 * @return array
	 */
	public function listens() {
		return $this->listen;
	}
}