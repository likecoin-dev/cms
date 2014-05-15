<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\Role as Role;

class RoleRepositoryEloquent extends BaseRepositoryEloquent implements RoleRepositoryInterface {

	function __construct(Role $model)
	{
		$this->model = $model;
	}

	/**
	 * [getRoles description]
	 * @return [type] [description]
	 */
	public function getRoles()
	{
		return $this->model
					->hasLevel()
					->order()
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
					->hasLevel()
					->levelUnderEqual($level)
					->order()
					->get();
	}

	/**
	 * [getRolesList description]
	 * @return [type] [description]
	 */
	public function getRolesList()
	{
		return $this->model
					->order()
					->get();
	}

	/**
	 * [getActiveRolesList description]
	 * @return [type] [description]
	 */
	public function getActiveRolesList()
	{
		return $this->model
					->active()
					->order()
					->get();
	}

	/**
	 * [getActiveRolesList description]
	 * @return [type] [description]
	 */
	public function getActiveEditorRolesList()
	{
		return $this->model
					->active()
					->editor()
					->hasLevel()
					->order()
					->get();
	}

	/**
	 * [getActiveRolesList description]
	 * @return [type] [description]
	 */
	public function getActiveUsersRolesList()
	{
		return $this->model
					->active()
					->hasLevel()
					->order()
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