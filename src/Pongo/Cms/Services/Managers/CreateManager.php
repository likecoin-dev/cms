<?php namespace Pongo\Cms\Services\Managers;

class CreateManager extends GeneralManager {

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

	public function save($input = array())
	{
		if ( ! empty($input)) $this->input = $input;

		/* Verificare di avere i permessi per operare */
		/* Validare l'input */
		/* Recuperare il Model dalla Repo */
		/* Se valido, creare il record */
		/* Restituire messaggio di errore o di OK */

		return array('access' => $this->access);
	}

}