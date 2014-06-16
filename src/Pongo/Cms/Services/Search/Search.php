<?php namespace Pongo\Cms\Services\Search;

class Search implements SearchInterface {

	/**
	 * @var [type]
	 */
	protected $field;

	/**
	 * @var [type]
	 */
	protected $input;

	/**
	 * @var [type]
	 */
	protected $type;

	/**
	 * @var [type]
	 */
	protected $model;

	/**
	 * Paginator additional parameters
	 * @var [type]
	 */
	public $params;

	/**
	 * @var [type]
	 */
	protected $q;

	/**
	 * @var [type]
	 */
	protected $related;

	/**
	 * [__set description]
	 * @param [type] $var [description]
	 * @param [type] $val [description]
	 */
	public function __set($var, $val)
	{
		$this->$var = $val;
	}

	/**
	 * [getResults description]
	 * @return [type] [description]
	 */
	public function getResults($per_page)
	{
		return $this->model->search($this->related, $this->q, $this->type, $this->field, $per_page);
	}

	/**
	 * [setParams description]
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public function setParams($input)
	{
		\Input::flash();

		$this->params = array(
			'field' => $input['field'],
			'type' => $input['type'],
			'q' => $input['q']
		);

		if (strpos($input['field'], ':') !== false)
		{
			$exp = explode(':', $input['field']);
			$this->related = $exp[0];
			$input['field'] = $exp[1];
		}
		
		$this->field = $input['field'];
		$this->type = $input['type'];
		$this->q = $input['q'];

		$this->input = $input;

		return $this;
	}

}