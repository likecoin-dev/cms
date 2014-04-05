<?php namespace Pongo\Cms\Services\Managers;

class LoginManager extends GeneralManager {

	private $repository;

	private $access;

	private $validator;

	public function __construct($repository, $access, $validator)
	{
		parent::__construct();

		$this->repository = $repository;
		$this->access = $access;
		$this->validator = $validator;

		/**
		 * Get the Model from the Repository
		 * 
		 * @var object
		 */
		$this->model = $repository->getModel();
	}

	public function login($input = array())
	{
		if ( ! empty($input)) $this->input = $input;

		/* Verificare di avere i permessi per operare */
		/* Validare l'input */
		/* Recuperare il Model dalla Repo */
		/* Se valido, creare il record */
		/* Restituire messaggio di errore o di OK */

		return array('access' => $this->access);
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