<?php namespace Pongo\Cms\Repositories;

abstract class BaseRepositoryEloquent implements BaseRepositoryInterface {
	
	/**
	 * [$eagers description]
	 * @var array
	 */
	public $eagers;

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * [all description]
	 * @return [type] [description]
	 */
	public function all()
	{
		return $this->model->all();
	}

	/**
	 * [create description]
	 * @param  array  $item [description]
	 * @return [type]       [description]
	 */
	public function create(array $item)
	{
		return $this->model->create($item);
	}

	/**
	 * [find description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function find($id)
	{
		return $this->model->find($id);
	}

	/**
	 * [first description]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function first($field, $value)
	{
		return $this->model
					->where($field, $value)
					->first();
	}

	/**
	 * [orderBy description]
	 * @param  [type] $field [description]
	 * @param  [type] $order [description]
	 * @return [type]        [description]
	 */
	public function orderBy($field, $order)
	{
		return $this->model
					->orderBy($field, $order)
					->get();
	}

	/**
	 * [orderByAndPaginate description]
	 * @param  [type] $field    [description]
	 * @param  [type] $order    [description]
	 * @param  [type] $per_page [description]
	 * @return [type]           [description]
	 */
	public function orderByAndPaginate($field, $order, $per_page)
	{
		return $this->model
					->orderBy($field, $order)
					->paginate($per_page);
	}

	/**
	 * [paginate description]
	 * @param  [type] $per_page [description]
	 * @return [type]           [description]
	 */
	public function paginate($per_page)
	{
		return $this->model->paginate($per_page);
	}

	/**
	 * [save description]
	 * @return [type] [description]
	 */
	public function save()
	{
		return $this->model->save();
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		return $this->model->delete();
	}

	/**
	 * [search description]
	 * @param  [type] $related  [description]
	 * @param  [type] $search   [description]
	 * @param  [type] $type     [description]
	 * @param  [type] $field    [description]
	 * @param  [type] $per_page [description]
	 * @return [type]           [description]
	 */
	public function search($related, $search, $type, $field, $per_page)
	{
		$sign = ($type == 'equal') ? '=' : 'like';
		if($type == 'contain') $search = '%'.$search.'%';
		if($type == 'start') $search = $search.'%';

		if( ! is_null($related)) {			
			
			$data = array(
				'related' => $related,
				'field' => $field,
				'sign' => $sign,
				'search' => $search
			);

			return $this->model
						->searchHasRelated($data)
						->paginate($per_page);
		} else {
			
			return $this->model
						->where($field, $sign, $search)
						->orderBy($field, 'asc')
						->paginate($per_page);
		}
	}

	/**
	 * returns the current Model to Manager
	 * 
	 * @return object
	 */
	public function getModel()
	{
		return $this->model;
	}

}