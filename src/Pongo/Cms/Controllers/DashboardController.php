<?php namespace Pongo\Cms\Controllers;

class DashboardController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('pongo.auth');
	}

	public function showDashboard()
	{
		return \Render::view('sections.dashboard.dashboard');
	}

}