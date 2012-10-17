<?php namespace Feather\Providers;

use Feather\Auth\Shield;
use Feather\Auth\FeatherUserProvider;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 * 
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function register($app)
	{
		$app['feather']['auth'] = $app->share(function() use ($app)
		{
			return new Shield(new FeatherUserProvider($app['db']->connection(FEATHER_DATABASE), $app['hash']), $app['session']);
		});
	}

}