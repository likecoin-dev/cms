<?php namespace Pongo\Cms\Repositories;

interface UserRepositoryInterface {

	public function createUser($user_arr);

	public function createUserDetails($user_id);

	public function deleteUser($user);

	public function getUser($user_id);

	public function getUserLevel($user);

	public function getUserDetails($user_id);

	public function getUsers();

	public function getUsersWithRoles($limit);

	public function paginateUsers($limit);

	public function saveUser($user);

	public function saveUserDetails($user_details);

	public function searchUser($search, $field);
	
}