<?php namespace Pongo\Cms\Repositories;

use Illuminate\Database\Eloquent\Model;
use Pongo\Cms\Services\Cache\CacheInterface;

abstract class BaseRepositoryEloquent {
	
	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * @var Cache
	 */
	protected $cache;

	function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;
	}

	public function create($create_array)
	{
		return $this->model->create($create_array);
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
	private function getModel()
	{
		return $this->model;
	}

}