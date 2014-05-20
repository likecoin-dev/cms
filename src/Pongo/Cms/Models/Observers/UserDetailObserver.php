<?php namespace Pongo\Cms\Models\Observers;

use Pongo\Cms\Services\Managers\BaseManager as Manager;

class UserDetailObserver extends BaseObserver {

	public function deleting($details)
	{
		// Admin account
		if ($details->user->id == \Pongo::settings('admin_account.id')) {
			$this->setFlashError('alert.error.user_admin');
			return false;
		} 
		
		// Account own pages
		if (count($details->user->pages)) {
			$this->setFlashError('alert.error.user_own_pages');
			return false;
		} 
		
		// Delete itself
		if ($details->user->id == USERID) {
			$this->setFlashError('alert.error.user_current');
			return false;
		}

		// Level is not enough
		if ($details->user->role->level > LEVEL) {
			$this->setFlashError('alert.error.user_deleted');
			return false;
		}
	}

	public function saving($details)
	{
		// Level is not enough
		if ($details->user->role->level > LEVEL) {
			$this->setFlashError('alert.error.user_updated');
			return false;
		}
	}

}