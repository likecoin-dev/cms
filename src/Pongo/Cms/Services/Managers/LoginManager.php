<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Pongo\Cms\Services\Validators\LoginValidator as Validator;
use Pongo\Cms\Repositories\UserRepositoryInterface as User;

class LoginManager extends BaseManager implements LoginManagerInterface {

	/**
	 * LoginManager validator
	 */
	public function __construct(Access $access, Validator $validator, User $user)
	{
		$this->access = $access;
		$this->validator = $validator;
		$this->model = $user;
	}

	public function login()
	{
		if ($this->validator->fails()) {			
			$this->errors = $this->validator->errors();
		} else {
			$credentials = array_merge($this->input, array('is_valid' => 1));
			unset($credentials['_token']);
			if ( \Auth::attempt($credentials) ) {
				if($this->access->allowedCms(\Auth::user()->role->level)) {
					$this->setConstants();
					return true;
					// \Alert::info(t('alert.info.welcome', array('user' => \Input::get('username'))))->flash();
					// return \Redirect::route('dashboard');
				} else {
					\Auth::logout();
					// \Alert::error(t('alert.error.unauthorized'))->flash();
					// return \Redirect::route('login.index');
				}
			} else {

			}
			
		}

		

		// Verificare di avere i permessi per operare 
		// Validare l'input 
		// Recuperare il Model dalla Repo 
		// Se valido, creare il record 
		// Restituire messaggio di errore o di OK
	}

	/**
	 * Set constants values on login
	 *
	 * @return void
	 */
	protected function setConstants()
	{
		\Session::put('USERID', \Auth::user()->id);
		\Session::put('USERNAME', \Auth::user()->username);
		\Session::put('EMAIL', \Auth::user()->email);
		\Session::put('ROLEID', \Auth::user()->role->id);
		\Session::put('ROLENAME', \Auth::user()->role->name);
		\Session::put('LEVEL', \Auth::user()->role->level);
		\Session::put('LANG', \Auth::user()->lang);
		\Session::put('CMSLANG', \Auth::user()->lang);
		\Session::put('EDITOR', \Auth::user()->editor);
	}

}