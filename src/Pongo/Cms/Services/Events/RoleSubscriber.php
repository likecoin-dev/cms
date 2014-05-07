<?php namespace Pongo\Cms\Services\Events;

class RoleSubscriber {

	public function onCreate($role)
	{
		// D('Role has been created!');
	}

	public function onDelete($role)
	{
		// D('Role has been deleted!'); 
	}

	public function subscribe($events)
	{
		$events->listen('role.create', 'RoleSubscriber@onCreate');
		$events->listen('role.delete', 'RoleSubscriber@onDelete');
	}
}