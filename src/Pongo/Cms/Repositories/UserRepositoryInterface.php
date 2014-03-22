<?php namespace Pongo\Cms\Repositories;

interface UserRepositoryInterface {

	/**
	 * Custom methods for User
	 */

	public function createUserDetails($user_id);

	public function getUserLevel($user_id);

	public function getUserDetails($user_id);

	public function getUsersWithRoles($limit);

	public function searchUser($search, $field);
	
}