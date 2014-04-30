<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Pongo\Cms\Services\Validators\LoginValidator as Validator;
use Pongo\Cms\Repositories\UserRepositoryInterface as User;

class LoginManager extends BaseManager {

	public function __construct(Access $access, Validator $validator, User $user)
	{
		$this->access = $access;
		$this->validator = $validator;
		$this->model = $user;
	}
	/**
	 * Perform a login check in the controller
	 * @return json object
	 */
	public function login()
	{
		if ($this->validator->fails()) {
			return $this->setError($this->validator->errors());
		} else {
			$remember = \Input::has('remember');
			$credentials = array(
				'username' 	=> $this->input['username'],
				'password' 	=> $this->input['password'],
				'is_active' => 1
			);
			if ( \Auth::attempt($credentials, $remember) ) {
				if($this->access->allowedCms(\Auth::user()->role->level)) {
					self::setSessionConstants($this->input['cmslang']);
					\Alert::info(t('alert.info.welcome', array('user' => $this->input['username'])))->flash();
					return true;
				} else {
					\Auth::logout();
					return $this->setError('alert.error.unauthorized');
				}
			} else {
				return $this->setError('alert.error.login');
			}	
		}
	}

	/**
	 * Set constants values on login
	 * @return void
	 */
	public static function setSessionConstants($cmslang)
	{
		\Session::put('USERID', \Auth::user()->id);
		\Session::put('USERNAME', \Auth::user()->username);
		\Session::put('EMAIL', \Auth::user()->email);
		\Session::put('ROLEID', \Auth::user()->role->id);
		\Session::put('ROLENAME', \Auth::user()->role->name);
		\Session::put('LEVEL', \Auth::user()->role->level);
		\Session::put('LANG', \Auth::user()->lang);
		\Session::put('EDITOR', \Auth::user()->editor);
		\Session::put('CMSLANG', ($cmslang) ?: \Auth::user()->lang);
	}

}