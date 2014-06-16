<?php namespace Pongo\Cms\Services\Events;

use Session;

class BlockSubscriber extends BaseSubscriber {

	/**
	 * [onCopy description]
	 * @param  [type] $block [description]
	 * @return [type]        [description]
	 */
	public function onCopy($block)
	{
		// 
	}

	/**
	 * [onCreate description]
	 * @param  [type] $block   [description]
	 * @param  [type] $page_id [description]
	 * @return [type]          [description]
	 */
	public function onCreate($block, $page_id, $zone)
	{
		// Add record to pivot table 'block_page'
		$block->pages()->attach($page_id, array(
			'zone'		=> $zone,
			'order_id'	=> \Pongo::system('default_order'),
			'is_active' => 0
		));		
	}

	/**
	 * [onDelete description]
	 * @param  [type] $block   [description]
	 * @param  [type] $page_id [description]
	 * @return [type]          [description]
	 */
	public function onDelete($block, $page_id)
	{
		// Delete block if not attached to other zones
		if(count($block->pages) == 0) {
			$block->delete();
		}
	}

	/**
	 * [onMove description]
	 * @param  [type] $blocks [description]
	 * @return [type]         [description]
	 */
	public function onMove($blocks)
	{

	}

	/**
	 * [onSaveSettings description]
	 * @param  [type] $block [description]
	 * @return [type]        [description]
	 */
	public function onSaveSettings($block)
	{
		// 
	}

	/**
	 * [onSaveContent description]
	 * @param  [type] $block [description]
	 * @return [type]        [description]
	 */
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
		$events->listen('block.copy', $this->eventPath . 'BlockSubscriber@onCopy');
		$events->listen('block.create', $this->eventPath . 'BlockSubscriber@onCreate');
		$events->listen('block.delete', $this->eventPath . 'BlockSubscriber@onDelete');
		$events->listen('block.move',   $this->eventPath . 'BlockSubscriber@onMove');
		$events->listen('block.save.settings',   $this->eventPath . 'BlockSubscriber@onSaveSettings');
		$events->listen('block.save.content',   $this->eventPath . 'BlockSubscriber@onSaveContent');
	}
}