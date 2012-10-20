<?php namespace Feather;

use Illuminate\Container;

class Application extends Container {

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
	public function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * Load configuration from the database.
	 * 
	 * @return void
	 */
	public function registerConfig()
	{
		$this->app['cache']->forget('config');

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
	public function reloadConfig()
	{
		$this->app['cache']->forget('config');

		$this->app['config']['feather'] = null;

		$this->registerConfig();
	}

}