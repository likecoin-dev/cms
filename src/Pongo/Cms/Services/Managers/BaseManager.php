<?php namespace Pongo\Cms\Services\Managers;


abstract class BaseManager implements BaseManagerInterface  {

	/**
	 * @var $access
	 */
	public $access;

	/**
	 * @var $input
	 */
	protected $input;

	/**
	 * @var $model
	 */
	protected $model;

	/**
	 * @var $validator
	 */
	protected $validator;

	/**
	 * BaseManager constructor
	 */
	public function __construct()
	{
		$this->input = ( ! empty($input)) ?: \Input::all();
	}

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
	
}