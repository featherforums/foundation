<?php namespace Feather\Managers;

use Illuminate\Support\Manager;

class ThemeManager extends Manager {

	/**
	 * Get the path to the themes view directory.
	 * 
	 * @return string
	 */
	public function getPath()
	{
		return $this->app['feather']['path'] . 'Themes/' . ucfirst($this->app['config']->get('feather.forum.theme')) . '/Views';
	}

}