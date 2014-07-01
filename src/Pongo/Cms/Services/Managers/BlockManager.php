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

	public function copyBlock()
	{
		if($check = $this->canEdit()) {

			if($this->input) {

				$block_id = $this->input['block_id'];
				$pages = isset($this->input['pages']) ? $this->input['pages'] : null;
				$self_blocks = isset($this->input['self_block']) ? $this->input['self_block']: null;

				// Duplicate block
				$block = $this->model->find($block_id);
				$new_block_arr = $block->getAttributes();

				// Clean some unwanted attributes
				unset($new_block_arr['id'], $new_block_arr['created_at'], $new_block_arr['updated_at']);

				$new_block_name = t('label.page.settings.copy_of') . ' ' . $block->name;

				// Overriding with new values
				$new_block_arr['attrib'] 	= \Str::slug($new_block_name);
				$new_block_arr['name'] 		= $new_block_name;
				
				if($pages)
				{
					foreach ($pages as $page_id)
					{
						if(isset($self_blocks[$page_id]))
						{
							// Create a brand-new block
							$new_block = $this->model->create($new_block_arr);

							// Attach to pivot
							$new_block->pages()->attach($page_id, array('zone' => 'ZONE1', 'order_id' => DEFORDER, 'is_active' => 0));
						}
						else
						{
							// Check if not already present in pivot
							if( ! $block->pages->contains($page_id))
							{
								$block->pages()->attach($page_id, array('zone' => 'ZONE1', 'order_id' => DEFORDER, 'is_active' => 0));
							}
						}
					}
				}

				$this->events->fire('block.copy', array($block));

				$response = array(
					'close'		=> true,
					'status'	=> 'success',
					'msg'		=> t('alert.success.block_copied'),
				);

				return $this->setSuccess($response);
			}

		} else {

			return $check;
		}
	}

	/**
	 * Create a new empty block
	 * @return bool
	 */
	public function createEmptyBlock()
	{
		if($this->input)
		{
			$lang = $this->input['lang'];
			$zone = $this->input['zone'];
			$page_id = $this->input['page_id'];
			
			$timedate = Carbon::now()->format('H:i:s - Ymd');
			
			$name = t('template.created', array('timedate' => $timedate), $lang);
			$msg = t('alert.success.block_created');			
			
			$attrib = \Str::slug('attr-'.$timedate);

			$default_block = array(
				'author_id' 	=> USERID,
				'attrib'		=> $attrib,
				'name' 			=> $name,
				'content'		=> '<h1>'.$name.'</h1>'
			);

			$block = $this->model->create($default_block);

			$this->events->fire('block.create', array($block, $page_id, $zone));

			$response = array(
				'render'	=> 'block',
				'status' 	=> 'success',
				'msg'		=> $msg,
				'id'		=> $block->id,
				'page_id'	=> $page_id,
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
		if($this->input)
		{
			$block_id = $this->input['item_id'];
			$page_id = $this->input['current_page'];

			// prevent delete current block
			if(array_key_exists('current_block', $this->input))
			{
				$current_block = $this->input['current_block'];
				if($block_id == $current_block)
				{
					return $this->setError('alert.error.block_is_current');
				}
			}

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
	}

	/**
	 * [getBlock description]
	 * @param  [type] $block_id [description]
	 * @return [type]           [description]
	 */
	public function getBlock($block_id)
	{
		$block = $this->getOne($block_id);

		if($block)
		{
			$zone = $this->model->getBlockZone($block);

			$block->zone = $zone;

			return $block;
		}		
	}

	/**
	 * [savePageettings description]
	 * @return [type] [description]
	 */
	public function saveBlockSettings()
	{
		if($check = $this->canEdit())
		{
			if ($this->validator->fails())
			{
				return $this->setError($this->validator->errors());
			}
			else
			{
				$id = $this->input['id'];
				$page_id = $this->input['page_id'];

				$this->events->fire('block.save.settings', array($this->model));

				$block = $this->model->find($id);

				$old_zone = $block->zone;

				$block->name = $this->input['name'];
				$block->attrib = $this->input['attrib'];
				$block->save();

				foreach ($block->pages as $page)
				{
					if($page->pivot->page_id == $page_id)
					{
						$page->pivot->zone = $this->input['zone'];
						$page->pivot->save();
					}
				}

				$response = array(
					'status' 	=> 'success',
					'msg'		=> t('alert.success.save'),
					'block'		=> array(
						'id' 		=> $id,
						'name'		=> $block->name,
					)
				);

				// add info to block
				if($old_zone != $block->zone)
				{
					$response['block']['zone'] = $block->zone;
				}

				return $this->setSuccess($response);
			}

		}
		else
		{
			return $check;
		}
	}

	/**
	 * [saveBlockContent description]
	 * @return [type] [description]
	 */
	public function saveBlockContent()
	{
		if($check = $this->canEdit())
		{
			if ($this->validator->fails())
			{
				return $this->setError($this->validator->errors());
			}
			else
			{
				$id = $this->input['id'];
				$block = $this->model->find($id);
				$block->content = $this->input['body'];
				$block->save();

				$this->events->fire('block.save.content', array($block));

				return $this->setSuccess('alert.success.save');
			}

		}
		else
		{
			return $check;
		}
	}

	/**
	 * [validPage description]
	 * @return [type] [description]
	 */
	public function validBlock()
	{
		if($this->input)
		{
			$block_id = $this->input['item_id'];
			$page_id = $this->input['page_id'];
			$value = $this->input['action'];

			$block = $this->model->find($block_id);
			
			foreach ($block->pages as $page)
			{
				if($page->pivot->page_id == $page_id)
				{
					$page->pivot->is_active = $value;
					$page->pivot->save();
				}
			}
			
			return $this->setSuccess('alert.success.page_modified');
		}
	}

}