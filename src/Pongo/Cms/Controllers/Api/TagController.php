<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\TagManager;

class TagController extends ApiController {

	public function __construct(TagManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager;
	}

	/**
	 * [list description]
	 * @return [type] [description]
	 */
	public function index()
	{
		return $this->manager->withSimpleInput()->getTags();		
	}

}