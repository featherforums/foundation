<?php

/*
|--------------------------------------------------------------------------
| Default Feather Configuration
|--------------------------------------------------------------------------
|
| This is the main configuration file for Feather. Generally the only
| items you will need to configure is the database connection.
|
*/

return array(

	/*
	|--------------------------------------------------------------------------
	| Feather Handles
	|--------------------------------------------------------------------------
	|
	| This is the URI that Feather will respond to. By default Feather responds
	| to root requests but if installing alongside an existing Laravel
	| application you may want to change this to 'forum'.
	|
	*/

	'handles' => '/',

	/*
	|--------------------------------------------------------------------------
	| Database Connection
	|--------------------------------------------------------------------------
	|
	| Your database connection information.
	|
	*/

	'database' => array(
		'host'	   => 'localhost',
		'database' => 'feather',
		'username' => 'root',
		'password' => '',
		'prefix'   => '',
		'charset'  => 'utf8',
		'driver'   => 'mysql'
	),

	/*
	|--------------------------------------------------------------------------
	| Feather Providers
	|--------------------------------------------------------------------------
	|
	| These are the service providers used by some of the Feather components.
	| You shouldn't need to change anything down there.
	|
	*/

	'providers' => array(
		'Feather\Providers\AuthServiceProvider',
		'Feather\Providers\ExtensionServiceProvider',
		'Feather\Providers\ViewServiceProvider',
	)
);