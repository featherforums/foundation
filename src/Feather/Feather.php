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

}