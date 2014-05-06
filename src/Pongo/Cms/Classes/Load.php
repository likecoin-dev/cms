<?php namespace Pongo\Cms\Classes;

use Pongo\Cms\Repositories\FileRepositoryInterface as File;
use Pongo\Cms\Repositories\PageRepositoryInterface as Page;
use Pongo\Cms\Repositories\RoleRepositoryInterface as Role;

class Load {

	protected $file;
	
	protected $page;

	/**
	 * Render constructor
	 */
	public function __construct(File $file, Page $page, Role $role)
	{
		$this->file = $file;
		$this->page = $page;
		$this->role = $role;
	}

	/**
	 * Render element form
	 * 
	 * @param  int $page_id     active page id
	 * @return string           page item view
	 */
	public function elementForm($page_id)
	{
		$items = $this->page->getPageElements($page_id);

		$item_view = \Render::view('partials.items.elementform');
		$item_view['items'] 	= $items;
		$item_view['page_id'] 	= $page_id;
		
		return $item_view;
	}

	/**
	 * Create element list by page_id
	 * 
	 * @param  int $page_id    page id
	 * @param  int $element_id    element id
	 * @return string      element item view
	 */
	public function elementList($page_id, $element_id = 0)
	{
		$items = $this->page->getPageElements($page_id);

		$item_view = \Render::view('partials.items.elementitem');
		$item_view['items'] 		= $items;
		$item_view['element_id'] 	= $element_id;

		return $item_view;
	}

	/**
	 * Create file list by page_id
	 * 
	 * @param  int     $page_id    page id
	 * @param  string  $action     insert | edit
	 * @return string              file item view
	 */
	public function fileList($page_id, $action = 'edit')
	{
		$file = $this->file;
		$page = $this->page;

		$items = ($page_id == 0) ? $file->getFiles() : $page->getPageFiles($page_id);

		$item_view = \Render::view('partials.items.fileitem');
		$item_view['items']		= $items;
		$item_view['action']	= $action;

		return $item_view;
	}

	/**
	 * Create marker list
	 * 
	 * @return string
	 */
	public function markerList()
	{
		$items = \Pongo::markers();

		$item_view = \Render::view('partials.items.markeritem');
		$item_view['items'] = $items;

		return $item_view;
	}

	/**
	 * Render page form
	 * 
	 * @param  int $parent_id 	pages's parent id
	 * @param  string $lang 	available languages
	 * @param  int $page_id     active page id
	 * @return string           page item view
	 */
	public function pageForm($parent_id, $lang, $page_id = 0)
	{
		$items = $this->page->getPageList($parent_id, $lang);

		$item_view = \Render::view('partials.items.pageform');
		$item_view['items'] 	= $items;
		$item_view['page_id'] 	= $page_id;
		$item_view['parent_id'] = $parent_id;

		return $item_view;
	}

	/**
	 * Render page list recursively
	 * 
	 * @param  int $parent_id 	pages's parent id
	 * @param  string $lang 	available languages
	 * @param  int $page_id     active page id
	 * @return string           page item view
	 */
	public function pageList($parent_id, $lang, $page_id = 0, $partial = 'pageitem')
	{
		$items = $this->page->getPageList($parent_id, $lang);
		
		$item_view = \Render::view('partials.items.' . $partial);
		$item_view['count'] 	= count($items);
		$item_view['items'] 	= $items;
		$item_view['page_id'] 	= $page_id;
		$item_view['parent_id'] = $parent_id;
		$item_view['partial'] 	= $partial;

		return $item_view;
	}

	/**
	 * Create a back recursive site structure of pages
	 * 
	 * @param  int     $id        page id
	 * @param  string  $field     db column to target
	 * @param  string  $separator optional separator
	 * @param  boolean $url       create a url string
	 * @param  boolean $link      make each chunk linkable to its url
	 * @param  string  $context   site or cms context
	 * @return string
	 */
	public function pageTree($id, $field = 'slug', $separator = '', $url = false, $link = false, $context = 'cms')
	{
		if($url) {
			$field = 'slug';
			$separator = '/';
		}

		$str = $this->recursivePageTree($id, $field, $separator, $url, $link, $context);

		$result =  ($url and !$link) ? url($str) : $str;

		return $result;
	}
	
	/**
	 * Recursive process of pageTree method
	 * 
	 * @param  int     $id        page id
	 * @param  string  $field     db column to target
	 * @param  string  $separator optional separator
	 * @param  boolean $url       create a url string
	 * @param  boolean $link      make each chunk linkable to its url
	 * @param  string  $context   site or cms context
	 * @return string
	 */
	protected function recursivePageTree($id, $field, $separator, $url, $link, $context)
	{
		$page = $this->page->find($id);
		if($field == 'slug') {			
			$separator = '';
			$slug_arr = explode('/', $page->$field);
			$page_field = '/' . end($slug_arr);
		} else {
			$page_field = $page->$field;
		}

		if($context == 'cms') {
			$slug = link_to_cms('page/edit/' . $page->id, $page_field);
		} else {
			$slug = link_to($page->slug, $page_field);
		}

		if($page->parent_id == 0) {
			$str = ($link and !$url) ? $slug : $page_field;
		} else {
			if($link and !$url) {
				$str = $this->recursivePageTree($page->parent_id, $field, $separator, $url, $link, $context) . $separator . $slug;
			} else {
				$str = $this->recursivePageTree($page->parent_id, $field, $separator, $url, $link, $context) . $separator . $page_field;
			}
		}
		return $str;				  
	}

	/**
	 * Render role list
	 * 
	 * @return string           page item view
	 */
	public function roleList($user, $partial = 'roleitem')
	{
		$items = $this->role->getActiveRolesList();
		
		$item_view = \Render::view('partials.items.' . $partial);
		$item_view['items'] = $items;
		$item_view['user'] 	= $user;

		return $item_view;
	}

}