<?php namespace Pongo\Cms\Controllers;

class LogoutController extends BaseController {

	/**
	 * Class constructor
	 * @return void
	 */
	public function __construct()
	{
		$this->beforeFilter('pongo.auth');
	}

	/**
	 * Log the user out
	 * 
	 * @return void
	 */
	public function logout()
	{
		\Auth::logout();
		\Alert::success(t('alert.info.logout'))->flash();
		return \Redirect::route('login.index');
	}

}