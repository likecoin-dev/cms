<?php namespace Pongo\Cms\Controllers;

class DashboardController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('pongo.auth');
	}

	public function index()
	{
		return \Render::view('sections.dashboard.index');
	}

}