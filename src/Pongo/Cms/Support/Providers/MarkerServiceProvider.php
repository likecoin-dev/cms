<?php namespace Pongo\Cms\Support\Providers;

use Illuminate\Support\ServiceProvider;

class MarkerServiceProvider extends ServiceProvider {

	/**
	 * Register this service provider
	 * 
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		// Bind Markers according with cms::markers
		foreach ($app['config']['cms::markers'] as $methodName => $marker) {

			$markerClass = $marker['class'];

			$app->bind($methodName, function() use ($markerClass) { return new $markerClass; });

		}
	}

}