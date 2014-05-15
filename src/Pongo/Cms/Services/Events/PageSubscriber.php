<?php namespace Pongo\Cms\Services\Events;

use Session;

class PageSubscriber extends BaseSubscriber {

	/**
	 * [onCreate description]
	 * @param  [type] $page [description]
	 * @return [type]       [description]
	 */
	public function onCreate($page)
	{
		//
	}

	/**
	 * [onDelete description]
	 * @param  [type] $model   [description]
	 * @param  [type] $page_id [description]
	 * @return [type]          [description]
	 */
	public function onDelete($page)
	{
		// Check if block has just one attachment
		foreach ($page->blocks as $block) {
			if(count($block->pages) == 0) {
				// Delete the block if alone
				$block->delete();
			}
		};

		// Detach blocks from page
		$page->blocks()->detach();
		
		// Detach files from page
		$page->files()->detach();
	}

	/**
	 * [onMove description]
	 * @param  [type] $model [description]
	 * @param  [type] $pages [description]
	 * @return [type]        [description]
	 */
	public function onMove($model, $pages)
	{
		$this->updateOrderRecursivePage($model, $pages, 0);
	}

	/**
	 * [onSaveSettings description]
	 * @param  [type] $model [description]
	 * @param  [type] $home  [description]
	 * @return [type]        [description]
	 */
	public function onSaveSettings($model, $home)
	{
		// Reset home Page if checked
		if($home == 1) {
			$model->resetHomePage();
		}
		
	}

	/**
	 * [onSaveLayout description]
	 * @param  [type] $page [description]
	 * @return [type]       [description]
	 */
	public function onSaveLayout($page)
	{
		// 
	}

	/**
	 * [onSaveSeo description]
	 * @param  [type] $page [description]
	 * @return [type]       [description]
	 */
	public function onSaveSeo($page)
	{
		// If title of home page, set as title of empty titles in same lang
	}

	/**
	 * Reorder recursive pages
	 * 
	 * @param  array $pages
	 * @param  int $parent
	 * @return void
	 */
	private function updateOrderRecursivePage($model, $pages, $parent)
	{
		foreach ($pages as $key => $page_arr) {
			// Get page ID
			$page_id = $page_arr['id'];
			// Update pages 1st level
			$page = $model->find($page_id);
			$page->parent_id = $parent;
			$page->order_id = $key + 1;
			$page->save();

			$page->slug = \Load::pageTree($page->id, 'slug', '/');
			$page->save();

			// Recursive update
			if(array_key_exists('children', $page_arr)) {
				$this->updateOrderRecursivePage($model, $page_arr['children'], $page_id);
			}
		}
	}

	/**
	 * [subscribe description]
	 * @param  [type] $events [description]
	 * @return [type]         [description]
	 */
	public function subscribe($events)
	{
		$events->listen('page.create', $this->eventPath . 'PageSubscriber@onCreate');
		$events->listen('page.delete', $this->eventPath . 'PageSubscriber@onDelete');
		$events->listen('page.move',   $this->eventPath . 'PageSubscriber@onMove');
		$events->listen('page.save.settings',   $this->eventPath . 'PageSubscriber@onSaveSettings');
		$events->listen('page.save.layout',   $this->eventPath . 'PageSubscriber@onSaveLayout');
		$events->listen('page.save.seo',   $this->eventPath . 'PageSubscriber@onSaveSeo');
	}
}