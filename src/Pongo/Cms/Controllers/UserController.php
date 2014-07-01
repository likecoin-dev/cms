<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Services\Managers\UserManager;

class UserController extends BaseController {

	/**
	 * Class constructor
	 * 
	 * @param Role    $role
	 */
	public function __construct(UserManager $manager)
	{
		$this->beforeFilter('pongo.auth');
		$this->beforeFilter('pongo.access:users');
		$this->manager = $manager;
	}

	/**
	 * [list description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$users = $this->manager->getUsersList();

		return \Render::view('sections.users.index', array('users' => $users));
	}

	/**
	 * [edit description]
	 * @return [type] [description]
	 */
	public function edit($user_id)
	{
		$user = $this->manager->getOne($user_id);

		return \Render::view('sections.users.edit', array('user' => $user));
	}

	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function search()
	{
		if($this->manager->withInputOnly())
		{
			$users = $this->manager->search('users');

			return \Render::view('sections.users.index', $users);
		}
		else
		{			
			return \Redirect::route('users');
		}
	}

}