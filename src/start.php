<?php namespace Feather;

/*
|--------------------------------------------------------------------------
| Path to Feather
|--------------------------------------------------------------------------
|
| Define some important parts to Feather.
|
*/

$app['feather']['path'] = __DIR__ . '/';

/*
|--------------------------------------------------------------------------
| Feather Configuration
|--------------------------------------------------------------------------
|
| Load in some important configuration items for Feather.
|
*/

define('FEATHER_DATABASE', 'feather');

$app['config']->set('database.connections.' . FEATHER_DATABASE, $app['config']->get('feather.database'));

$app['feather']->loadConfig();

/*
|--------------------------------------------------------------------------
| Feather Components
|--------------------------------------------------------------------------
|
| Load in Feather's components.
|
*/

foreach($app['config']->get('feather.providers') as $provider)
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

$paths = array($app['feather']['theme']->getPath(), $app['feather']['path'] . 'Feather/Views');

$app['view']->addNamespace('feather', $paths);

$app['feather']['theme']->prepTheme();