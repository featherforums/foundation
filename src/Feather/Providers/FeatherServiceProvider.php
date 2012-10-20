<?php namespace Feather\Providers;

use RuntimeException;
use Feather\Application;
use Illuminate\Filesystem;
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
		$app['feather'] = $app->share(function($app)
		{
			return new Application($app);
		});

		// Bootstrap a lot of the Feather components by requiring the Feather start script.
		require __DIR__ . '/../../start.php';

		$this->registerRoutes(__DIR__ . '/../../routes.php', $app['config'], $app['files'], $app['router']);
	}

	/**
	 * Gets the routes from the stored routes array.
	 * 
	 * @param  Illuminate\Filesystem  $files
	 * @param  string                 $path
	 * @return array
	 * @throws RuntimeException
	 */
	public function getRoutes($files, $path)
	{
		if ( ! $files->exists($path))
		{
			throw new RuntimeException('Could not locate Feather routes file.');
		}

		return require $path;
	}

	/**
	 * Registers the routes with the router.
	 * 
	 * @param  string                        $path
	 * @param  Illuminate\Config\Repository  $config
	 * @param  Illuminate\Filesystem         $files
	 * @param  Illuminate\Routing\Router     $router
	 * @return void
	 */
	public function registerRoutes($path, $config, $files, $router)
	{
		// Feather can be configured to handle a given URI. By default Feather will handle all
		// requests to the root directory.
		$handles = $config['feather.handles'];

		// Spin through each of the routes and replace the placeholder with Feather's handler.
		foreach ($this->getRoutes($files, $path) as $route => $action)
		{
			list($verb, $uri) = explode(' ', $route);

			$uri = ltrim(str_replace('(:feather)', $handles, $uri), '/');

			switch ($verb)
			{
				case 'resource':
					$router->resource($uri, $action['controller'], $action['options']);
					break;
				default:
					$router->$verb($uri ?: '/', $action);
					break;
			}
		}
	}

}