<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Services\Managers\RoleManager;

class RoleController extends BaseController {

	/**
	 * Class constructor
	 * 
	 * @param Role    $role
	 */
	public function __construct(RoleManager $manager)
	{
		$this->beforeFilter('pongo.auth');
		$this->beforeFilter('pongo.access:roles');
		$this->manager = $manager;
	}

	/**
	 * [list description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$roles = $this->manager->getRolesList();

		return \Render::view('sections.roles.index', array('roles' => $roles));
	}

	/**
	 * [edit description]
	 * @return [type] [description]
	 */
	public function edit($role_id)
	{
		$role = $this->manager->getOne($role_id);
		
		return \Render::view('sections.roles.edit', array('role' => $role));
	}

}