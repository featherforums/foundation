<?php namespace Feather\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Base extends Eloquent {

	/**
	 * The default connection used by Feather.
	 * 
	 * @var string
	 */
	public $connection = FEATHER_DATABASE;

	/**
	 * Cache time in minutes.
	 * 
	 * @var int
	 */
	const cache_time = 720;

	/**
	 * Array of cachable items and the appropriate foreign keys.
	 * 
	 * @var array
	 */
	public static $cachable = array(
		'place'  => array('place', 'place_id'),
		'user'   => array('user', 'user_id'),
		'author' => array('user', 'user_id')
	);

	/**
	 * Get a new query builder for the model's table.
	 *
	 * @return Feather\Models\Builder
	 */
	public function newQuery()
	{
		$builder = new Builder($this->newBaseQueryBuilder());

		// Once we have the query builders, we will set the model instances so the
		// builder can easily access any information it may need from the model
		// while it is constructing and executing various queries against it.
		$builder->setModel($this);

		return $builder;
	}

	/**
	 * Handle the dynamic retrieval of attributes and associations.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if (isset(static::$cachable[$key]) and ! isset($this->attributes[$key]) and ! isset($this->relations[$key]))
		{
			list($group, $foreign) = static::$cachable[$key];

			if (Cache::has("{$group}_{$this->$foreign}"))
			{
				return Cache::get("{$group}_{$this->$foreign}");
			}
		}

		return parent::__get($key);
	}

}