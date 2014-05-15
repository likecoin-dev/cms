<?php namespace Pongo\Cms\Support\Providers;

use Illuminate\Support\ServiceProvider;

use Pongo\Cms\Services\Events\BlockSubscriber;
use Pongo\Cms\Services\Events\PageSubscriber;
use Pongo\Cms\Services\Events\RoleSubscriber;
use Pongo\Cms\Services\Events\TagSubscriber;
use Pongo\Cms\Services\Events\UserSubscriber;

class EventServiceProvider extends ServiceProvider {

	/**
	 * Register this service provider
	 * 
	 * @return void
	 */
	public function register()
	{
		$this->app->events->subscribe(new BlockSubscriber);
		$this->app->events->subscribe(new PageSubscriber);
		$this->app->events->subscribe(new RoleSubscriber);
		$this->app->events->subscribe(new TagSubscriber);
		$this->app->events->subscribe(new UserSubscriber);
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