<?php namespace Pongo\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Load extends Facade {

	/**
	 * Get the registred name of the component
	 * 
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'Load'; }

}