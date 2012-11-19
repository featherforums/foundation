<?php namespace Feather;

/*
|--------------------------------------------------------------------------
| Path to Feather
|--------------------------------------------------------------------------
|
| Define some of the paths used by Feather.
|
*/

$app['feather']['path'] = __DIR__;

$app['feather']['path.extensions'] = __DIR__.'/Feather/Extensions';

$app['feather']['path.themes'] = __DIR__.'/Feather/Themes';

/*
|--------------------------------------------------------------------------
| Feather Configuration
|--------------------------------------------------------------------------
|
| Register the Feather database connection and the configuration.
|
*/

define('FEATHER_DATABASE', 'feather');

$app['config']['database.connections.'.FEATHER_DATABASE] = $app['config']['feather.database'];

$app['feather']->registerDatabaseConfig();

/*
|--------------------------------------------------------------------------
| Feather Components
|--------------------------------------------------------------------------
|
| Load in Feather's components.
|
*/

foreach ($app['config']['feather.providers'] as $provider)
{
	$app->register(new $provider);
}

/*
|--------------------------------------------------------------------------
| Feather Facades
|--------------------------------------------------------------------------
|
| Load in the facades used by Feather's components.
|
*/

require $app['feather']['path'] . '/facades.php';

/*
|--------------------------------------------------------------------------
| Feather Theme
|--------------------------------------------------------------------------
|
| Prepare the theme to be used by Feather and register some view paths.
|
*/

$app['feather']['view']->prepare(array(
	'path'		  => $app['feather']['path'],
	'path.themes' => $app['feather']['path.themes'])
);

/*
|--------------------------------------------------------------------------
| Feather Extensions
|--------------------------------------------------------------------------
|
| Register the enabled extensions with Feather.
|
*/

$app['feather']['extensions']->registerExtensions(Models\Extension::enabled());