<?php namespace Pongo\Cms\Support\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

	/**
	 * Register this service provider
	 * 
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Symfony\Component\Translation\TranslatorInterface', function($app) {
			return $app['translator']; 
		});
	}

}