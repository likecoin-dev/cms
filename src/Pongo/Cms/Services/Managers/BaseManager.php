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
	 * @var $events
	 */
	protected $events;

	/**
	 * @var $model
	 */
	protected $model;

	/**
	 * @var $related
	 */
	protected $related = array();

	/**
	 * @var [type]
	 */
	protected $search;

	/**
	 * @var [type]
	 */
	protected $section;

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
	 * [canEdit description]
	 * @return [type] [description]
	 */
	public function canEdit()
	{
		if($this->access->cantEdit($this->section)) {
			return $this->setError('alert.error.cant_edit');
		}
		return true;
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
	 * [saveCustomForm description]
	 * @param  [type] $form [description]
	 * @param  string $msg  [description]
	 * @return [type]       [description]
	 */
	public function saveCustomForm($name, $form, $msg = 'alert.success.save')
	{
		$form_structure = \Pongo::forms($form);

		extract($this->input);		
		$model = $this->model->find($id)->$name;

		foreach ($form_structure as $field => $value) {
			if($value['form'] == 'date') {				
				$model->$field = \Carbon\Carbon::create($birth_year, $birth_month, $birth_day);
			} elseif($value['form'] == 'datetime') {
				$model->$field = \Carbon\Carbon::create($birth_year, $birth_month, $birth_day, $birth_hh, $birth_mm);
			} else {
				$model->$field = $$field;
			}
		}

		$model->save();
		return $this->setSuccess($msg);
	}

	/**
	 * [searchUser description]
	 * @return [type] [description]
	 */
	public function search($key = 'items')
	{
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
	 * [with description]
	 * @param  array  $input [description]
	 * @param  array  $data  [description]
	 * @return [type]        [description]
	 */
	public function with(array $input, $data = array())
	{
		$this->input = $input;
		$this->validator->input = $input;
		
		if(array_key_exists('section', $this->input)) {
			$this->validator->section = $this->input['section'];
		}

		if(array_key_exists('tovalid', $this->input)) {
			$this->validator->custom_rules = $this->input['tovalid'];
		}

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

		if(array_key_exists('section', $this->input)) {
			$this->validator->section = $this->input['section'];
		}

		if(array_key_exists('tovalid', $this->input)) {
			$this->validator->custom_rules = $this->input['tovalid'];
		}

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