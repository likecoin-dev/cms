<?php namespace Pongo\Cms\Services\Events;

use Session;

class UserSubscriber {

	private $eventPath = 'Pongo\Cms\Services\Events\\';

	public function onCreate($user)
	{
		// D('User has been created!');
	}

	public function onDelete($user)
	{
		// D('User has been deleted!'); 
	}

	public function onLogin($user, $cmslang)
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
		Session::put('CMSLANG', ($cmslang) ?: $user->lang);
	}

	public function onLogout($user)
	{
		// D('User has been logged out!', true); 
	}

	public function subscribe($events)
	{
		$events->listen('user.create', $this->eventPath . 'UserSubscriber@onCreate');
		$events->listen('user.delete', $this->eventPath . 'UserSubscriber@onDelete');
		$events->listen('user.login',  $this->eventPath . 'UserSubscriber@onLogin');
		$events->listen('user.logout', $this->eventPath . 'UserSubscriber@onLogout');
	}
}