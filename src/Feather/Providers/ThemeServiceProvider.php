<?php namespace Feather\Providers;

use Feather\Managers\ThemeManager;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function register($app)
	{
		$app['feather']['theme'] = $app->share(function() use ($app)
		{
			return new ThemeManager($app);
		});
	}

}