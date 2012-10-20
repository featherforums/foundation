<?php namespace Feather;

use DB;

/*
|--------------------------------------------------------------------------
| Path to Feather
|--------------------------------------------------------------------------
|
| Define the path to Feather.
|
*/

$app['feather']['path'] = __DIR__ . '/';

/*
|--------------------------------------------------------------------------
| Feather Configuration
|--------------------------------------------------------------------------
|
| Register the Feather database connection and the configuration.
|
*/

define('FEATHER_DATABASE', 'feather');

$app['config']['database.connections.' . FEATHER_DATABASE] = $app['config']['feather.database'];

Models\Base::addConnection(FEATHER_DATABASE, DB::connection('feather'));

$app['feather']->registerConfig();

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

require $app['feather']['path'] . 'facades.php';

/*
|--------------------------------------------------------------------------
| Feather Theme
|--------------------------------------------------------------------------
|
| Prepare the theme to be used by Feather and register some view paths.
|
*/

$app['feather']['theme']->prepareTheme();