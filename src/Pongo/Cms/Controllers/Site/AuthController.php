<?php namespace Pongo\Cms\Controllers\Site;

use Pongo\Cms\Controllers\BaseController;
use Pongo\Cms\Services\Managers\SiteManager;

class AuthController extends BaseController {

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
	 * Login a user
	 * @return void
	 */
	public function auth()
	{
		return 'AUTH ACCOMPLISHED!';
	}

}