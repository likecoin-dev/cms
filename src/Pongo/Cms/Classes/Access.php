<?php namespace Pongo\Cms\Classes;

use Pongo\Cms\Repositories\RoleRepositoryInterface as Role;
// use Pongo\Cms\Repositories\UserRepositoryInterface as User;

class Access {

	protected $role;

	// protected $user;

	/**
	 * Render constructor
	 */
	public function __construct(Role $role/*, User $user*/)
	{
		$this->role = $role;
		// $this->user = $user;
	}

	/**
	 * Create array of admin roles
	 * 
	 * @param  array  	$roles   	Roles array of object
	 * @param  boolean 	$reverse 	Reverse result array
	 * @return array           		Admin roles array
	 */
	public function adminRoles($roles, $reverse = false)
	{
		$min_access = \Pongo::system('min_access');

		$role_access = \Pongo::system('roles.'.$min_access);

		$admin_roles = array();

		foreach ($roles as $role) {
			
			if($role->level >= $role_access) {

				$admin_roles[$role->name] = $role->level;	
			}
		}

		return $reverse ? array_reverse($admin_roles) : $admin_roles;
	}
	
	/**
	 * Check current user is a editor+ user
	 * 
	 * @param  integer $level
	 * @return bool
	 */
	public function allowedCms($level = null)
	{
		if(is_null($level)) $level = LEVEL;
		$min_access = \Pongo::system('min_access');
		$min_level = \Pongo::system('roles.' . $min_access);
		return ($level >= $min_level) ? true : false;
	}

	/**
	 * [cantEdit description]
	 * @param  [type] $section [description]
	 * @return [type]          [description]
	 */
	public function cantEdit($section)
	{
		return  ! $this->grantEdit($section);
	}

	/**
	 * Check page role_level against user level
	 * 
	 * @param  int / string $role_level page role_level
	 * @return bool
	 */
	public function grantEdit($min_access_level)
	{
		if (is_numeric($min_access_level)) {
			return (LEVEL >= $min_access_level) ? true : false;
		} else {
			$sections = \Pongo::flattenSections();
			$access = $sections[$min_access_level]['min_access'];
			$accessLevel = \Pongo::system('roles.' . $access);
			return (LEVEL >= $accessLevel) ? true : false;
		}
		return false;
	}

	/**
	 * Check if a role name is a system role
	 * 
	 * @param  string  $role_name
	 * @return boolean
	 */
	public function isSystemRole($role_name)
	{
		if(is_numeric($role_name)) {

			$role_id = $role_name;

			$role = $this->role->getRole($role_id);

			$role_name = $role->name;
		}

		return (array_key_exists($role_name, \Pongo::system('roles'))) ? true : false;
	}

	/**
	 * Get max level role available
	 * 
	 * @return integer
	 */
	public function roleMaxLevel()
	{
		return max(\Pongo::system('roles'));
	}

}