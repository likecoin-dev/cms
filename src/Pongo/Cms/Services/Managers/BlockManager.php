<?php namespace Pongo\Cms\Services\Managers;

use Carbon\Carbon;
use Pongo\Cms\Classes\Access;
use Illuminate\Events\Dispatcher as Events;
use Pongo\Cms\Services\Validators\BlockValidator as Validator;
use Pongo\Cms\Repositories\BlockRepositoryInterface as Block;

class BlockManager extends BaseManager {

	public function __construct(Access $access, Events $events, Validator $validator, Block $block)
	{
		$this->access = $access;
		$this->events = $events;
		$this->validator = $validator;
		$this->model = $block;

		$this->section = 'blocks';
	}

	/**
	 * Create a new empty block
	 * @return bool
	 */
	public function createEmptyBlock()
	{
		if($this->input) {
			$lang = $this->input['lang'];
			$zone = $this->input['zone'];
			$page_id = $this->input['page_id'];
			$timedate = Carbon::now()->format('H:i:s - Ymd');
			$name = t('template.created', array('timedate' => $timedate), $lang);
			$msg = t('alert.success.block_created');			
			$attrib = snake_case($timedate);

			$default_block = array(
				'author_id' 	=> USERID,
				'lang' 			=> $lang,
				'attrib'		=> $attrib,
				'name' 			=> $name,
				'text' 			=> '<h1>'.$name.'</h1>',
				'zone'			=> $zone
			);

			$block = $this->model->create($default_block);
			$this->events->fire('block.create', array($block, $page_id));

			$response = array(
				'render'	=> 'block',
				'status' 	=> 'success',
				'msg'		=> $msg,
				'id'		=> $block->id,
				'name'		=> $name,
				'url'		=> '#',
				'cls'		=> 'pongo-confirm',
				'lang'		=> $lang,
				'is_active'	=> 0
			);

			return $this->setSuccess($response);
		}
	}

	/**
	 * [deleteBlock description]
	 * @return [type] [description]
	 */
	public function deleteBlock()
	{
		$block_id = $this->input['item_id'];
		$page_id = $this->input['current_page'];

		$block = $this->model->find($block_id);
		$block->pages()->detach($page_id);

		$this->events->fire('block.delete', array($block, $page_id));
		
		$response = array(
			'remove' 	=> $block_id,
			'status' 	=> 'success',
			'msg'		=> t('alert.success.block_deleted')
		);

		return $this->setSuccess($response);
	}

	/**
	 * [savePageettings description]
	 * @return [type] [description]
	 */
	public function saveBlockSettings()
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
	 * [saveBlockContent description]
	 * @return [type] [description]
	 */
	public function saveBlockContent()
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

				$this->events->fire('page.save.seo', array($page));

				return $this->setSuccess('alert.success.save');
			}

		} else {

			return $check;
		}
	}

	/**
	 * [validPage description]
	 * @return [type] [description]
	 */
	public function validBlock()
	{
		$block_id = $this->input['item_id'];
		$page_id = $this->input['page_id'];
		$value = $this->input['action'];

		$block = $this->model->find($block_id);
		
		foreach ($block->pages as $page) {
			if($page->pivot->page_id == $page_id) {
				$page->pivot->is_active = $value;
				$page->pivot->save();
			}
		}
		
		return $this->setSuccess('alert.success.page_modified');
	}

}