<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\User as User;
use Pongo\Cms\Models\UserDetail as UserDetail;

class UserRepositoryEloquent implements UserRepositoryInterface {

	public function createUser($user_arr)
	{
		return User::create($user_arr);
	}

	public function createUserDetails($user_id)
	{
		return UserDetail::create(array('user_id' => $user_id));
	}

	public function deleteUser($user)
	{
		return $user->delete();
	}

	public function getUser($user_id)
	{
		return User::find($user_id);
	}

	public function getUserLevel($user)
	{
		return $user->role->level;
	}

	public function getUserDetails($user)
	{
		return $user->details;
	}

	public function getUsers()
	{
		return User::all();
	}

	public function getUsersWithRoles($limit)
	{
		return User::with('role')
				   ->orderBy('username')
				   ->paginate($limit);
	}

	public function paginateUsers($limit)
	{
		return User::orderBy('username')
				   ->paginate($limit);
	}

	public function saveUser($user)
	{
		return $user->save();
	}

	public function saveUserDetails($user_details)
	{
		return $user_details->save();
	}

	public function searchUser($search, $field)
	{
		return User::where($field, 'like', $search . '%')
				   ->orderBy($field, 'asc')
				   ->get();
	}

}