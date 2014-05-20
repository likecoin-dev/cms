<?php namespace Pongo\Cms\Controllers;

use Controller;

class BaseController extends Controller {

	/**
	 * @var $manager
	 */
	protected $manager;

	/**
	 * Generate bootstrap javascript virtual file
	 * 
	 * @return void
	 */
	public function init()
	{
		$contents = \Render::view('partials.initjs');
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

}