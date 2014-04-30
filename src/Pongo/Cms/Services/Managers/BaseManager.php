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
	 * @var $related
	 */
	protected $related;

	/**
	 * @var [type]
	 */
	protected $search;

	/**
	 * @var $validator
	 */
	protected $validator;

	/**
	 * [getOne description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getOne($id)
	{
		return $this->model->find($id);
	}

	/**
	 * [getOne description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getAll()
	{
		return $this->model->all();
	}

	/**
	 * [getPaginate description]
	 * @return [type] [description]
	 */
	public function getPaginate($per_page)
	{
		return $this->model->paginate($per_page);
	}

	/**
	 * Get paginator additional parameters
	 * @return [type] [description]
	 */
	public function getParams()
	{
		return $this->search->params;
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
	 * [delete description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete($id)
	{
		return $this->model->find($id)->delete();
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
	 * [hasInput description]
	 * @return boolean [description]
	 */
	public function withInputOnly()
	{
		return $this->withInput()->hasInput();
	}

	/**
	 * [hasInput description]
	 * @return boolean [description]
	 */
	public function hasInput()
	{
		return ! empty($this->input);
	}

	/**
	 * [redirectTo description]
	 * @param  [type] $route [description]
	 * @param  [type] $msg   [description]
	 * @return [type]        [description]
	 */
	public function redirectTo($route, $msg = false)
	{	
		$redirect = array(
			'redirect'	=> true,
			'status'	=> 'success',
			'msg'		=> (!$msg) ? $msg : t($msg),
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
	 * [searchUser description]
	 * @return [type] [description]
	 */
	public function search($key = 'items')
	{
		// \Input::flash();
		$results = $this->search->setParams($this->input)->getResults(XPAGE);

		return array(
			$key => $results,
			'params' => $this->getParams()
		);
	}

	/**
	 * [setError description]
	 * @param [type] $errors [description]
	 */
	protected function setError($messages, $subst = array())
	{
		$this->errors = is_array($messages) ? $messages : $this->formatResponse('error', $messages, $subst);
		return false;
	}

	/**
	 * [setSuccess description]
	 * @param [type] $success [description]
	 */
	protected function setSuccess($messages, $subst = array())
	{
		$this->success = is_array($messages) ? $messages : $this->formatResponse('success', $messages, $subst);
		return true;
	}

	/**
	 * [with description]
	 * @param  array  $input [description]
	 * @param  array  $data  [description]
	 * @return [type]        [description]
	 */
	public function with(array $input, $data = array())
	{
		$this->input = $input;
		$this->validator->input = $input;
		if (is_string($data)) $data = func_get_args();
		$this->validator->data = $data;
		return $this;
	}

	/**
	 * [withInput description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function withInput($data = array())
	{
		$this->input = \Input::all();
		$this->validator->input = $this->input;
		if (is_string($data)) $data = func_get_args();
		$this->validator->data = $data;
		return $this;
	}

	/**
	 * [withEager description]
	 * @param  [type] $relations [description]
	 * @return [type]            [description]
	 */
	public function withEager($relations)
	{
		if (is_string($relations)) $relations = func_get_args();
		$this->model->eagers = $relations;
		return $this;
	}
	
}