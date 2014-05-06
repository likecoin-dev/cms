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
	// protected $config;

	/**
	 * User Repository constructor
	 */
	function __construct(User $user, CacheInterface $cache)
	{
		$this->model = $user;
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

	public function getUsersWithRole($per_page, $level)
	{
		return $this->model
					->with('role')
					->maxLevel($level)
					->orderBy('username', 'asc')
					->paginate($per_page);
	}

}