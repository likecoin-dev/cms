<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Pongo\Cms\Services\Validators\LoginValidator as Validator;
use Pongo\Cms\Repositories\PageRepositoryInterface as Page;

class PageManager extends BaseManager implements PageManagerInterface {

	public function __construct(Access $access, Validator $validator, Page $page)
	{
		$this->access = $access;
		$this->validator = $validator;
		$this->model = $page;
	}

	/**
	 * Change page insert language
	 * @return json object
	 */
	public function switchLanguage()
	{
		$lang = $this->input['lang'];
		$label = \Pongo::settings('languages.' . $lang . '.lang');
		\Session::put('LANG', $lang);
		$this->setSuccess('alert.info.page_lang', array('lang' => $label));
		return true;
	}

	/**
	 * Move page in page tree
	 * @return json object
	 */
	public function move()
	{
		
	}

}