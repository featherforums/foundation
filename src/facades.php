<?php namespace Feather;

use Illuminate\Support\Facade;

class Auth extends Facade {

	/**
	 * Get the registered component.
	 *
	 * @return object
	 */
	protected static function getFacadeAccessor(){ return static::$app['feather']['auth']; }

}

class Theme extends Facade {

	/**
	 * Get the registered component.
	 *
	 * @return object
	 */
	protected static function getFacadeAccessor(){ return static::$app['feather']['theme']; }

}