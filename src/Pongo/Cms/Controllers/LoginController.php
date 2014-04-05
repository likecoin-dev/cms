<?php namespace Pongo\Cms\Controllers;

class LoginController extends BaseController {
	
	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->beforeFilter('pongo.guest');
	}

	/**
	 * Login form
	 * 
	 * @return void
	 */
	public function index()
	{
		return \Render::view('sections.login.login');
	}

}