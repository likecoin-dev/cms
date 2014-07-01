<?php namespace Pongo\Cms\Classes;

use Pongo\Cms\Repositories\FileRepositoryInterface as File;
use Pongo\Cms\Repositories\PageRepositoryInterface as Page;
use Pongo\Cms\Repositories\RoleRepositoryInterface as Role;

class Load {

	protected $file;
	
	protected $page;

	protected $role;

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
	 * Render block form in copy modal
	 * 
	 * @param  int $page_id     active page id
	 * @return string           page item view
	 */
	public function blockForm($page_id)
	{
		$items = $this->page->find($page_id);

		$item_view = \Render::view('partials.items.blockform');
		$item_view['items'] 	= $items->blocks;
		$item_view['page_id'] 	= $page_id;
		
		return $item_view;
	}

	/**
	 * [blockList description]
	 * @param  [type] $page_id  [description]
	 * @param  [type] $block_id [description]
	 * @param  [type] $zone     [description]
	 * @return [type]           [description]
	 */
	public function blockList($page_id, $block_id, $zone)
	{
		if($block_id)
		{
			$items = $this->page->getPageZoneBlocks($page_id, $zone);

			$item_view = \Render::view('partials.items.blockitem');
			$item_view['items'] 	= $items->blocks;
			$item_view['page_id'] 	= $page_id;
			$item_view['block_id'] 	= $block_id;
			
			return $item_view;
		}
	}

	/**
	 * [blockZones description]
	 * @param  [type] $page_id  [description]
	 * @param  [type] $block_id [description]
	 * @param  [type] $zone     [description]
	 * @param  string $name     [description]
	 * @param  string $id       [description]
	 * @return [type]           [description]
	 */
	public function blockZones($page_id, $block_id, $zone, $name = 'change-zone', $id = 'change-zone')
	{
		if($block_id)
		{
			$layout = $this->page->find($page_id)->layout;

			$zones = \Theme::zones($layout);

			return \Form::select($name, $zones, $zone, array(
				'id' => $id,
				'data-page' => $page_id,
				'class' => 'form-control'
			));
		}
	}

	/**
	 * [breadCrumb description]
	 * @param  [type] $routes [description]
	 * @param  [type] $last   [description]
	 * @return [type]         [description]
	 */
	public function breadCrumb($routes, $last = null)
	{
		$breadcrumb_view = \Render::view('partials.breadcrumb');
		$breadcrumb_view['sections'] = \Pongo::flattenSections();

		// Get page model if exists
		if(array_key_exists('page', $routes))
		{
			$page = $this->page->find($routes['page']);
			$breadcrumb_view['page'] = $page;
			unset($routes['page']);

			// Get zone if exists page
			if(array_key_exists('zone', $routes))
			{
				$breadcrumb_view['zone'] = \Theme::zoneName($page->layout, $routes['zone']);
				unset($routes['zone']);
			}

		}

		$breadcrumb_view['routes'] = $routes;
		$breadcrumb_view['last'] = $last;

		return $breadcrumb_view;
	}

	/**
	 * Create file list by page_id
	 * 
	 * @param  int     $page_id    page id
	 * @return string              file item view
	 */
	public function fileList($page_id)
	{
		$files = $this->file->getFilesPage($page_id);

		$item_view = \Render::view('partials.items.fileitem');
		$item_view['items']	= $files;

		return $item_view;
	}

	/**
	 * [layoutPreview description]
	 * @param  [type] $page_id [description]
	 * @param  [type] $page    [description]
	 * @param  [type] $checked_zone [description]
	 * @param  string $size    [description]
	 * @return [type]          [description]
	 */
	public function layoutPreview($page_id, $page = null, $checked_zone = null, $print_name = true, $size = 'big')
	{
		if( ! $page) $page = $this->page->find($page_id);

		$layout_view = \Render::view('partials.layout.preview');
		$layout_view['toggle_class'] = ($print_name) ? 'pongo-blocks-loading' : 'options-toggle';
		$layout_view['checked_zone'] = $checked_zone;
		$layout_view['print_name'] = $print_name;
		$layout_view['template'] = $page['template'];
		$layout_view['header'] = $page['header'];
		$layout_view['layout'] = $page['layout'];
		$layout_view['footer'] = $page['footer'];
		$layout_view['size'] = $size;

		return $layout_view;
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
		// Get page
		$page = $this->page->find($id);

		if($field == 'slug')
		{
			$separator = '';

			$slug_arr = explode('/', $page->seo()->first()->$field);

			$page_field = '/' . end($slug_arr);
		}
		else
		{
			$page_field = $page->$field;
		}

		if($context == 'cms')
		{
			$slug = link_to_cms('page/edit/' . $page->id, $page_field);
		}
		else
		{
			$slug = link_to($page->slug, $page_field);
		}

		if($page->parent_id == 0)
		{
			$str = ($link and !$url) ? $slug : $page_field;
		}
		else
		{
			if($link and !$url)
			{
				$str = $this->recursivePageTree($page->parent_id, $field, $separator, $url, $link, $context) . $separator . $slug;
			}
			else
			{
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
		$items = $this->role->getActiveUsersRolesList();
		
		$item_view = \Render::view('partials.items.' . $partial);
		$item_view['items'] = $items;
		$item_view['user'] 	= $user;

		return $item_view;
	}

	/**
	 * [roleListArray description]
	 * @param  string  $filter  [description]
	 * @param  boolean $reverse [description]
	 * @return [type]           [description]
	 */
	public function roleListArray($filter = 'all', $reverse = false, $above = false)
	{
		switch ($filter)
		{
			case 'editors':
				$roles = $this->role->getActiveEditorRolesList();
				break;
			case 'users':
				$roles = $this->role->getActiveUsersRolesList();
				break;
			default:
				$roles = $this->role->getActiveRolesList();
				break;
		}

		$role_list = array();

		foreach ($roles as $role)
		{
			$role_list[$role->level] = ucfirst($role->name);

			if($above and $role->level < $roles->max('level'))
			{
				$role_list[$role->level] .= ' ' . t('form.select.or_above');
			}
		}

		return $reverse ? array_reverse($role_list, true) : $role_list;
	}

}