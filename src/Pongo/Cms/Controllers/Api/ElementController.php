<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Support\Repositories\PageRepositoryInterface as Page;
use Pongo\Cms\Support\Repositories\ElementRepositoryInterface as Element;

use Pongo\Cms\Support\Validators\Element\SettingsValidator as SettingsValidator;

class ElementController extends ApiController {

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
	 * Create a new element
	 * 
	 * @return json object
	 */
	public function createElement()
	{
		if(\Input::has('lang') and \Input::has('page_id')) {

			$page_id = \Input::get('page_id');

			$lang = \Input::get('lang');

			$attrib = t('template.element.new', array(), $lang);

			$element_arr = array(
				'lang' 		=> $lang,
				'attrib' 	=> snake_case($attrib),
				'name' 		=> $attrib,
				'text' 		=> '',
				'zone' 		=> 'ZONE1',
				'author_id' => USERID,
				'is_valid' 	=> 0
			);

			$element = $this->element->createElement($element_arr);

			$page = $this->page->getPage($page_id);

			$new_element = $this->page->savePageElement($page, $element, $this->default_order);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.element_created'),
				'id'		=> $new_element->id,
				'name'		=> $new_element->name,
				'url'		=> route('element.settings', array('page_id' => $page_id, 'element_id' => $new_element->id)),
				'cls'		=> 'new',
				'counter'	=> 'up'
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.element_created')
			);

		}

		return json_encode($response);
	}

	/**
	 * Save element content
	 * 
	 * @return json object
	 */
	public function elementContentSave()
	{
		if(\Input::has('element_id') and \Input::has('page_id')) {

			$page_id 	= \Input::get('page_id');
			$element_id = \Input::get('element_id');			
			$text 		= \Input::get('text');

			$element = $this->element->getElement($element_id);

			$element->text = $text;

			$this->element->saveElement($element);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.save')
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.element_created')
			);

		}

		return json_encode($response);
	}

	/**
	 * Clone one or more elements to page
	 * 
	 * @return void
	 */
	public function elementSettingsClone()
	{
		if(\Input::has('pages') and \Input::has('element_id')) {

			$pages = \Input::get('pages');

			$self_elements = \Input::get('self_elements');

			$element_id = \Input::get('element_id');

			$element = $this->element->getElement($element_id);

			foreach ($pages as $page_id) {
				
				// Check if element is separated
				if(isset($self_elements[$page_id])) {

					// Duplicate element
					$new_element_arr = $element->getAttributes();

					// Remove id and time_stamps
					unset($new_element_arr['id'], $new_element_arr['created_at'], $new_element_arr['updated_at']);

					$new_element_arr['is_valid'] = 0;

					$new_element = $this->element->createElement($new_element_arr);

					$page = $this->page->getPage($page_id);

					$new_element = $this->page->savePageElement($page, $new_element, $this->default_order);
					

				} else {

					// Clone element
					$this->element->attachIfNotElementPage($element, $page_id, $this->default_order);

				}

			}

			\Alert::success(t('alert.success.element_cloned'))->flash();

			return \Redirect::back();

		} else {

			\Alert::error(t('alert.error.clone_element'))->flash();

			return \Redirect::back();
		}

	}

	/**
	 * Detach an element from a page
	 * Delete element if no other page refers to it
	 * 
	 * @return void
	 */
	public function elementSettingsDelete()
	{
		if(\Input::has('page_id') and \Input::has('element_id')) {

			$page_id 	= \Input::get('page_id');

			$element_id = \Input::get('element_id');

			$page = $this->page->getPage($page_id);

			$this->page->detachPageElement($page, $element_id);

			$element = $this->element->getElement($element_id);

			$count_elements = $this->element->countElementPages($element);

			\Alert::success(t('alert.success.element_deleted'))->flash();

			if($count_elements == 0) {

				$this->element->deleteElement($element);

				return \Redirect::route('element.deleted');
			}			

			return \Redirect::route('page.edit', array('page_id' => $page_id));

		} else {

			\Alert::error(t('alert.error.delete_item'))->flash();

			return \Redirect::back();
		}

	}

	/**
	 * Save element settings
	 * 
	 * @return json object
	 */
	public function elementSettingsSave()
	{
		if(\Input::has('element_id') and \Input::has('page_id')) {

			$input = \Input::all();

			$v = new SettingsValidator($input['element_id']);

			if($v->passes()) {

				extract($input);

				$page = $this->page->getPage($page_id);

				// Author can edit the page
				if(is_array($unauth = \Access::grantEdit($page->role_level)))
					return json_encode($unauth);

				$element = $this->element->getElement($element_id);

				$valid = isset($is_valid) ? 1 : 0;
				
				$element->attrib 	= $attrib;
				$element->name 		= $name;
				$element->zone 		= $zone;

				$this->element->saveElement($element);

				$response = array(
					'status' 	=> 'success',
					'msg'		=> t('alert.success.save'),
					'element'	=> array(

						'id' 		=> $element_id,
						'name'		=> $name,
						'checked' 	=> $valid
						
					)
				);

			} else {

				return json_encode($v->formatErrors());

			}

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.save')
			);

		}

		return json_encode($response);	
	}

	/**
	 * Save valid status
	 * 
	 * @return json object
	 */
	public function elementSettingsValid()
	{
		if(\Input::has('item_id') and \Input::has('action')) {

			$element_id 	= \Input::get('item_id');
			$valid 			= \Input::get('action');

			$element = $this->element->getElement($element_id);

			$element->is_valid = $valid;

			$this->element->saveElement($element);

			$response = array(
				'status' 	=> 'success'
			);

		} else {

			$response = array(
				'status' 	=> 'error'
			);
		}

		return json_encode($response);
	}

	/**
	 * Reorder page elements
	 * 
	 * @return string json encoded object
	 */
	public function orderElements()
	{
		if(\Input::has('elements') and \Input::has('page_id')) {

			$mod_elements = json_decode(\Input::get('elements'), true);

			$page_id = \Input::get('page_id');

			$elements = $this->page->getPageElements($page_id);

			// Reorder order id

			foreach ($mod_elements as $key => $el) {

				foreach ($elements as $element) {

					if($element->id == $el['id']) 
						$this->element->updateElementOrder($element, $key + 1);
				}				
			}

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.element_order')
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.element_order')
			);

		}		

		return json_encode($response);
	}

}