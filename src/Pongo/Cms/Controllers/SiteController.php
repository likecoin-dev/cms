<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Services\Managers\SiteManager;

class SiteController extends BaseController {

	/**
	 * [$manager description]
	 * @var [type]
	 */
	protected $manager;

	/**
	 * [__construct description]
	 * @param SiteManager $manager [description]
	 */
	public function __construct(SiteManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * Front-end access to pages
	 * @param  [type] $uri [description]
	 * @return [type]      [description]
	 */
	public function renderPage($uri)
	{
		if($this->manager->publicPage($uri))
		{
			return $this->manager->showPage();
		}
		else
		{
			return $this->manager->authPage();
		}
	}

	/**
	 * Detect the right page to render
	 * @return mixed Page object
	 */
	private function detectPage()
	{

	}

}