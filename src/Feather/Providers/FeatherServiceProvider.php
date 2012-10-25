<?php namespace Feather\Providers;

use Feather\Feather;
use RuntimeException;
use Illuminate\Filesystem;
use Feather\Console\PublishCommand;
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
		$app['feather'] = $app->share(function() use ($app)
		{
			return new Feather($app);
		});
		
		$this->registerCommands($app);

		// Bootstrap a lot of the Feather components by requiring the Feather start script.
		require __DIR__ . '/../../start.php';

		$this->registerRoutes($app, __DIR__ . '/../../routes.php');
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
	 * @param  Illuminate\Foundation\Application  $app
	 * @param  string                             $path
	 * @return void
	 */
	public function registerRoutes($app, $path)
	{
		// Feather can be configured to handle a given URI. By default Feather will handle all
		// requests to the root directory.
		$handles = $app['config']['feather.handles'];

		// Spin through each of the routes and replace the placeholder with Feather's handler.
		foreach ($this->getRoutes($app['files'], $path) as $route => $action)
		{
			list($verb, $uri) = explode(' ', $route);

			$uri = ltrim(str_replace('(:feather)', $handles, $uri), '/');

			switch ($verb)
			{
				case 'resource':
					$app['router']->resource($uri, $action['controller'], $action['options']);
					break;
				default:
					$app['router']->$verb($uri ?: '/', $action);
					break;
			}
		}
	}

	/**
	 * Register the command line commands.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function registerCommands($app)
	{
		$app['command.feather.publish'] = $app->share(function() use ($app)
		{
			return new PublishCommand($app['files']);
		});
	}

}