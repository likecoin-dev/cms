<?php namespace Pongo\Cms\Services\Managers;

abstract class BaseManager implements BaseManagerInterface  {

	/**
	 * @var $errors
	 */
	public $errors = array();

	/**
	 * @var $success
	 */
	public $success = array();

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
	 * [redirectTo description]
	 * @param  [type] $route [description]
	 * @param  string $msg   [description]
	 * @return [type]        [description]
	 */
	public function redirectTo($route, $msg = 'alert.info.redirecting')
	{	
		$redirect = array(
			'redirect'	=> true,
			'status'	=> 'success',
			'msg'		=> t($msg),
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
		return \Response::json($this->success);
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

	/**
	 * [withInput description]
	 * @return [type] [description]
	 */
	public function withInput()
	{
		$this->input = \Input::all();
		$this->validator->input = $this->input;
		return $this;
	}

	/**
	 * Format errors array
	 * 
	 * @return array
	 */
	protected function formatResponse($status, $message, $subst = array())
	{
		return array(
			'status' 	=> $status,
			'msg'		=> t($message, $subst)
		);
	}

	/**
	 * [setErrors description]
	 * @param [type] $errors [description]
	 */
	protected function setErrors($messages, $subst = array())
	{
		$this->errors = is_array($messages) ? $messages : $this->formatResponse('error', $messages, $subst);
	}

	/**
	 * [setSuccess description]
	 * @param [type] $success [description]
	 */
	protected function setSuccess($messages, $subst = array())
	{
		$this->success = is_array($messages) ? $messages : $this->formatResponse('success', $messages, $subst);
	}
	
}