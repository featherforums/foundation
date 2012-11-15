<?php namespace Feather;

use Illuminate\Container;
use Illuminate\Foundation\Application;

class Feather extends Container {

	/**
	 * Laravel application instance.
	 * 
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Create a new feather application instance.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Load configuration from the database.
	 * 
	 * @return void
	 */
	public function registerDatabaseConfig()
	{
		if ($this->app['cache']->has('config'))
		{
			$this->app['cache']->forget('config');
		}

		foreach (Models\Config::everything() as $item)
		{
			$this->app['config']["feather.{$item->name}"] = $item->value;
		}
	}

	/**
	 * Reload the configuration from the database.
	 * 
	 * @return void
	 */
	public function reloadDatabaseConfig()
	{
		$this->app['cache']->forget('config');

		$this->app['config']['feather'] = null;

		$this->registerDatabaseConfig();
	}

	/**
	 * Parse an array of routes.
	 * 
	 * @param  array  $routes
	 * @return void
	 */
	public function parseRoutes($routes)
	{
		if ( ! is_array($routes)) $routes = array($routes);

		// Feather can be configured to handle a given URI. By default Feather will handle all
		// requests to the root directory.
		$handles = $this->app['config']['feather.handles'];

		// Spin through each of the routes and replace the placeholder with Feather's handler.
		foreach ($routes as $route => $action)
		{
			list($verb, $uri) = explode(' ', $route);

			$uri = ltrim(str_replace('(:feather)', $handles, $uri), '/');

			switch ($verb)
			{
				case 'resource':
					if ( ! is_array($action))
					{
						$action = array(
							'controller' => $action,
							'options' => array()
						);
					}

					$this->app['router']->resource($uri, $action['controller'], $action['options']);
					break;
				default:
					$this->app['router']->$verb($uri ?: '/', $action);
					break;
			}
		}
	}

}