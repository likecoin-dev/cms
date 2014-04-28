<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\Role as Role;

class RoleRepositoryEloquent extends BaseRepositoryEloquent implements RoleRepositoryInterface {

	function __construct(Role $model)
	{
		$this->model = $model;
	}

	/**
	 * [deleteRoleUsers description]
	 * @param  [type] $role_id [description]
	 * @return [type]          [description]
	 */
	public function deleteRoleUsers($role_id)
	{
		return $this->model
					->find($role_id)
					->users()
					->delete();
	}

	/**
	 * [getRoles description]
	 * @return [type] [description]
	 */
	public function getRoles()
	{
		return $this->model
					->where('level', '>', 0)
					->orderBy('level', 'desc')
					->orderBy('id', 'asc')
					->get();
	}

	/**
	 * [getRolesByLevel description]
	 * @param  [type] $level [description]
	 * @return [type]        [description]
	 */
	public function getRolesByLevel($level)
	{
		return $this->model
					->where('level', '>', 0)
					->where('level', '<=', $level)
					->orderBy('level', 'desc')
					->orderBy('id', 'asc')
					->get();
	}

	/**
	 * [getRolesList description]
	 * @return [type] [description]
	 */
	public function getRolesList()
	{
		return $this->model
					->orderBy('level', 'desc')
					->orderBy('id', 'asc')
					->get();
	}

	/**
	 * [getRolesListPaginate description]
	 * @param  [type] $per_page [description]
	 * @return [type]           [description]
	 */
	public function getRolesListPaginate($per_page)
	{
		return $this->model
					->orderBy('level', 'desc')
					->orderBy('id', 'asc')
					->paginate($per_page);
	}

}