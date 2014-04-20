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
		if ($this->manager->withInput()->login()) {
			return $this->manager->redirectTo('dashboard');
		} else {
			return $this->manager->errors();
		}
	}

}