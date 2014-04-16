<?php namespace Pongo\Cms\Services\Managers;

abstract class BaseManager implements BaseManagerInterface  {

	/**
	 * @var $errors
	 */
	public $errors = array();

	/**
	 * @var $input
	 */
	protected $input;

	/**
	 * @var $access
	 */
	protected $access;

	/**
	 * @var $model
	 */
	protected $model;

	/**
	 * @var $validator
	 */
	protected $validator;

	/**
	 * [create description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function create($id)
	{

	}

	/**
	 * [delete description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete($id)
	{

	}

	/**
	 * [update description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function update($id)
	{

	}

	/**
	 * [errors description]
	 * @return [type] [description]
	 */
	public function errors()
	{
		return \Response::json($this->errors);
	}

	/**
	 * [redirect description]
	 * @param  [type] $route [description]
	 * @return [type]        [description]
	 */
	public function redirect($route)
	{	
		$redirect = array(
			'status'	=> 'redirect',
			'route'		=> route($route)
		);
		return \Response::json($redirect);
	}

	/**
	 * [success description]
	 * @return [type] [description]
	 */
	public function success()
	{

	}

	/**
	 * [with description]
	 * @param  array  $input [description]
	 * @param  array  $data  [description]
	 * @return [type]        [description]
	 */
	public function with(array $input, array $data = array())
	{
		$this->input = $input;
		$this->validator->input = $input;
		$this->validator->data = $data;
		return $this;
	}
	
}