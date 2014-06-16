<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\Seo;
use Pongo\Cms\Services\Cache\CacheInterface;

class SeoRepositoryEloquent extends BaseRepositoryEloquent implements SeoRepositoryInterface {

	/**
	 * @var Cache
	 */
	protected $cache;

	/**
	 * Page Repository constructor
	 */
	function __construct(Seo $seo, CacheInterface $cache)
	{
		$this->model = $seo;
		$this->cache = $cache;

		// Set cache parameters
		$this->cache->cachekey = 'seo';
		$this->cache->minutes = 10;
	}

	/**
	 * [countPageWithSlug description]
	 * @param  [type] $slug [description]
	 * @param  [type] $id   [description]
	 * @return [type]       [description]
	 */
	public function countPageWithSlug($slug, $id, $lang)
	{
		return $this->model
					->lang($lang)
					->where('seoable_id', '<>', $id)
					->where('seoable_type', 'Pongo\Cms\Models\Page')
					->where('slug', 'like', '%'.$slug)
					->count();

	}

	public function getContentBySlug($slug)
	{
		return $this->model
					->where('slug', $slug)
					->first();
	}

}