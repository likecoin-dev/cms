<?php namespace Pongo\Cms\Services\Events;

class TagSubscriber extends BaseSubscriber {

	/**
	 * [onCreate description]
	 * @param  [type] $tag [description]
	 * @return [type]      [description]
	 */
	public function onCreate($tag)
	{
		// D('Role has been created!');
	}

	/**
	 * [onDelete description]
	 * @param  [type] $tag [description]
	 * @return [type]      [description]
	 */
	public function onDelete($tag)
	{
		//
	}

	/**
	 * [onMove description]
	 * @param  [type] $tag [description]
	 * @return [type]      [description]
	 */
	public function onMove($tag)
	{
		// 
	}

	/**
	 * [onSave description]
	 * @param  [type] $tag [description]
	 * @return [type]      [description]
	 */
	public function onSave($tag)
	{
		// 
	}

	/**
	 * [subscribe description]
	 * @param  [type] $events [description]
	 * @return [type]         [description]
	 */
	public function subscribe($events)
	{
		$events->listen('tag.create', $this->eventPath . 'TagSubscriber@onCreate');
		$events->listen('tag.delete', $this->eventPath . 'TagSubscriber@onDelete');
		$events->listen('tag.move',   $this->eventPath . 'TagSubscriber@onMove');
		$events->listen('tag.save',   $this->eventPath . 'TagSubscriber@onSave');
	}
}