<?php namespace Feather\Models;

use Cache;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Builder extends EloquentBuilder {

	/**
	 * Find a model by its primary key.
	 *
	 * @param  mixed  $id
	 * @param  array  $columns
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function find($id, $columns = array('*'))
	{
		$key = explode('\\', get_class($this->model));

		// If the item is cachable then we'll check to see if a cached version exists.
		if (isset(Base::$cachable[$key = strtolower(array_pop($key))]))
		{
			list($group, $foreign) = Base::$cachable[$key];

			if (Cache::has("{$group}_{$id}"))
			{
				return Cache::get("{$group}_{$id}");
			}
		}

		$this->query->where($this->model->getKeyName(), '=', $id);

		return $this->first($columns);
	}

}