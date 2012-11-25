<?php namespace Feather\Foundation;

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
			return new Feather($app);
		});

		$app['feather']['path'] = __DIR__.'/../../../../app/src/Feather';

		$this->registerCommands($app);

		// Bootstrap a lot of the Feather components by requiring the Feather start script.
		require $app['feather']['path'].'/start.php';
	}

	/**
	 * Register the console commands.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	protected function registerCommands($app)
	{
		$app['command.feather'] = $app->share(function($app)
		{
			return new Console\FeatherCommand;
		});

		$app['command.feather.publish'] = $app->share(function($app)
		{
			return new Console\PublishCommand($app['asset.publisher'], $app['feather']['path.themes'], $app['feather']['path.extensions']);
		});

		$app['events']->listen('artisan.start', function($artisan)
		{
			$artisan->resolveCommands(array(
				'command.feather',
				'command.feather.publish'
			));
		});
	}

}