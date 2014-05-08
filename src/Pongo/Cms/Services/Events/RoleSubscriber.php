<?php namespace Pongo\Cms\Services\Events;

use Session;

class RoleSubscriber extends BaseSubscriber {

	/**
	 * [onCreate description]
	 * @param  [type] $role [description]
	 * @return [type]       [description]
	 */
	public function onCreate($role)
	{
		// D('Role has been created!');
	}

	/**
	 * [onDelete description]
	 * @param  [type] $role [description]
	 * @return [type]       [description]
	 */
	public function onDelete($role)
	{
		// D('Role has been deleted!'); 
	}

	/**
	 * [onMove description]
	 * @param  [type] $role [description]
	 * @return [type]       [description]
	 */
	public function onMove($role)
	{
		if($role->id == ROLEID) {
			Session::put('LEVEL', $role->level);
		}
	}

	/**
	 * [onSave description]
	 * @param  [type] $role [description]
	 * @return [type]       [description]
	 */
	public function onSave($role)
	{
		if($role->id == ROLEID) {
			Session::put('ROLENAME', $role->name);
		}
	}

	/**
	 * [subscribe description]
	 * @param  [type] $events [description]
	 * @return [type]         [description]
	 */
	public function subscribe($events)
	{
		$events->listen('role.create', $this->eventPath . 'RoleSubscriber@onCreate');
		$events->listen('role.delete', $this->eventPath . 'RoleSubscriber@onDelete');
		$events->listen('role.move',   $this->eventPath . 'RoleSubscriber@onMove');
		$events->listen('role.save',   $this->eventPath . 'RoleSubscriber@onSave');
	}
}