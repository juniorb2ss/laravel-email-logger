<?php namespace juniorb2ss\LaravelEmailLogger\Services;

use InvalidArgumentException;
use juniorb2ss\LaravelEmailLogger\Contracts\Factory as FactoryContract;

/**
 *
 */
class EmailLoggerManager implements FactoryContract {
	/**
	 * Create a new manager instance.
	 *
	 * @param  \Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function __construct($app) {
		$this->app = $app;
	}

	/**
	 * Get a driver instance.
	 *
	 * @param  string  $driver
	 * @return mixed
	 */
	public function connection($driver = null) {
		return $this->driver($driver);
	}

	/**
	 * Get a driver instance.
	 *
	 * @param  string  $name
	 * @return mixed
	 */
	public function driver($name = null) {
		$name = $name ?: $this->getDefaultDriver();

		return $this->drivers[$name] = $this->get($name);
	}

	/**
	 * Attempt to get the connection from the local cache.
	 *
	 * @param  string  $name
	 * @return \Illuminate\Contracts\emaillogger\Broadcaster
	 */
	protected function get($name) {
		return isset($this->drivers[$name]) ? $this->drivers[$name] : $this->resolve($name);
	}

	/**
	 * Resolve the given store.
	 *
	 * @param  string  $name
	 * @return \Illuminate\Contracts\emaillogger\Broadcaster
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function resolve($name) {
		$config = $this->getConfig($name);

		if (is_null($config)) {
			throw new InvalidArgumentException("EmailLogger Service [{$name}] is not defined.");
		}

		if (isset($this->customCreators[$config['driver']])) {
			return $this->callCustomCreator($config);
		} else {
			$driverMethod = 'create' . ucfirst($config['driver']) . 'Driver';

			if (method_exists($this, $driverMethod)) {
				return $this->{$driverMethod}($config);
			} else {
				throw new InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
			}
		}
	}

	/**
	 * Call a custom driver creator.
	 *
	 * @param  array  $config
	 * @return mixed
	 */
	protected function callCustomCreator(array $config) {
		return $this->customCreators[$config['driver']]($this->app, $config);
	}

	/**
	 * Create an instance of the driver.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Contracts\emaillogger\Broadcaster
	 */
	protected function createRedisDriver(array $config) {
		return new RedisBroadcaster(
			$this->app->make('redis'), Arr::get($config, 'connection')
		);
	}

	/**
	 * Create an instance of the driver.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Contracts\emaillogger\Broadcaster
	 */
	protected function createEloquentDriver(array $config) {
		return new EloquentService;
	}

	/**
	 * Get the connection configuration.
	 *
	 * @param  string  $name
	 * @return array
	 */
	protected function getConfig($name) {
		return $this->app['config']["emaillogger.connections.{$name}"];
	}

	/**
	 * Get the default driver name.
	 *
	 * @return string
	 */
	public function getDefaultDriver() {
		return $this->app['config']['emaillogger.default'];
	}

	/**
	 * Set the default driver name.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function setDefaultDriver($name) {
		$this->app['config']['emaillogger.default'] = $name;
	}

	/**
	 * Register a custom driver creator Closure.
	 *
	 * @param  string    $driver
	 * @param  \Closure  $callback
	 * @return $this
	 */
	public function extend($driver, Closure $callback) {
		$this->customCreators[$driver] = $callback;

		return $this;
	}

	/**
	 * Dynamically call the default driver instance.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters) {
		return call_user_func_array([$this->driver(), $method], $parameters);
	}
}