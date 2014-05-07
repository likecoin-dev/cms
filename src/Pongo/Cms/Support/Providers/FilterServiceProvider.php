<?php namespace Pongo\Cms\Support\Providers;

use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider {

	/**
	 * Register this service provider
	 * 
	 * @return void
	 */
	public function register()
	{
		$this->app->router->filter('pongo.guest', 'Pongo\Cms\Services\Filters\CmsFilter@guestFilter');
		$this->app->router->filter('pongo.access',  'Pongo\Cms\Services\Filters\CmsFilter@accessFilter');
		$this->app->router->filter('pongo.auth',  'Pongo\Cms\Services\Filters\CmsFilter@authFilter');
		$this->app->router->filter('pongo.auth.api', 'Pongo\Cms\Services\Filters\ApiFilter@authFilter');
	}

	/**
	 * Boot this service provider
	 * 
	 * @return void
	 */
	public function boot()
	{
		// 
	}

}