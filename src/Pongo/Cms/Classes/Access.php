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
	 * Check page role_level against user level
	 * 
	 * @param  int $role_level page role_level
	 * @return void
	 */
	public function grantEdit($role_level)
	{
		if(!is_numeric($role_level)) {
			$role = \Pongo::system('sections.' . $role_level . '.min_access');
			$role_level = \Pongo::system('roles.' . $role);
		}

		$blocked = ($role_level > LEVEL) ? true : false;

		if($blocked) {
			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.not_granted')
			);
			return $response;
		}
		return $blocked;
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
	 * Create role list
	 * 
	 * @param  int $role_id
	 * @return string
	 */
	/*public function roleList($role_id, $partial = 'roleitem')
	{
		$items = $this->role->getRolesByLevel();

		$item_view = \Render::view('partials.items.' . $partial);

		$item_view['items'] 	= $items;

		$item_view['role_id'] 	= $role_id;

		return $item_view;
	}*/

	/**
	 * Get max level role available
	 * 
	 * @return integer
	 */
	public function roleMaxLevel()
	{
		return max(\Pongo::system('roles'));
	}

	/**
	 * Create user list
	 * 
	 * @param  int $role_id
	 * @return string
	 */
	/*public function userList($user_id)
	{
		\Render::assetAdd('footer', 'paginator', 'scripts/plugins/paginator.js');

		$items = $this->user->getUsersWithRoles(pag());

		$item_view = \Render::view('partials.items.useritem');

		$item_view['items'] 	= $items;
		
		$item_view['user_id'] 	= $user_id;

		return $item_view;
	}*/

}