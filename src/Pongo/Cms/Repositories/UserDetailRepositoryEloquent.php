<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\UserDetail as UserDetail;

class UserDetailRepositoryEloquent extends BaseRepositoryEloquent implements UserDetailRepositoryInterface {

	function __construct(UserDetail $model)
	{
		$this->model = $model;
	}

	public function createUserDetails($user_id)
	{
		return $this->model
					->create(array('user_id' => $user_id));
	}

}