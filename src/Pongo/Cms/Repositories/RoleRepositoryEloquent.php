<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\Role as Role;

class RoleRepositoryEloquent extends BaseRepositoryEloquent implements BaseRepositoryInterface, RoleRepositoryInterface {

	/**
	 * @var Role model
	 */
	protected $model;

	function __construct(Role $model)
	{
		$this->model = $model;
	}

	public function deleteRoleUsers($role_id)
	{
		return $this->model
					->find($role_id)
					->users()
					->delete();
	}

	public function getRoles()
	{
		return $this->model
					->where('level', '>', 0)
					->orderBy('level', 'desc')
					->orderBy('id', 'asc')
					->get();
	}

	public function getRolesByLevel()
	{
		return $this->model
					->where('level', '>', 0)
					->where('level', '<=', LEVEL)
					->orderBy('level', 'desc')
					->orderBy('id', 'asc')
					->get();
	}

}