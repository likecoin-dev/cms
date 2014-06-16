<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\Block as Block;
use Pongo\Cms\Services\Cache\CacheInterface;

class BlockRepositoryEloquent extends BaseRepositoryEloquent implements BlockRepositoryInterface {

	/**
	 * @var Cache
	 */
	protected $cache;

	/**
	 * Block Repository constructor
	 */
	function __construct(Block $block, CacheInterface $cache)
	{
		$this->model = $block;
		$this->cache = $cache;

		// Set cache parameters
		$this->cache->cachekey = 'blocks';
		$this->cache->minutes = 10;
	}

	/**
	 * [getBlockZone description]
	 * @param  [type] $block   [description]
	 * @return [type]          [description]
	 */
	public function getBlockZone($block)
	{
		return $block->pages->first()->pivot->zone;
	}


}