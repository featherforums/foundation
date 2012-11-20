<?php namespace Feather\Foundation\Providers;

use Illuminate\Filesystem;
use Feather\Foundation\Feather;
use Feather\Foundation\Console\FeatherCommand;
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
			return new Feather($app);
		});

		$app['feather']['path'] = __DIR__.'/../../../../../app/src/Feather';

		// Bootstrap a lot of the Feather components by requiring the Feather start script.
		require $app['feather']['path'].'/start.php';

		$this->registerCommands($app);
	}

	/**
	 * Register the console commands.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	protected function registerCommands($app)
	{
		$app['commands.feather'] = $app->share(function($app)
		{
			return new FeatherCommand;
		});

		$app['events']->listen('artisan.start', function($artisan)
		{
			$artisan->resolve('commands.feather');
		});
	}

}