<?php namespace Pongo\Cms\Models\Observers;

use Pongo\Cms\Services\Managers\BaseManager as Manager;

class BaseObserver {

	protected function setTmpError($error)
	{
		Manager::$tmp_error = $error;
	}

}