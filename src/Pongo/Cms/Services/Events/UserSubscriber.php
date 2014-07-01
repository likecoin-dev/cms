<?php namespace Pongo\Cms\Services\Events;

use Alert, Auth, Session;

class UserSubscriber extends BaseSubscriber {

	/**
	 * [onChangeRole description]
	 * @param  [type] $user [description]
	 * @param  [type] $role [description]
	 * @return [type]       [description]
	 */
	public function onChangeRole($user, $role)
	{
		if($user->id == USERID) {
			Session::put('LEVEL', $role->level);
			Session::put('ROLEID', $role->id);
			Session::put('ROLENAME', $role->name);
		}
	}

	/**
	 * [onCreate description]
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function onCreate($user)
	{
		// D('User has been created!');
	}

	/**
	 * [onDelete description]
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function onDelete($related, $user_id)
	{
		$related->deleteUserDetails($user_id);
	}

	/**
	 * [onLogin description]
	 * @param  [type] $user    [description]
	 * @return [type]          [description]
	 */
	public function onLogin($user)
	{
		// Set constants in session
		Session::put('USERID', $user->id);
		Session::put('USERNAME', $user->username);
		Session::put('EMAIL', $user->email);
		Session::put('ROLEID', $user->role->id);
		Session::put('ROLENAME', $user->role->name);
		Session::put('LEVEL', $user->role->level);
		Session::put('LANG', $user->lang);
		Session::put('EDITOR', $user->editor);
		Session::put('CMSLANG', $user->lang);

		Alert::info(t('alert.info.welcome', array('user' => $user->username)))->flash();
	}

	/**
	 * [onLogout description]
	 * @return [type] [description]
	 */
	public function onLogout()
	{
		Auth::logout();
		
		Session::flush();

		Alert::info(t('alert.info.logout'))->flash();
	}

	/**
	 * [onChangeRole description]
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function onSaveSettings($user)
	{
		if($user->id == USERID) {
			Session::put('USERNAME', $user->username);
			Session::put('EMAIL', $user->email);
			Session::put('LANG', $user->lang);
		}
	}

	/**
	 * [subscribe description]
	 * @param  [type] $events [description]
	 * @return [type]         [description]
	 */
	public function subscribe($events)
	{
		$events->listen('user.create', $this->eventPath . 'UserSubscriber@onCreate');
		$events->listen('user.delete', $this->eventPath . 'UserSubscriber@onDelete');
		$events->listen('user.login',  $this->eventPath . 'UserSubscriber@onLogin');
		$events->listen('user.logout', $this->eventPath . 'UserSubscriber@onLogout');
		$events->listen('user.changerole', $this->eventPath . 'UserSubscriber@onChangeRole');
		$events->listen('user.save.settings', $this->eventPath . 'UserSubscriber@onSaveSettings');
	}
}