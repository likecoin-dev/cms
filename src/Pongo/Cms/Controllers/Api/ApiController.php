<?php namespace Pongo\Cms\Controllers\Api;

use Controller;

class ApiController extends Controller {

	/**
	 * @var $manager
	 */
	protected $manager;

	/**
	 * ApiController constructor
	 */
	public function __construct()
	{
		$this->beforeFilter('pongo.auth.api');
	}

}