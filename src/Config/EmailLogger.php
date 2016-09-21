<?php

return [

	'driver' => 'redis',

	'connections' => [
		//
		'redis' => [
			'host' => '',
			'port' => ''
		];

		//
		'database' => [
			'connection' => 'mysql', // Your app connection
			'database' => 'database', // Database to log
		];

		//
		'sns' => [
			'url' => '',
			'key' => '',
			'secret' => '',
		];
	];
];