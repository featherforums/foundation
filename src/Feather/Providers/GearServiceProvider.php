<?php namespace Feather\Providers;

use Feather\Gear\Dispatcher;
use Illuminate\Support\ServiceProvider;

class GearServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function register($app)
	{
		$app['feather']['gear'] = $app->share(function() use ($app)
		{
			return new Dispatcher;
		});

		$app['feather']['gear']->registerGears();
	}

}