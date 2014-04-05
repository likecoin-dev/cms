<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Support\Repositories\UserRepositoryInterface as User;

class UserController extends BaseController {

	/**
	 * Class constructor
	 * 
	 * @param Role    $role
	 */
	public function __construct(User $user)
	{
		parent::__construct();

		$this->beforeFilter('pongo.auth');

		$this->user	= $user;
	}

	/**
	 * Show users list
	 * 
	 * @return string view page
	 */
	public function allUsers()
	{
		\Render::assetAdd('footer', 'paginator', 'scripts/plugins/paginator.js');

		$users = $this->user->paginateUsers(pag());

		$view = \Render::view('sections.user.all');
		$view['section'] 	= 'users';
		$view['users'] 		= $users;

		return $view;
	}

	public function detailsUser($user_id = null)
	{
		if(is_null($user_id)) $user_id = USERID;

		$user = $this->user->getUser($user_id);
		$user_details = $this->user->getUserDetails($user);

		$view = \Render::view('sections.user.details');
		$view['section'] 		= 'details';
		$view['role_id']		= $user->role_id;
		$view['user_id'] 		= $user_id;
		$view['section_name'] 	= t('menu.users');		
		$view['name']			= $user->username;
		$view['input_form']		= \Pongo::forms('user_details');
		$view['user_details']	= $user_details;

		return $view;
	}

	/**
	 * Show user password page
	 * 
	 * @param  int $user_id
	 * @return string     view page
	 */
	public function passwordUser($user_id = null)
	{
		if(is_null($user_id)) $user_id = USERID;

		$user = $this->user->getUser($user_id);

		$view = \Render::view('sections.user.password');
		$view['section'] 		= 'password';
		$view['role_id']		= $user->role_id;
		$view['user_id'] 		= $user_id;
		$view['section_name'] 	= t('menu.users');
		$view['name']			= $user->username;

		return $view;
	}

	/**
	 * Show user settings page
	 * 
	 * @param  int $user_id
	 * @return string     view page
	 */
	public function settingsUser($user_id = null)
	{
		if(is_null($user_id)) $user_id = USERID;

		$user = $this->user->getUser($user_id);

		$view = \Render::view('sections.user.settings');
		$view['section'] 		 = 'settings';
		$view['role_id']		 = $user->role_id;
		$view['user_id'] 		 = $user_id;
		$view['section_name'] 	 = t('menu.users');		
		$view['name']			 = $user->username;
		$view['email']			 = $user->email;
		$view['langs']			 = \Pongo::settings('languages');
		$view['lang_selected']	 = $user->lang;
		$view['editors']		 = \Pongo::settings('editors');
		$view['editor_selected'] = $user->editor;

		return $view;
	}

}