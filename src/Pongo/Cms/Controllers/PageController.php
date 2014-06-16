<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Services\Managers\PageManager;

class PageController extends BaseController {

	/**
	 * LoginController constructor
	 */
	public function __construct(PageManager $manager)
	{
		$this->beforeFilter('pongo.auth');
		$this->beforeFilter('pongo.access:pages');
		$this->manager = $manager; 
	}

	/**
	 * [edit description]
	 * @return [type] [description]
	 */
	public function edit($page_id)
	{
		\Pongo::viewShare('page_id', $page_id);

		$page = $this->manager->getOne($page_id);
		
		return \Render::view('sections.pages.edit', array('page' => $page));
	}

}