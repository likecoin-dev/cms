<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Support\Repositories\RoleRepositoryInterface as Role;

class RoleController extends BaseController {

	/**
	 * Class constructor
	 * 
	 * @param Role    $role
	 */
	public function __construct(Role $role)
	{
		parent::__construct();

		$this->beforeFilter('pongo.auth');

		$this->role = $role;
	}

	/**
	 * Show role settings page
	 * 
	 * @param  int $role_id
	 * @return string     view page
	 */
	public function settingsRole($role_id = null)
	{
		if(is_null($role_id)) $role_id = ROLEID;

		$role = $this->role->getRole($role_id);

		$view = \Render::view('sections.role.settings');
		$view['section'] 		= 'roles';
		$view['role_id'] 		= $role_id;
		$view['section_name'] 	= t('menu.roles');		
		$view['name']			= $role->name;

		return $view;
	}

}