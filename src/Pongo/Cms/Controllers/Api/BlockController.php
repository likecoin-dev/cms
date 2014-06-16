<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\BlockManager;

class BlockController extends ApiController {

	public function __construct(BlockManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager; 
	}

	/**
	 * Clone a block
	 * @return [type] [description]
	 */
	public function copy()
	{
		if ($this->manager->withSimpleInput()->copyBlock())
		{
			return $this->manager->success();
		}
	}

	/**
	 * Create a new empty page
	 * @return [type] [description]
	 */
	public function create()
	{
		if ($this->manager->withInput()->createEmptyBlock())
		{
			return $this->manager->success();
		}
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		if ($this->manager->withInput()->deleteBlock())
		{			
			return $this->manager->success();
		}
		else
		{
			return $this->manager->errors();
		}
	}

	/**
	 * [saveSettings description]
	 * @return [type] [description]
	 */
	public function saveSettings()
	{
		if ($this->manager->withInput('id')->saveBlockSettings())
		{
			return $this->manager->success();
		}
		else
		{
			return $this->manager->errors();
		}
	}

	/**
	 * [saveSeo description]
	 * @return [type] [description]
	 */
	public function saveContent()
	{
		if ($this->manager->withInput()->saveBlockContent())
		{
			return $this->manager->success();
		}
		else
		{
			return $this->manager->errors();
		}
	}

	/**
	 * [valid description]
	 * @return [type] [description]
	 */
	public function valid()
	{
		if ($this->manager->withInput()->validBlock())
		{			
			return $this->manager->success();
		}
	}

}