<?php namespace Pongo\Cms\Repositories;

interface RoleRepositoryInterface {

	/**
	 * Custom methods for Role
	 */

	public function deleteRoleUsers($role_id);
	public function getRoles();
	public function getRolesByLevel($level);
	public function getRolesListPaginate($per_page);
	
}