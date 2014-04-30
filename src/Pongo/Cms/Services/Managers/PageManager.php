<?php namespace Pongo\Cms\Services\Managers;

use Carbon\Carbon;
use Pongo\Cms\Classes\Access;
use Pongo\Cms\Services\Validators\PageValidator as Validator;
use Pongo\Cms\Repositories\PageRepositoryInterface as Page;

class PageManager extends BaseManager {

	public function __construct(Access $access, Validator $validator, Page $page)
	{
		$this->access = $access;
		$this->validator = $validator;
		$this->model = $page;
	}

	/**
	 * Create a new empty page
	 * @return bool
	 */
	public function createEmptyPage()
	{
		if($this->input) {
			$lang = $this->input['lang'];
			$timedate = Carbon::now()->format('H:i:s - Ymd');
			$name = t('template.created', array('timedate' => $timedate), $lang);
			$msg = t('alert.success.page_created');
			
			$default_page = array(
				'author_id' 	=> USERID,
				'parent_id' 	=> 0,
				'lang' 			=> $lang,
				'name' 			=> $name,
				'slug' 			=> '/' . \Str::slug($name),
				'template'		=> 'default',
				'header'		=> 'default',
				'layout'		=> 'default',
				'footer'		=> 'default',
				'access_level' 	=> 0,
				'role_level' 	=> LEVEL,
				'order_id'		=> DEFORDER,
			);

			$page = $this->model->create($default_page);

			$response = array(
				'render'	=> 'page',
				'status' 	=> 'success',
				'msg'		=> $msg,
				'id'		=> $page->id,
				'name'		=> $name,
				'url'		=> route('page.edit', array('page_id' => $page->id)),
				'cls'		=> 'new',
				'lang'		=> $lang
			);

			return $this->setSuccess($response);
		}
	}

	/**
	 * Move page in page tree
	 * @return json object
	 */
	public function movePage()
	{
		$pages = get_json('items');
		$this->updateOrderRecursivePage($pages, 0);
		return $this->setSuccess('alert.success.page_order');
	}

	/**
	 * [loadPage description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function loadPage($id = null)
	{
		return $this->model->findOrNew($id);
	}

	/**
	 * [savePage description]
	 * @return [type] [description]
	 */
	public function savePage()
	{
		if ($this->validator->fails()) {			
			return $this->setError($this->validator->errors());
		} else {
			return $this->setSuccess('alert.success.page_created');
		}
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
		return $this->setSuccess('alert.info.page_lang', array('lang' => $label));
	}

	/**
	 * [validPage description]
	 * @return [type] [description]
	 */
	public function validPage()
	{
		$page_id = $this->input['item_id'];
		$value = $this->input['action'];
		$page = $this->model->find($page_id);
		$page->is_active = $value;
		$page->save();
		return $this->setSuccess('alert.success.page_modified');
	}

	/**
	 * Reorder recursive pages
	 * 
	 * @param  array $pages
	 * @param  int $parent
	 * @return void
	 */
	private function updateOrderRecursivePage($pages, $parent)
	{
		foreach ($pages as $key => $page_arr) {
			// Get page ID
			$page_id = $page_arr['id'];
			// Update pages 1st level
			$page = $this->model->find($page_id);
			$page->parent_id = $parent;
			$page->order_id = $key + 1;
			$page->save();

			$page->slug = \Load::pageTree($page->id, 'slug', '/');
			$page->save();

			// Recursive update
			if(array_key_exists('children', $page_arr)) {
				$this->updateOrderRecursivePage($page_arr['children'], $page_id);
			}
		}
	}

}