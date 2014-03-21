<?php namespace Pongo\Cms\Repositories;

interface RoleRepositoryInterface {

	/**
	 * Common methods
	 */
	
	public function create($create_array);

	public function find($id);

	public function first($field, $value);

	public function orderBy($field, $order);

	public function orderByAndPaginate($field, $order, $per_page);

	public function paginate($per_page);

	public function save();

	public function delete();

	/**
	 * Custom methods for Role
	 */

	public function deleteRoleUsers($role);

	public function getRoles();

	public function getRolesByLevel();
	
}