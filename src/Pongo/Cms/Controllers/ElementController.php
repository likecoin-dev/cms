<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Support\Repositories\ElementRepositoryInterface as Element;
use Pongo\Cms\Support\Repositories\PageRepositoryInterface as Page;
use Pongo\Cms\Support\Repositories\RoleRepositoryInterface as Role;

class ElementController extends BaseController {

	/**
	 * Class constructor
	 * 
	 * @param Element $element
	 * @param Page    $page
	 * @param Role    $role
	 */
	public function __construct(Element $element, Page $page, Role $role)
	{
		parent::__construct();

		$this->beforeFilter('pongo.auth');

		$this->element 	= $element;
		$this->page 	= $page;
		$this->role 	= $role;
	}

	/**
	 * Show element deleted
	 * 
	 * @return string
	 */
	public function deletedElement()
	{
		return \Render::view('sections.element.deleted');
	}

	/**
	 * Show element content page
	 *
	 * @param  int $page_id   page id
	 * @param  int $element_id   element id
	 * @return string     view page
	 */
	public function contentElement($page_id, $element_id)
	{
		\Pongo::viewShare('page_id', $page_id);
		\Pongo::viewShare('element_id', $element_id);

		$page 		= $this->page->getPage($page_id);
		$element 	= $this->element->getElement($element_id);

		// Count files per page
		$n_files = $this->page->countPageFiles($page);

		$view = \Render::view('sections.element.content');
		$view['section'] 		= 'content';
		$view['page_id'] 		= $page_id;
		$view['element_id'] 	= $element_id;
		$view['name']			= $element->name;
		$view['text']			= $element->text;

		$view['page_link']		= \HTML::link(route('page.settings', array('page_id' => $page->id)), $page->name);

		$view['n_files'] 		= $n_files;

		return $view;
	}

	/**
	 * Show element settings page
	 * 
	 * @param  int $page_id   page id
	 * @param  int $element_id   element id
	 * @return string     view page
	 */
	public function settingsElement($page_id, $element_id)
	{
		
		\Pongo::viewShare('page_id', $page_id);
		\Pongo::viewShare('element_id', $element_id);

		$page 		= $this->page->getPage($page_id);
		$element 	= $this->element->getElement($element_id);

		$view = \Render::view('sections.element.settings');
		$view['section'] 		= 'settings';
		$view['page_id'] 		= $page_id;
		$view['element_id'] 	= $element_id;
		$view['name']			= $element->name;
		$view['attrib']			= $element->attrib;
		$view['zones']			= \Theme::zones($page->layout);
		$view['zone_selected'] 	= $element->zone;		
		$view['is_valid'] 		= $element->is_valid;

		$view['page_link']		= \HTML::link(route('page.settings', array('page_id' => $page->id)), $page->name);

		$view['template_selected'] 	= !empty($page->template) ? $page->template : 'default';
		$view['header_selected'] 	= !empty($page->header) ? $page->header : 'default';
		$view['layout_selected'] 	= !empty($page->layout) ? $page->layout : 'default';
		$view['footer_selected'] 	= !empty($page->footer) ? $page->footer : 'default';

		return $view;
	}

}