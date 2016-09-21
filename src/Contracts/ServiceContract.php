<?php namespace juniorb2ss\EmailLogger\Contracts;

/**
 *
 */
interface ServiceContract {

	/**
     * The array of resolved broadcast drivers.
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app);

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function connection($driver = null);


	 /**
     * Get a driver instance.
     *
     * @param  string  $name
     * @return mixed
     */
    public function driver();

    /**
     * Attempt to get the connection from the local cache.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Broadcasting\Broadcaster
     */
    protected function get($name);
    
    /**
     * Create an instance of the driver.
     *
     * @param  array  $config
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createEloquentDriver(array $configs);

     /**
     * Get the connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name);

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver();

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters);
}