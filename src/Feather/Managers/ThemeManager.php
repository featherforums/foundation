<?php namespace Feather\Managers;

use Feather\Knife;
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
		// Register a custom engine with the View object so that some extra functionality
		// can be parsed when parsing Blade views.
		$this->app['view']->extend('knife', function($app)
		{
			$files = $app['files'];

			// The Compiler engine requires an instance of the CompilerInterface, which in
			// this case will be the Blade compiler, so we'll first create the compiler
			// instance to pass into the engine so it can compile the views properly.
			$compiler = new Knife($files, $app['config']['view.cache']);

			$paths = $app['config']['view.paths'];

			$engine = new View\Engines\CompilerEngine($compiler, $files, $paths, '.blade.php');

			return new View\Environment($engine);
		});

		// Set the default driver to the newly registered Knife driver.
		$this->app['config']->set('view.driver', 'knife');

		// Assign a namespace and some cascading paths so that view files are first searched
		// for within a theme then within the core view directory.
		$paths = array($this->getPath(), $this->app['feather']['path'] . 'Feather/Views');

		$this->app['view']->addNamespace('feather', $paths);

		// If the theme has a starter file require the file to bootstrap the theme.
		$starter = $this->app['feather']['path'] . 'Themes/' . ucfirst($this->app['config']->get('feather.forum.theme')) . '/start.php';

		if(file_exists($starter))
		{
			require $starter;
		}
	}

}