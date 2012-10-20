<?php namespace Feather\Models;

use Cache;

class Config extends Base {

	/**
	 * Name of table.
	 * 
	 * @var string
	 */
	public $table = 'config';

	/**
	 * Timestamps are disabled.
	 * 
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Load all config items.
	 * 
	 * @return array
	 */
	public static function everything()
	{
		return Cache::rememberForever('config', function()
		{
			return Config::all();
		});
	}

}