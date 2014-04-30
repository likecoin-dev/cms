<?php namespace Pongo\Cms\Repositories;

interface BaseRepositoryInterface {

	/**
	 * Base methods
	 */
	
	public function all();
	public function create(array $item);
	public function delete();
	public function find($id);
	public function first($field, $value);
	public function orderBy($field, $order);
	public function orderByAndPaginate($field, $order, $per_page);
	public function paginate($per_page);
	public function save();
	public function search($related, $search, $type, $field, $per_page);
	
}