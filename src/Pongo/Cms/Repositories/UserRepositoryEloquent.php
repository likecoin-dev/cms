<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\User as User;
use Pongo\Cms\Services\Cache\CacheInterface;

class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepositoryInterface {


	/**
	 * @var Cache
	 */
	protected $cache;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * User Repository constructor
	 */
	function __construct(User $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		// Set cache parameters
		$this->cache->cachekey = 'users';
		$this->cache->minutes = 10;

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