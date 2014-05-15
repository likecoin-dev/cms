<?php namespace Pongo\Cms\Models\Observers;

use Pongo\Cms\Services\Managers\BaseManager as Manager;

class UserObserver extends BaseObserver {

	public function deleting($user) {
		// Admin account
		if ($user->id == \Pongo::settings('admin_account.id')) {
			$this->setFlashError('alert.error.user_admin');
			return false;
		} 
		
		// Account own pages
		if (count($user->pages)) {
			$this->setFlashError('alert.error.user_own_pages');
			return false;
		} 
		
		// Delete itself
		if ($user->id == USERID) {
			$this->setFlashError('alert.error.user_current');
			return false;
		}

		// Level is not enough
		if ($user->role->level > LEVEL) {
			$this->setFlashError('alert.error.user_deleted');
			return false;
		}
	}

}