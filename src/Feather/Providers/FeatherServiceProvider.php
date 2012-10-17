<?php namespace Feather\Providers;

use Feather\Application;
use Illuminate\Support\ServiceProvider;

class FeatherServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function register($app)
	{
		$app['feather'] = $app->share(function()
		{
			return new Application;
		});

		// Bootstrap a lot of the Feather components by requiring the Feather start script.
		require __DIR__ . '/../../start.php';

		$this->loadRoutes($app);
	}

	/**
	 * Load Feather's routes.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	protected function loadRoutes($app)
	{
		// Feather can be configured to handle a given URI. By default Feather will handle all
		// requests to the root directory.
		$handles = $app['config']->get('feather.handles');

		// Spin through each of the routes and replace the placeholder with Feather's handler.
		foreach(require __DIR__ . '/../../routes.php' as $route => $action)
		{
			list($verb, $uri) = explode(' ', $route);

			$app['router']->$verb(ltrim(str_replace('(:feather)', $handles, $uri), '/'), $action);
		}
	}

}