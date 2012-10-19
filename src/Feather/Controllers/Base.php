<?php namespace Feather\Controllers;

use Controller;
use Illuminate\Container;
use Illuminate\Support\Facade;
use Illuminate\Routing\Router;

class Base extends Controller {

	/**
	 * Layout to be used by Feather.
	 * 
	 * @var Illuminate\View\View
	 */
	public $layout;

	/**
	 * Illuminate application instance.
	 * 
	 * @var Illuminate\Foundation\Application
	 */
	public $app;

	/**
	 * Controller constructor.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->app = Facade::getFacadeApplication();

		$this->layout = $this->app['view']->make('feather::theme');
	}

	/**
	 * Process a controller action response.
	 *
	 * @param  Illuminate\Routing\Router  $router
	 * @param  string                     $method
	 * @param  mixed                      $response
	 * @return Symfony\Component\HttpFoundation\Response
	 */
	protected function processResponse($router, $method, $response)
	{
		// The response needs to be placed within the content of the layout.
		$response = $this->layout->with('content', $response);

		return parent::processResponse($router, $method, $response);
	}

}