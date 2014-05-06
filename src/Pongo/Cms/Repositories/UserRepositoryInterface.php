<?php namespace Pongo\Cms\Repositories;

interface UserRepositoryInterface {

	/**
	 * Custom methods for User
	 */
	public function getUserLevel($user_id);
	public function getUserDetails($user_id);
	public function getUsersWithRole($per_page, $level);
}