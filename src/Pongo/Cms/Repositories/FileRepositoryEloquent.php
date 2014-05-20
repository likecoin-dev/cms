<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\File as File;
use Pongo\Cms\Services\Cache\CacheInterface;

class FileRepositoryEloquent extends BaseRepositoryEloquent implements FileRepositoryInterface {

	/**
	 * @var Cache
	 */
	protected $cache;

	/**
	 * File Repository constructor
	 */
	function __construct(File $file, CacheInterface $cache)
	{
		$this->model = $file;
		$this->cache = $cache;

		// Set cache parameters
		$this->cache->cachekey = 'files';
		$this->cache->minutes = 10;
	}

	public function countFilePages($file_id)
	{
		return $this->model
					->find($file_id)
					->pages()
					->count();
	}

}