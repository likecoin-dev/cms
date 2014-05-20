<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Illuminate\Events\Dispatcher as Events;
use Pongo\Cms\Services\Validators\LoginValidator as Validator;
use Pongo\Cms\Repositories\UserRepositoryInterface as User;

class LoginManager extends BaseManager {

	public function __construct(Access $access, Events $events, Validator $validator, User $user)
	{
		$this->access = $access;
		$this->events = $events;
		$this->validator = $validator;
		$this->model = $user;

		$this->section = 'login';
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

				$user = \Auth::user();
				
				if($this->access->allowedCms($user->role->level)) {

					$this->events->fire('user.login', array($user));
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

}