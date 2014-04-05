<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access as Access;
use Pongo\Cms\Repositories\UserRepositoryInterface as User;
use Pongo\Cms\Services\Validators\LoginValidator as Validator;

class LoginManager extends BaseManager implements LoginManagerInterface {

	/**
	 * LoginManager validator
	 */
	public function __construct(Access $access, User $user, Validator $validator)
	{
		parent::__construct();

		$this->access = $access;
		$this->user = $user;
		$this->validator = $validator;
	}

	public function login()
	{
		// if ( ! empty($input)) $this->input = $input;

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
	/*protected function setConstants()
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
	}*/

}