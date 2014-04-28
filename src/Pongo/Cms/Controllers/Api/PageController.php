<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\PageManager;

class PageController extends ApiController {

	public function __construct(PageManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager; 
	}

	/**
	 * Create a new empty page
	 * @return [type] [description]
	 */
	public function create()
	{
		if ($this->manager->withInput()->createEmptyPage()) {
			return $this->manager->success();
		}
	}

	/**
	 * Set the new LANG constant
	 * 
	 * @return string json encoded object
	 */
	public function lang()
	{
		if ($this->manager->withInput()->switchLanguage()) {
			return $this->manager->success();
		}
	}

	/**
	 * Move page order
	 * 
	 * @return string json encoded object
	 */
	public function move()
	{
		if ($this->manager->withInput()->movePage()) {
			return $this->manager->success();
		}
	}

	/**
	 * [save description]
	 * @return [type] [description]
	 */
	public function save()
	{
		if ($this->manager->withInput()->savePage()) {
			return $this->manager->success();
		} else {
			return $this->manager->errors();
		}
	}

	/**
	 * [valid description]
	 * @return [type] [description]
	 */
	public function valid()
	{
		if ($this->manager->withInput()->validPage()) {
			return $this->manager->success();
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

			return \Redirect::route('page.edit', array('page_id' => $new_page->id));

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

					return \Redirect::route('page.edit', array('id' => $page_id));

				// Has subpages

				} elseif(!is_empty($subpages)) {

					\Alert::error(t('alert.error.page_has_subpages'))->flash();

					return \Redirect::route('page.edit', array('id' => $page_id));

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

					return \Redirect::route('page.edit', array('id' => $page_id));

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

			return \Redirect::route('page.edit', array('id', $page_id));	
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