<?php namespace Pongo\Cms\Controllers;

use Illuminate\Events\Dispatcher as Events;

class LogoutController extends BaseController {

	protected $events;

	/**
	 * Class constructor
	 * @return void
	 */
	public function __construct(Events $events)
	{
		$this->events = $events;
		$this->beforeFilter('pongo.auth');
	}

	/**
	 * Log the user out
	 * 
	 * @return void
	 */
	public function logout()
	{
		$this->events->fire('user.logout');
		
		return \Redirect::route('login.index');
	}

}