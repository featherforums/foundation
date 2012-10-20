<?php namespace Feather\Managers;

use Feather\Sword;
use Illuminate\View;
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

	/**
	 * Prepare the theme by requiring a starter file if it exists.
	 * 
	 * @return void
	 */
	public function prepareTheme()
	{
		$this->app['view']->extend('knife', function($app)
		{
			// The Compiler engine requires an instance of the CompilerInterface, which in
			// this case will be the Blade compiler, so we'll first create the compiler
			// instance to pass into the engine so it can compile the views properly.
			$compiler = new Sword($app['files'], $app['config']['view.cache']);

			$engine = new View\Engines\CompilerEngine($compiler, $app['files'], $app['config']['view.paths'], '.blade.php');

			return new View\Environment($engine, $app['events']);
		});

		$this->app['config']->set('view.driver', 'knife');

		// Assign a namespace and some cascading paths so that view files are first searched
		// for within a theme then within the core view directory.
		$paths = array($this->getPath(), $this->app['feather']['path'] . 'Feather/Views');

		$this->app['view']->addNamespace('feather', $paths);

		// If the theme has a starter file require the file to bootstrap the theme.
		$starter = $this->app['feather']['path'] . 'Themes/' . ucfirst($this->app['config']->get('feather.forum.theme')) . '/start.php';

		if (file_exists($starter))
		{
			require $starter;
		}
	}

}