<?php namespace Feather;

use DB;
use Cache;
use Config;
use Illuminate\Container;

class Application extends Container {

	/**
	 * Load configuration from the database.
	 * 
	 * @return void
	 */
	public function loadConfig()
	{
		Cache::forget('config');

		$items = Cache::rememberForever('config', function()
		{
			$config = array();

			foreach(DB::connection(FEATHER_DATABASE)->table('config')->get() as $item)
			{
				array_set($config, $item->key, $item->value);
			}

			return $config;
		});

		foreach($items as $key => $item)
		{
			Config::set("feather.{$key}", $item);
		}
	}

	/**
	 * Reload the configuration from the database.
	 * 
	 * @return void
	 */
	public function reloadConfig()
	{
		Cache::forget('config');

		Config::set('feather', null);

		$this->loadConfig();
	}

}