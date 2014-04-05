<?php namespace Pongo\Cms\Controllers;

use Controller;

class BaseController extends Controller {

	/**
	 * Class constructor
	 */
	public function __construct()
	{

	}

	/**
	 * Generate bootstrap javascript virtual file
	 * 
	 * @return void
	 */
	public function bootstrap()
	{
		$contents = \Render::view('partials.bootstrap');

		$response = \Response::make($contents, 200);

		$response->header('Content-Type', 'application/javascript');

		return $response;
	}

	/**
	 * Change interface lang
	 * 
	 * @return void
	 */
	public function changeLang($lang)
	{
		if(isset($lang)) {

			\Session::put('CMSLANG', $lang);
		}

		return \Redirect::back();
	}

	/**
	 * Log the user out
	 * 
	 * @return void
	 */
	public function logout()
	{
		\Auth::logout();

		\Alert::info(t('alert.info.logout'))->flash();

		return \Redirect::route('login.index');
	}

}