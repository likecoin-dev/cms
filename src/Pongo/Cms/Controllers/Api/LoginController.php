<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\LoginManager;

class LoginController extends ApiController {

	/**
	 * LoginController constructor
	 */
	public function __construct(LoginManager $manager)
	{
		// Not apply pongo.auth.api filter
		// parent::__construct();
		$this->manager = $manager; 
	}

	/**
	 * Login a user
	 * 
	 * @return void
	 */
	public function login()
	{
		if ($this->manager->with(\Input::all())->login()) {
			return $this->manager->redirect('dashboard');
		} else {
			return $this->manager->errors();
		}




		/*$credentials = array(
			'username' 	=> \Input::get('username'),
			'password' 	=> \Input::get('password'),
			'is_valid'	=> 1
		);*/

		// return \Response::json($credentials);

		/*if (\Auth::attempt($credentials)) {

			if(\Access::allowedCms(\Auth::user()->role->level)) {

				$this->setConstants();

				\Alert::info(t('alert.info.welcome', array('user' => \Input::get('username'))))->flash();

				return \Redirect::route('dashboard');

			} else {

				\Auth::logout();

				\Alert::error(t('alert.error.unauthorized'))->flash();

				return \Redirect::route('login.index');
			}

		} else {

			\Alert::error(t('alert.error.login'))->flash();

			return \Redirect::route('login.index');
		}*/
	}

}