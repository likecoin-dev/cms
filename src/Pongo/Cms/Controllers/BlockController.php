<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Services\Managers\BlockManager;

class BlockController extends BaseController {

	/**
	 * LoginController constructor
	 */
	public function __construct(BlockManager $manager)
	{
		$this->beforeFilter('pongo.auth');
		$this->beforeFilter('pongo.access:pages');
		$this->manager = $manager; 
	}

	/**
	 * [edit description]
	 * @return [type] [description]
	 */
	public function edit($page_id, $block_id)
	{
		\Pongo::viewShare('page_id', $page_id);
		\Pongo::viewShare('block_id', $block_id);
		
		$block = $this->manager->getBlock($block_id);
		
		return \Render::view('sections.blocks.edit', array('block' => $block));
	}

}