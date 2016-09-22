<?php namespace juniorb2ss\LaravelEmailLogger\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\ServiceProvider;
use juniorb2ss\LaravelEmailLogger\Listeners\EmailLoggerListener;
use juniorb2ss\LaravelEmailLogger\Services\EmailLoggerManager;

class LaravelEmailLoggerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

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
	 * Register the application's event listeners.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events) {
		foreach ($this->listens() as $event => $listeners) {
			foreach ($listeners as $listener) {
				$events->listen($event, $listener);
			}
		}

		// Publish config file
		$this->publishes([
			__DIR__ . '/../Config/emaillogger.php' => config_path('emaillogger.php'),
		], 'config');

		// Publish migrations
		$this->publishes([
			__DIR__ . '/../Database/Migrations/' => database_path('migrations'),
		], 'migrations');
	}

	/**
	 * {@inheritdoc}
	 */
	public function register() {
		$this->app->singleton('jemaillogger', function ($app) {
			return new EmailLoggerManager($app);
		});

		// Register alias
		$loader = AliasLoader::getInstance();
		$loader->alias('jEmailLogger', EmailLoggerFacade::class);
	}

	/**
	 * Get the events and handlers.
	 *
	 * @return array
	 */
	public function listens() {
		return $this->listen;
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return [
			'emaillogger',
		];
	}
}