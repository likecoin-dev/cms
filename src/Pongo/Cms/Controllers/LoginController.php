<?php namespace Pongo\Cms\Controllers;

class LoginController extends BaseController {
	
	/**
	 * Class constructor
	 * @return void
	 */
	public function __construct()
	{
		$this->beforeFilter('pongo.guest');
	}

	/**
	 * Login form
	 * @return view
	 */
	public function index()
	{
		$languages = \Pongo::settings('languages');
		return \Render::view('sections.login.login', array('languages' => $languages));
	}

}