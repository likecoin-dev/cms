<?php namespace Pongo\Cms\Models\Observers;

class RoleObserver extends BaseObserver {

	public function deleting($role) {		
		// Role still has users
		if (count($role->users)) {
			$this->setTmpError('alert.error.role_has_users');
			return false;
		}
	}

}