<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Support\Repositories\PageRepositoryInterface as Page;
use Pongo\Cms\Support\Repositories\ElementRepositoryInterface as Element;

use Pongo\Cms\Support\Validators\Page\SettingsValidator as SettingsValidator;

class PageController extends ApiController {

	/**
	 * Default order
	 * 
	 * @var int
	 */
	private $default_order;

	/**
	 * Class constructor
	 * @param Page    $page 
	 * @param Element $element
	 */
	public function __construct(Page $page, Element $element)
	{
		parent::__construct();

		$this->page = $page;
		$this->element = $element;

		$this->default_order = \Pongo::system('default_order');
	}

	/**
	 * Set the new LANG constant
	 * 
	 * @return string json encoded object
	 */
	public function changeLang()
	{
		if(\Input::has('lang')) {

			$lang = \Input::get('lang');
			$label = \Pongo::settings('languages.' . $lang . '.lang');

			\Session::put('LANG', $lang);

			$response = array(
				'status' 	=> 'info',
				'msg'		=> t('alert.info.page_lang', array('lang' => $label))
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.page_lang')
			);

		}

		return json_encode($response);
	}

	/**
	 * Create a new page
	 * 
	 * @return string json encoded object
	 */
	public function createPage()
	{
		if(\Input::has('lang')) {

			$lang = \Input::get('lang');
			$name = t('template.page.new', array(), $lang);

			$page_arr = array(
				'parent_id' 	=> 0,
				'lang' 			=> $lang,
				'name' 			=> $name,
				'slug' 			=> '/' . \Str::slug($name),
				'title' 		=> $name,
				'template'		=> 'default',
				'header'		=> 'default',
				'layout'		=> 'default',
				'footer'		=> 'default',
				'author_id' 	=> USERID,
				'access_level' 	=> 0,				
				'role_level' 	=> LEVEL,
				'order_id' 		=> $this->default_order,
				'is_valid' 		=> 0
			);

			$page = $this->page->createPage($page_arr);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.page_created'),
				'id'		=> $page->id,
				'name'		=> $name,
				'url'		=> route('page.settings', array('page_id' => $page->id)),
				'cls'		=> 'new',
				'lang'		=> $lang
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.page_created')
			);

		}

		return json_encode($response);
	}

	/**
	 * Re-order pages on Nestable drag&drop
	 * 
	 * @return string json encoded object
	 */
	public function orderPages()
	{
		if(\Input::has('pages')) {

			$pages = json_decode(\Input::get('pages'), true);

			// Recursive update
			$this->updateOrderRecursivePage($pages, 0);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.page_order')
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.page_order')
			);

		}		

		return json_encode($response);
	}

	/**
	 * Reorder recursive pages
	 * 
	 * @param  array $pages
	 * @param  int $parent
	 * @return void
	 */
	protected function updateOrderRecursivePage($pages, $parent)
	{
		foreach ($pages as $key => $page_arr) {

			// Get page ID
			$page_id = $page_arr['id'];

			// Update pages 1st level
			$page = $this->page->getPage($page_id);
			$page->parent_id = $parent;
			$page->order_id = $key + 1;
			$this->page->savePage($page);

			$page->slug = \Load::pageTree($page->id, 'slug', '/');
			$this->page->savePage($page);

			// Recursive update
			if(array_key_exists('children', $page_arr)) {
				$this->updateOrderRecursivePage($page_arr['children'], $page_id);
			}

		}
	}

	/**
	 * Clone a page with elements and files
	 * 
	 * @return void
	 */
	public function pageSettingsClone()
	{
		if(\Input::has('elements') and \Input::has('page_id')) {

			$elements = \Input::get('elements');

			$self_elements = \Input::get('self_elements');

			$page_id = \Input::get('page_id');

			$lang = \Input::get('lang');

			$page = $this->page->getPage($page_id);

			// Duplicate page
			$new_page_arr = $page->getAttributes();

			// Remove id and time_stamps
			unset($new_page_arr['id'], $new_page_arr['created_at'], $new_page_arr['updated_at']);

			// Set new values
			$new_page_arr['parent_id'] 	= ($lang != $page->lang) ? 0 : $page->parent_id;
			$new_page_arr['name'] 		= $page->name . ' ' . t('label.page.settings.clone');
			$new_page_arr['lang'] 		= $lang;
			$new_page_arr['author_id'] 	= USERID;
			$new_page_arr['role_level'] = LEVEL;
			$new_page_arr['is_home'] 	= 0;
			$new_page_arr['is_valid'] 	= 0;

			// Create new page
			$new_page = $this->page->createPage($new_page_arr);

			// Loop elements id to check which to clone
			foreach ($elements as $element_id) {
				
				$element = $this->element->getElement($element_id);

				if(isset($self_elements[$element_id]) or ($lang != $page->lang)) {

					// Duplicate element
					$new_element_arr = $element->getAttributes();

					// Remove id and time_stamps
					unset($new_element_arr['id'], $new_element_arr['created_at'], $new_element_arr['updated_at']);

					$new_element_arr['lang'] 		= ($lang != $element->lang) ? $lang : $element->lang;
					$new_element_arr['is_valid'] 	= 0;

					$new_element = $this->element->createElement($new_element_arr);

					$new_element = $this->page->savePageElement($new_page, $new_element, $this->default_order);

				} else {

					// Clone element
					$this->element->attachIfNotElementPage($element, $new_page->id, $this->default_order);

				}

			}

			// Clone media
			if(\Input::has('media_all')) {

				foreach ($page->files as $file) {

					$this->page->attachPageFile($new_page, $file->id);
				}

			}

			\Session::put('LANG', $lang);

			\Alert::success(t('alert.success.page_cloned'))->flash();

			return \Redirect::route('page.settings', array('page_id' => $new_page->id));

		} else {

			\Alert::error(t('alert.error.clone_page'))->flash();

			return \Redirect::back();
		}
	}

	/**
	 * Delete a page after a form submission
	 * 
	 * @return void
	 */
	public function pageSettingsDelete()
	{
		if(\Input::has('page_id')) {

			$page_id = \Input::get('page_id');

			$elements = $this->page->getPageElements($page_id);

			$subpages = $this->page->getSubPages($page_id);

			// Check if NOT force delete page

			if(!\Input::has('force_delete')) {

				// Has elements

				if(!is_empty($elements)) {

					\Alert::error(t('alert.error.page_has_elements'))->flash();

					return \Redirect::route('page.settings', array('id' => $page_id));

				// Has subpages

				} elseif(!is_empty($subpages)) {

					\Alert::error(t('alert.error.page_has_subpages'))->flash();

					return \Redirect::route('page.settings', array('id' => $page_id));

				// It's OK, ready to delete

				} else {

					if($this->deletePage($page_id)) {

						\Alert::success(t('alert.success.page_deleted'))->flash();

						return \Redirect::route('page.deleted');
					}

				}

			// Check if IS force delete page checked

			} else {

				// Has subpages

				if(!is_empty($subpages)) {

					\Alert::error(t('alert.error.page_has_subpages'))->flash();

					return \Redirect::route('page.settings', array('id' => $page_id));

				// It's OK, ready to delete

				} else {

					// Loop over elements linked to page
				
					foreach ($elements as $element) {
						
						// Detach element from page
						
						$this->page->deletePageElements($element);

						// Count element owner pages

						$n = $this->element->countElements($element, $element->id);

						// If count = 0, delete element

						if($n == 0) $this->element->getElement($element->id)->delete();

					}

					// Delete page

					if($this->deletePage($page_id)) {

						\Alert::success(t('alert.success.page_deleted'))->flash();

						return \Redirect::route('page.deleted');
					}

				}

			}

		} else {

			\Alert::error(t('alert.error.page_cant_delete'))->flash();

			return \Redirect::route('page.settings', array('id', $page_id));	
		}

	}

	/**
	 * Delete a page
	 * 
	 * @param  int   $page_id page id
	 * @return bool
	 */
	protected function deletePage($page_id)
	{
		$page = $this->page->getPage($page_id);

		//DELETE FILES ASSOCIATION
		$this->page->detachPageFiles($page);

		//DELETE BLOG ASSOCIATIONS
		// $page->blogs()->delete();

		//DELETE PAGE RELATIONS
		// $page->pagerels()->delete();

		//DELETE MENU RELATIONS
		// $page->menus()->delete();

		//DELETE PAGE
		$this->page->deletePage($page);

		return true;
	}

	/**
	 * Change page layout preview
	 * 
	 * @return string html
	 */
	public function pageLayoutChange()
	{
		$input = \Input::all();

		if(!is_empty($input)) {

			return \Render::layoutPreview($input['header'], $input['layout'], $input['footer']);

		}
	}

	public function pageLayoutSave()
	{
		$input = \Input::all();

		if(!is_empty($input)) {

			extract($input);
			
			$page = $this->page->getPage($page_id);

			// Author can edit the page
			if(is_array($unauth = \Access::grantEdit($page->role_level)))
				return json_encode($unauth);

			$page->template = $template;
			$page->header 	= $header;
			$page->layout 	= $layout;
			$page->footer 	= $footer;

			$this->page->savePage($page);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.save'),
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.save'),
			);

		}

		return json_encode($response);
	}

	/**
	 * Save page SEO form
	 * 
	 * @return string json encoded object
	 */
	public function pageSeoSave()
	{
		$input = \Input::all();

		if(!is_empty($input)) {

			extract($input);
			
			$page = $this->page->getPage($page_id);

			// Author can edit the page
			if(is_array($unauth = \Access::grantEdit($page->role_level)))
				return json_encode($unauth);

			$page->title 	= $title;
			$page->keyw 	= $keyw;
			$page->descr 	= $descr;

			$this->page->savePage($page);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.save'),
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.save'),
			);

		}

		return json_encode($response);
	}

	/**
	 * Set/unset link between pages
	 * 
	 * @return json bool
	 */
	public function pageSettingsLink()
	{
		if(\Input::has('rel_id')) {

			$input = \Input::all();

			extract($input);

			$page = $this->page->getPage($page_id);

			if($action == 'add') {
			
				$this->page->attachPageRel($page, $rel_id);

				$reverse = $this->page->getPage($rel_id);

				$this->page->attachPageRel($reverse, $page_id);

			} else {
			
				$this->page->detachPageRel($page, $rel_id);

				$reverse = $this->page->getPage($rel_id);

				$this->page->detachPageRel($reverse, $page_id);

			}

			$response = array(
				'status' 	=> true
			);

		} else {

			$response = array(
				'status' 	=> false
			);

		}

		return json_encode($response);
	}

	/**
	 * Save page settings form
	 * 
	 * @return string json encoded object
	 */
	public function pageSettingsSave()
	{
		$input = \Input::all();

		$v = new SettingsValidator($input['page_id']);

		if($v->passes()) {

			extract($input);
			
			$page = $this->page->getPage($page_id);

			// Author can edit the page
			if(is_array($unauth = \Access::grantEdit($page->role_level)))
				return json_encode($unauth);
			
			$full_slug = $slug_base . '/' . \Str::slug($slug_last);
			$home = isset($is_home) ? 1 : 0;
			$valid = isset($is_valid) ? 1 : 0;

			// Disable all home pages in lang
			if($home == 1) {
				$this->page->resetHomePage();
			}

			$page->name 		= $name;
			$page->slug 		= $full_slug;
			$page->author_id 	= USERID;
			$page->access_level = $access_level;			
			$page->role_level 	= $role_level;
			$page->wrapper_id 	= $wrapper_id;
			$page->is_home 		= $home;
			$page->is_valid 	= $valid;

			$this->page->savePage($page);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.save'),
				'page'		=> array(

					'id' 		=> $page_id,
					'lang'		=> LANG,
					'name'		=> $name,
					'slug'		=> $full_slug,
					'checked' 	=> $valid,
					'home'		=> $home
					
				)
			);


		} else {

			return json_encode($v->formatErrors());

		}

		return json_encode($response);		
	}

}