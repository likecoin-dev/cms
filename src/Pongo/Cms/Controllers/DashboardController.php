<?php namespace Pongo\Cms\Controllers;

class DashboardController extends BaseController {

	/**
	 * Class constructor
	 * @return void
	 */
	public function __construct()
	{
		$this->beforeFilter('pongo.auth');
	}

	/**
	 * Dashboard view
	 * @return string
	 */
	public function index()
	{
		return \Render::view('sections.dashboard.index');
	}

}