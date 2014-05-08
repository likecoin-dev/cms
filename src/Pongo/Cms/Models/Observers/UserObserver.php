<?php namespace Pongo\Cms\Models\Observers;

use Pongo\Cms\Services\Managers\BaseManager as Manager;

class UserObserver extends BaseObserver {

	public function deleting($user) {
		// Admin account
		if ($user->id == \Pongo::settings('admin_account.id')) {
			$this->setTmpError('alert.error.cant_delete_admin');
			return false;
		} 
		
		// Account own pages
		if (count($user->pages)) {
			$this->setTmpError('alert.error.user_own_pages');
			return false;
		} 
		
		// Delete itself
		if ($user->id == USERID) {
			$this->setTmpError('alert.error.cant_delete_current');
			return false;
		}
	}

}