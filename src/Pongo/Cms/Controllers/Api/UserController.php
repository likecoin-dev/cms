<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\UserManager;

class UserController extends ApiController {

	public function __construct(UserManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager;
	}

	/**
	 * Create a new empty user
	 * @return [type] [description]
	 */
	public function create()
	{
		if ($this->manager->createEmptyUser()) {

			return $this->manager->success();
		}
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		if ($this->manager->withInput()->deleteUser()) {

			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * Save user settings
	 * @return json object
	 */
	public function saveSettings()
	{
		if ($this->manager->withInput('id')->saveUserSettings()) {

			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * Save user password
	 * @return json object
	 */
	public function savePassword()
	{
		if ($this->manager->withInput('id')->saveUserPassword()) {

			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * Save user details
	 * @return json object
	 */
	public function saveDetails()
	{
		if ($this->manager->withInput('id')->saveUserDetails()) {

			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * [saveRole description]
	 * @return [type] [description]
	 */
	public function saveRole()
	{
		if ($this->manager->withInput()->roleUser()) {

			return $this->manager->success();

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
		if ($this->manager->withInput()->validUser()) {

			return $this->manager->success();
		}
	}

}