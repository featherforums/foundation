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
		$provider = m::mock('Feather\Providers\FeatherServiceProvider[getRoutes]');
		$app['router'] = m::mock('Illuminate\Routing\Router[get,post,put,delete]');
		$app['files'] = m::mock(new Illuminate\Filesystem);

		$app['config'] = array('feather.handles' => '/');

		$provider->shouldReceive('getRoutes')->once()->with($app['files'], 'path/to/routes')->andReturn(array(
			'get (:feather)' => 'foo@bar',
			'resource (:feather)/users' => 'FooController'
		));

		$app['router']->shouldReceive('get')->once()->with('/', 'foo@bar')->andReturn(true);

		$app['router']->shouldReceive('get')->once()->with('users', 'FooController@index')->andReturn(true);
		$app['router']->shouldReceive('get')->once()->with('users/create', 'FooController@create')->andReturn(true);
		$app['router']->shouldReceive('post')->once()->with('users', 'FooController@store')->andReturn(true);
		$app['router']->shouldReceive('get')->once()->with('users/{id}', 'FooController@show')->andReturn(true);
		$app['router']->shouldReceive('get')->once()->with('users/{id}/edit', 'FooController@edit')->andReturn(true);
		$app['router']->shouldReceive('put')->once()->with('users/{id}', 'FooController@update')->andReturn(true);
		$app['router']->shouldReceive('delete')->once()->with('users/{id}', 'FooController@destroy')->andReturn(true);

		$provider->registerRoutes($app, 'path/to/routes');
	}

}