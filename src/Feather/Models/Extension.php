<?php namespace Feather\Models;

use Cache;

class Extension extends Base {

	/**
	 * Name of table.
	 * 
	 * @var string
	 */
	public $table = 'extensions';

	/**
	 * Timestamps are disabled.
	 * 
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Return all enabled extensions.
	 * 
	 * @return  array
	 */
	public static function enabled()
	{
		return Cache::rememberForever('extensions', function()
		{
			return Extension::where('enabled', '=', 1)->get();
		});
	}

}