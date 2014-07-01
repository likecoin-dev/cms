<?php namespace Pongo\Cms\Services\Events;

use Session;

class PageSubscriber extends BaseSubscriber {

	/**
	 * [onCopy description]
	 * @param  [type] $page [description]
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function onCopy($old, $page, $slug)
	{
		// Set LANG as $page->lang
		Session::put('LANG', $page->lang);

		$page->seo()->create(array('slug' => $slug));
	}

	/**
	 * [onCreate description]
	 * @param  [type] $page [description]
	 * @return [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function onCreate($page, $slug)
	{
		$page->seo()->create(
			array(
				'lang' => $page->lang,
				'slug' => $slug
			)
		);
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

		// Delete seo from page
		$page->seo()->delete();

		// Detach blocks from page
		$page->blocks()->detach();
		
		// Detach files from page
		$page->files()->detach();

		// Detach tags from page
		$page->tags()->detach();
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
	public function onSaveSettings($model, $home, $page, $slug)
	{
		// Reset home Page if checked
		if($home == 1) {
			$model->resetHomePage($page->id);
		}

		$new_slug = \Tool::slugSubst($page->seo->first()->slug, $slug);

		// Update the new slug
		$page->seo()->update(array('slug' => $new_slug));
		
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
	 * @param  [type] $tags [description]
	 * @return [type]       [description]
	 */
	public function onSaveSeo($page, $tags)
	{
		if(is_array($tags))
		{
			$old_tags = array();			
			$new_tags = array();
			
			// Get old and new values
			foreach ($tags as $value)
			{
				if(is_numeric($value))
				{
					$old_tags[] = $value;
				}
				else
				{
					$new_tags[] = $value;
				}
			}

			// Sync old values
			$page->tags()->sync($old_tags);

			// Get Tag model
			// $tag = \App::make('Pongo\Cms\Models\Tag');
			$tag = \App::make('Pongo\Cms\Repositories\TagRepositoryInterface');

			// Loop new tags, insert them in 'tags' and attach them to page
			foreach ($new_tags as $new_tag)
			{
				$tag_created = $tag->create(array('lang' => LANG, 'name' => $new_tag));

				$page->tags()->save($tag_created);
			}
		}
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

			$new_slug = \Load::pageTree($page->id, 'slug', '/');
			$page->seo()->update(array('slug' => $new_slug));

			// Recursive update
			if(array_key_exists('children', $page_arr))
			{
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
		$events->listen('page.copied', $this->eventPath . 'PageSubscriber@onCopy');
		$events->listen('page.create', $this->eventPath . 'PageSubscriber@onCreate');
		$events->listen('page.delete', $this->eventPath . 'PageSubscriber@onDelete');
		$events->listen('page.move',   $this->eventPath . 'PageSubscriber@onMove');
		$events->listen('page.save.settings',   $this->eventPath . 'PageSubscriber@onSaveSettings');
		$events->listen('page.save.layout',   $this->eventPath . 'PageSubscriber@onSaveLayout');
		$events->listen('page.save.seo',   $this->eventPath . 'PageSubscriber@onSaveSeo');
	}
}