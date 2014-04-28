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

	public function all()
	{
		return $this->model->all();
	}

	public function create(array $item)
	{
		return $this->model->create($item);
	}

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function first($field, $value)
	{
		return $this->model
					->where($field, $value)
					->first();
	}

	public function orderBy($field, $order)
	{
		return $this->model
					->orderBy($field, $order)
					->get();
	}

	public function orderByAndPaginate($field, $order, $per_page)
	{
		return $this->model
					->orderBy($field, $order)
					->paginate($per_page);
	}

	public function paginate($per_page)
	{
		return $this->model->paginate($per_page);
	}

	public function save()
	{
		return $this->model->save();
	}

	public function delete()
	{
		return $this->model->delete();
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