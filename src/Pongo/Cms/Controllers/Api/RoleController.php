<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\RoleManager;

class RoleController extends ApiController {

	public function __construct(RoleManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager; 
	}

	/**
	 * Create a new empty role
	 * @return [type] [description]
	 */
	public function create()
	{
		if ($this->manager->createEmptyRole()) {
			return $this->manager->success();
		}
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		if ($this->manager->withInput()->deleteRole()) {
			return $this->manager->success();
		} else {
			return $this->manager->errors();
		}
	}

	/**
	 * Move role order
	 * 
	 * @return string json encoded object
	 */
	public function move()
	{
		if ($this->manager->withInput()->moveRole()) {
			return $this->manager->success();
		}
	}

	/**
	 * Save the role model
	 * @return json object
	 */
	public function save()
	{
		if ($this->manager->withInput('id')->saveRole()) {
			return $this->manager->redirectTo('roles');
		} else {
			return $this->manager->errors();
		}
	}

	/**
	 * [valid description]
	 * @return [type] [description]
	 */
	public function valid()
	{
		if ($this->manager->withInput()->validRole()) {
			return $this->manager->success();
		}
	}

}