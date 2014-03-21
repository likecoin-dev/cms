<?php namespace Pongo\Cms\Services\Managers;

use Input;

abstract class GeneralManager {
	
	protected $input;

	protected $model;

	public function __construct($input = array())
	{
		$this->input = ( ! empty($input)) ?: Input::all();
	}

	public function getModel()
	{
		return $this->model;
	}

}