<?php

use Mockery as m;

class FeatherRoutesTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}


	public function testRoutesGetLoadedFromFile()
	{
		$app = m::mock(new Illuminate\Foundation\Application);
		$files = m::mock(new Illuminate\Filesystem);
		$provider = m::mock('Feather\Providers\FeatherServiceProvider[getRoutes]');
		$router = m::mock('Illuminate\Routing\Router[get]');

		$app['config'] = array('feather.handles' => '/');

		$provider->shouldReceive('getRoutes')->once()->with($files, 'path/to/routes')->andReturn(array('get (:feather)' => 'foo@bar'));
		$router->shouldReceive('get')->once()->with('/', 'foo@bar')->andReturn(true);

		$provider->registerRoutes('path/to/routes', $app['config'], $files, $router);
	}

}