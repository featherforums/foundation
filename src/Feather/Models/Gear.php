<?php namespace Feather\Models;

class Gear extends Base {

	/**
	 * Name of table.
	 * 
	 * @var string
	 */
	public $table = 'gears';

	/**
	 * Timestamps are disabled.
	 * 
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Return all gears that have been enabled.
	 * 
	 * @return  array
	 */
	public static function enabled()
	{
		return static::where('enabled', '=', 1)->get();
	}

}