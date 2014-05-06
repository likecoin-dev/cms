<?php namespace Pongo\Cms\Repositories;

interface RoleRepositoryInterface {

	/**
	 * Custom methods for Role
	 */
	public function getRoles();
	public function getRolesByLevel($level);
	public function getRolesList();
	public function getActiveRolesList();
	public function getRolesListPaginate($per_page);	
}