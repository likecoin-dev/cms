<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\PageManager;

class PageController extends ApiController {

	public function __construct(PageManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager; 
	}

	/**
	 * [changeLayout description]
	 * @return [type] [description]
	 */
	public function changeLayout()
	{
		$layout = \Input::get('layout');
		
		return \Render::layoutPreview($layout);
	}

	/**
	 * Create a new empty page
	 * @return [type] [description]
	 */
	public function create()
	{
		if ($this->manager->withInput()->createEmptyPage()) {
			
			return $this->manager->success();
		}
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		if ($this->manager->withInput()->deletePage()) {
			
			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * Set the new LANG constant
	 * 
	 * @return string json encoded object
	 */
	public function lang()
	{
		if ($this->manager->withInput()->switchLanguage()) {

			return $this->manager->success();
		}
	}

	/**
	 * [loadBlocks description]
	 * @return [type] [description]
	 */
	public function loadBlocks()
	{
		return $this->manager->withInput()->loadBlocks();
	}

	/**
	 * Move page order
	 * 
	 * @return string json encoded object
	 */
	public function move()
	{
		if ($this->manager->withInput()->movePage()) {

			return $this->manager->success();
		}
	}

	/**
	 * Move blocks order
	 * 
	 * @return string json encoded object
	 */
	public function moveBlocks()
	{
		if ($this->manager->withInput()->moveBlock()) {

			return $this->manager->success();
		}
	}

	/**
	 * [saveSettings description]
	 * @return [type] [description]
	 */
	public function saveSettings()
	{
		if ($this->manager->withInput('id', 'lang')->savePageSettings()) {
			
			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * [saveLayout description]
	 * @return [type] [description]
	 */
	public function saveLayout()
	{
		if ($this->manager->withInput()->savePageLayout()) {

			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * [saveSeo description]
	 * @return [type] [description]
	 */
	public function saveSeo()
	{
		if ($this->manager->withInput()->savePageSeo()) {

			return $this->manager->success();

		} else {

			return $this->manager->errors();
		}
	}

	/**
	 * [valid description]
	 * @return [type] [description]
	 */
	public function valid()
	{
		if ($this->manager->withInput()->validPage()) {

			return $this->manager->success();
		}
	}

}