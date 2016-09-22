<?php

abstract class TestCase extends Orchestra\Testbench\TestCase {

	/**
	 * [getPackageProviders description]
	 * @param  [type] $app [description]
	 * @return [type]      [description]
	 */
	protected function getPackageProviders($app) {
		return ['juniorb2ss\LaravelEmailLogger\Providers\LaravelEmailLoggerServiceProvider'];
	}

	/**
	 * Setup the test environment.
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * Define environment setup.
	 *
	 * @param  \Illuminate\Foundation\Application  $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app) {
		// Setup default database to use sqlite :memory:
		$app['config']->set('database.default', 'testbench');
		$app['config']->set('mail.driver', 'log');
		$app['config']->set('database.connections.testbench', [
			'driver' => 'sqlite',
			'database' => ':memory:',
			'prefix' => '',
		]);

		$app['config']->set('emaillogger.default', 'eloquent');
		$app['config']->set('emaillogger.connections.testbench', [
			'eloquent' => [
				'driver' => 'eloquent',
			],
		]);
	}
}