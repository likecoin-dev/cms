<?php namespace Pongo\Cms\Services\Filters;

use Access, Alert, Auth, Event, Redirect;

class CmsFilter {

	public function guestFilter()
	{
		if (Auth::check()) {
			return Redirect::route('dashboard');
		}
	}

	public function accessFilter($route, $request, $section)
	{
		if ( ! Access::grantEdit($section)) {
			Alert::error(t('alert.error.not_granted'))->flash();
			return Redirect::route('dashboard');
		}
	}

	public function authFilter()
	{
		if (Auth::guest()) {
			Alert::error(t('alert.error.unauthorized'))->flash();
			return Redirect::route('login.index');
		}
		if (USERNAME == '') {
			Event::fire('user.login', array(Auth::user(), Auth::user()->lang));
			return Redirect::route('dashboard');
		}
	}

}