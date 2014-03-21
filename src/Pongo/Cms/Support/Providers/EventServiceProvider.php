<?php namespace Pongo\Cms\Support\Providers;

use Illuminate\Support\ServiceProvider;

use Event;

class EventServiceProvider extends ServiceProvider {

	/**
	 * Register this service provider
	 * 
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Boot this service provider
	 * 
	 * @return void
	 */
	public function boot()
	{
		/*Event::listen('event.testing', function($param) {

			return $param;

		});*/

		Event::listen('event.testing', 'Pongo\Cms\Support\Events\TestingEvent@test');
	}

}