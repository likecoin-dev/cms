<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\User as User;

class UserRepositoryEloquent extends BaseRepositoryEloquent implements BaseRepositoryInterface, RoleRepositoryInterface {

	/**
	 * @var User model
	 */
	protected $model;

	function __construct(User $model)
	{
		$this->model = $model;
	}

	public function createUserDetails($user_id)
	{
		return $this->model
					->find($user_id)
					->details()
					->create(array('user_id' => $user_id));
	}

	public function getUserLevel($user_id)
	{
		return $this->model
					->find($user_id)
					->role
					->level;
	}

	public function getUserDetails($user_id)
	{
		return $this->model
					->find($user_id)
					->details;
	}

	public function getUsersWithRoles($limit)
	{
		return $this->model
					->with('role')
					->orderBy('username')
					->paginate($limit);
	}

	public function searchUser($search, $field)
	{
		return $this->model
					->where($field, 'like', $search . '%')
					->orderBy($field, 'asc')
					->get();
	}

}