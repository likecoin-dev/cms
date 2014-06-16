<?php namespace Pongo\Cms\Models\Observers;

class BlockObserver extends BaseObserver {

	public function deleting($block)
	{
		// Block is still valid
		if ($block->is_active == 1) {
			$this->setFlashError('alert.error.block_is_active');
			return false;
		}

		// Block is currently viewed
		if ($block->id == \Input::get('current_block')) {
			$this->setFlashError('alert.error.block_is_current');
			return false;
		}
	}

}