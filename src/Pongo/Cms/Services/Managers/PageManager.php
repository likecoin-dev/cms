<?php namespace Pongo\Cms\Services\Managers;

use Carbon\Carbon;
use Pongo\Cms\Classes\Access;
use Illuminate\Events\Dispatcher as Events;
use Pongo\Cms\Services\Validators\PageValidator as Validator;
use Pongo\Cms\Repositories\PageRepositoryInterface as Page;

class PageManager extends BaseManager {

	public function __construct(Access $access, Events $events, Validator $validator, Page $page)
	{
		$this->access = $access;
		$this->events = $events;
		$this->validator = $validator;
		$this->model = $page;

		$this->section = 'pages';
	}

	public function copyPage()
	{
		if($check = $this->canEdit()) {

			if($this->input) {

				$page_id = $this->input['page_id'];
				$copy_lang = $this->input['copy_lang'];
				$file_all = isset($this->input['file_all']) ? true : false;
				$blocks = isset($this->input['blocks']) ? $this->input['blocks'] : null;
				$self_blocks = isset($this->input['self_block']) ? $this->input['self_block']: null;

				// Duplicate page
				$page = $this->model->find($page_id);
				$new_page_arr = $page->getAttributes();

				// Clean some unwanted attributes
				unset($new_page_arr['id'], $new_page_arr['created_at'], $new_page_arr['updated_at']);

				$new_page_name = t('label.page.settings.copy_of') . ' ' . $page->name;
				$new_page_slug = \Tool::slugSubst($page->slug, \Str::slug($new_page_name));

				// Overriding with new values
				$new_page_arr['parent_id'] 	= ($copy_lang != $page->lang) ? 0 : $page->parent_id;
				$new_page_arr['name'] 		= $new_page_name;
				$new_page_arr['slug'] 		= $new_page_slug;
				$new_page_arr['lang'] 		= $copy_lang;
				$new_page_arr['author_id'] 	= USERID;
				$new_page_arr['edit_level'] = LEVEL;
				$new_page_arr['is_home'] 	= 0;
				$new_page_arr['is_active'] 	= 0;

				// Create the new page
				$new_page = $this->model->create($new_page_arr);

				// Copy all related tags
				foreach ($page->tags as $tag)
				{
					$new_page->tags()->attach($tag->id);
				}

				// Proceed with blocks
				if($blocks) {

					// Get Block model
					$block_model = \App::make('Pongo\Cms\Models\Block');

					foreach ($blocks as $block_id) {
						
						// Get the block to copy
						$block = $block_model->find($block_id);

						// If block is independent or not in the same language
						if(isset($self_blocks[$block_id]) or ($copy_lang != $page->lang)) {

							// Duplicate block
							$new_block_arr = $block->getAttributes();

							// Remove unwanted items
							unset($new_block_arr['id'], $new_block_arr['created_at'], $new_block_arr['updated_at']);

							// Overriding with new values
							$new_block_arr['lang'] = ($copy_lang != $block->lang) ? $copy_lang : $block->lang;

							// Create new block
							$new_block = $block_model->create($new_block_arr);

							// Attach to pivot
							$new_page->blocks()->save($new_block, array('order_id' => DEFORDER, 'is_active' => 0));

						} else {

							// Check if not already present in pivot
							if( ! $block->pages->contains($new_page->id))
							{
								// Attach block to page in pivot
								$block->pages()->attach($new_page->id, array('order_id' => DEFORDER, 'is_active' => 0));								
							}
						}
					}
				}

				// Proceed with files
				if($file_all) {

					foreach ($page->files as $file)
					{
						$new_page->files()->attach($file->id, array('is_active' => $file->pivot->is_active));
					}

				}

				$this->events->fire('page.copied', array($page, $new_page));

				return $this->redirect = array(
					'redirect'	=> true,
					'status'	=> 'success',
					'msg'		=> t('alert.success.page_created'),
					'route'		=> route('page.edit', array('page_id' => $new_page->id))
				);

			}

		} else {

			return $check;
		}
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
				'edit_level' 	=> LEVEL,
				'view_access' 	=> 0,
				'view_level'	=> 0,
				'order_id'		=> DEFORDER,
			);

			$page = $this->model->create($default_page);
			$this->events->fire('page.create', array($page));

			$response = array(
				'render'	=> 'page',
				'status' 	=> 'success',
				'msg'		=> $msg,
				'id'		=> $page->id,
				'name'		=> $name,
				'url'		=> '#',
				'cls'		=> 'pongo-confirm',
				'lang'		=> $lang
			);

			return $this->setSuccess($response);
		}
	}

	/**
	 * [deletePage description]
	 * @return [type] [description]
	 */
	public function deletePage()
	{
		$page_id = $this->input['item_id'];

		$page = $this->model->find($page_id);

		if($page->delete()) {

			$this->events->fire('page.delete', array($page));
			
			$response = array(
				'remove' 	=> $page_id,
				'status' 	=> 'success',
				'msg'		=> t('alert.success.page_deleted')
			);

			return $this->setSuccess($response);

		} else {

			return $this->setError('alert.error.page_deleted');
		}
	}

	/**
	 * [loadBlocks description]
	 * @return [type] [description]
	 */
	public function loadBlocks()
	{
		$page_id = $this->input['page_id'];
		$zone = $this->input['zone'];

		$page = $this->model->getPageZoneBlocks($page_id, $zone);
		return $page->blocks->toJson();
	}

	/**
	 * Move blocks in page tree
	 * @return json object
	 */
	public function moveBlock()
	{
		$blocks = get_json('items');
		$page_id = $this->input['page_id'];
		
		$page = $this->model->find($page_id);

		foreach ($blocks as $key => $item) {
			foreach ($page->blocks as $block) {
				if($block->id == $item['id']) {
					$block->pivot->order_id = $key + 1;
					$block->pivot->save();
				}
			}
		}

		$this->events->fire('block.move', array($blocks));
		return $this->setSuccess('alert.success.block_order');
	}

	/**
	 * Move page in page tree
	 * @return json object
	 */
	public function movePage()
	{
		$pages = get_json('items');
		
		$this->events->fire('page.move', array($this->model, $pages));
		
		return $this->setSuccess('alert.success.page_order');
	}

	/**
	 * [savePageettings description]
	 * @return [type] [description]
	 */
	public function savePageSettings()
	{
		if($check = $this->canEdit()) {

			if ($this->validator->fails()) {

				return $this->setError($this->validator->errors());

			} else {

				$id = $this->input['id'];
				$home = \Tool::setFlag($this->input, 'is_home');

				$this->events->fire('page.save.settings', array($this->model, $home));

				$page = $this->model->find($id);
				$page->name = $this->input['name'];
				$page->slug = \Tool::slugSubst($page->slug, $this->input['slug']);
				$page->edit_level = $this->input['edit_level'];
				$page->view_access = $this->input['view_access'];
				$page->view_level = $this->input['view_level'];
				$page->is_home = $home;
				$page->save();

				$response = array(
					'status' 	=> 'success',
					'msg'		=> t('alert.success.save'),
					'page'		=> array(
						'id' 		=> $id,
						'lang'		=> LANG,
						'name'		=> $page->name,
						'home'		=> $page->is_home
					)
				);

				return $this->setSuccess($response);
			}

		} else {

			return $check;
		}
	}

	/**
	 * [savePageLayout description]
	 * @return [type] [description]
	 */
	public function savePageLayout()
	{
		if($check = $this->canEdit()) {

			if ($this->validator->fails()) {

				return $this->setError($this->validator->errors());

			} else {

				$id = $this->input['id'];
				$page = $this->model->find($id);
				$page->template = $this->input['template'];
				$page->header = $this->input['header'];
				$page->layout = $this->input['layout'];
				$page->footer = $this->input['footer'];
				$page->save();

				$this->events->fire('page.save.layout', array($page));

				return $this->setSuccess('alert.success.save');
			}

		} else {

			return $check;
		}
	}

	/**
	 * [savePageSeo description]
	 * @return [type] [description]
	 */
	public function savePageSeo()
	{
		if($check = $this->canEdit()) {

			if ($this->validator->fails()) {

				return $this->setError($this->validator->errors());

			} else {

				$id = $this->input['id'];
				$page = $this->model->find($id);
				$page->title = $this->input['title'];
				$page->keyw = $this->input['keyw'];
				$page->descr = $this->input['descr'];
				$page->save();

				// Get tags array if any
				$tags = (isset($this->input['tags'])) ? $this->input['tags'] : null;

				$this->events->fire('page.save.seo', array($page, $tags));

				return $this->setSuccess('alert.success.save');
			}

		} else {

			return $check;
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

		$response = array(
			'status' 	=> 'success',
			'msg'		=> t('alert.info.page_lang', array('lang' => $label)),
			'lang'		=> $label
		);

		return $this->setSuccess($response);
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

}