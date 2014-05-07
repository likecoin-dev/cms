<?php namespace Pongo\Cms\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Pongo\Cms\Services\Validators\PongoValidator;

class ValidatorServiceProvider extends ServiceProvider {

	/**
	 * Register this service provider
	 * 
	 * @return void
	 */
	public function register()
	{
		// 
	}

	public function boot()
	{
		$this->app->validator->resolver(function($translator, $data, $rules, $messages) {
			return new PongoValidator($translator, $data, $rules, $messages);
		});
	}

}