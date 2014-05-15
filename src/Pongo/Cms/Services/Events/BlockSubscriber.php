<?php namespace Pongo\Cms\Services\Events;

use Session;

class BlockSubscriber extends BaseSubscriber {


	public function onCreate($block, $page_id)
	{
		// Add record to pivot table 'block_page'
		$block->pages()->attach($page_id, array('order_id' => \Pongo::system('default_order'), 'is_active' => 0));		
	}


	public function onDelete($block, $page_id)
	{
		// Delete block if not attached to other zones
		if(count($block->pages) == 0) {
			$block->delete();
		}
	}


	public function onMove($blocks)
	{

	}


	public function onSaveSettings($block)
	{
		// 
	}


	public function onSaveContent($block)
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
		$events->listen('block.create', $this->eventPath . 'BlockSubscriber@onCreate');
		$events->listen('block.delete', $this->eventPath . 'BlockSubscriber@onDelete');
		$events->listen('block.move',   $this->eventPath . 'BlockSubscriber@onMove');
		$events->listen('block.save.settings',   $this->eventPath . 'BlockSubscriber@onSaveSettings');
		$events->listen('block.save.content',   $this->eventPath . 'BlockSubscriber@onSaveLayout');
	}
}