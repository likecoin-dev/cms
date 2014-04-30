<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Services\Managers\PageManager;

class PageController extends BaseController {

	/**
	 * LoginController constructor
	 */
	public function __construct(PageManager $manager)
	{
		$this->beforeFilter('pongo.auth');
		$this->manager = $manager; 
	}

	/*public function create()
	{
		// $page = $this->manager->withEager('file')->loadPage();
		return \Render::view('sections.page.page');
	}*/

	/*public function deletedPage()
	{
		return \Render::view('sections.page.deleted');
	}*/

	/*public function layoutPage($page_id)
	{
		\Pongo::viewShare('page_id', $page_id);

		$page = $this->page->getPage($page_id);

		$n_elements = $this->page->countPageElements($page);

		$view = \Render::view('sections.page.layout');
		$view['section']	= 'layout';
		$view['page_id'] 	= $page_id;
		$view['name'] 		= $page->name;
		$view['templates']	= \Theme::config('template');
		$view['headers']	= \Theme::config('header');
		$view['layouts']	= \Theme::config('layout');
		$view['footers']	= \Theme::config('footer');

		$view['n_elements'] = $n_elements;
		$view['page_link'] 	= '';

		$view['template_selected'] 	= !empty($page->template) ? $page->template : 'default';
		$view['header_selected'] 	= !empty($page->header) ? $page->header : 'default';
		$view['layout_selected'] 	= !empty($page->layout) ? $page->layout : 'default';
		$view['footer_selected'] 	= !empty($page->footer) ? $page->footer : 'default';

		return $view;
	}*/

	/*public function linkPage()
	{
		
	}*/

	/*public function filesPage($page_id)
	{
		\Pongo::viewShare('page_id', $page_id);

		$page = $this->page->getPage($page_id);

		$n_files = $this->page->countPageFiles($page);

		$view = \Render::view('sections.page.files');
		$view['section']	= 'files';
		$view['page_id'] 	= $page_id;
		$view['name'] 		= $page->name;

		$view['n_files'] 	= $n_files;
		$view['page_link'] 	= '';

		return $view;
	}*/

	/*public function seoPage($page_id)
	{
		\Pongo::viewShare('page_id', $page_id);

		$page = $this->page->getPage($page_id);

		\Pongo::viewShare('page_rels', array_fetch($this->page->getPageRels($page, true), 'id'));

		$n_elements = $this->page->countPageElements($page);

		$view = \Render::view('sections.page.seo');
		$view['section']	= 'seo';
		$view['page_id'] 	= $page_id;
		$view['name'] 		= $page->name;
		$view['title']		= $page->title;
		$view['keyw']		= $page->keyw;
		$view['descr']		= $page->descr;

		$view['n_elements'] = $n_elements;
		$view['page_link'] 	= '';

		return $view;
	}*/

	/**
	 * Show page edit settings
	 * 
	 * @param  int $id
	 * @return string     view page
	 */
	/*public function settingsPage($page_id)
	{
		\Pongo::viewShare('page_id', $page_id);

		$page = $this->page->getPage($page_id);

		\Pongo::viewShare('page_rels', array_fetch($this->page->getPageRels($page, true), 'id'));

		// Available roles
		$roles = $this->role->orderBy('level', 'asc');

		// Role admin array
		$admin_roles = \Access::adminRoles($roles);

		// Count element per page
		$n_elements = $this->page->countPageElements($page);

		$view = \Render::view('sections.page.settings');
		$view['section']		= 'settings';
		$view['page_id'] 		= $page_id;
		$view['name'] 			= $page->name;
		$view['slug_last'] 		= \Tool::slugSlice($page->slug, 1);
		$view['slug_base'] 		= \Tool::slugBack($page->slug, 1);
		$view['slug'] 			= $page->slug;
		$view['is_home'] 		= $page->is_home;
		$view['is_active'] 		= $page->is_active;
		
		$view['access_level'] 	= $page->access_level;
		$view['role_level'] 	= $page->role_level;
		$view['wrapper_id']		= $page->wrapper_id;
		
		$view['roles']			= $roles;
		$view['admin_roles'] 	= $admin_roles;
		$view['wrappers']		= \Pongo::system('wrappers');
		
		$view['n_elements'] 	= $n_elements;
		$view['page_link'] 	= '';

		$view['languages']	= \Pongo::settings('languages');

		return $view;
	}*/

}