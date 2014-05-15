<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\Page as Page;
use Pongo\Cms\Services\Cache\CacheInterface;

class PageRepositoryEloquent extends BaseRepositoryEloquent implements PageRepositoryInterface {

	/**
	 * @var Cache
	 */
	protected $cache;

	/**
	 * Page Repository constructor
	 */
	function __construct(Page $page, CacheInterface $cache)
	{
		$this->model = $page;
		$this->cache = $cache;

		// Set cache parameters
		$this->cache->cachekey = 'pages';
		$this->cache->minutes = 10;
	}

	/**
	 * [getPageList description]
	 * @param  [type] $parent_id [description]
	 * @param  [type] $lang      [description]
	 * @return [type]            [description]
	 */
	public function getPageList($parent_id, $lang)
	{
		return $this->model
					->lang($lang)
					->where('parent_id', $parent_id)
					->orderBy('order_id')
					->get();
	}

	/**
	 * [getPageZoneBlocks description]
	 * @param  [type] $id   [description]
	 * @param  [type] $zone [description]
	 * @return [type]       [description]
	 */
	public function getPageZoneBlocks($id, $zone)
	{
		return $this->model
					->with(array('blocks' => function($q) use ($zone) {
						$q->where('zone', '=', $zone);
					}))
					->where('pages.id', '=', $id)
					->first();
	}

	/**
	 * [countPageWithSlug description]
	 * @param  [type] $slug [description]
	 * @param  [type] $id   [description]
	 * @return [type]       [description]
	 */
	public function countPageWithSlug($slug, $id)
	{
		return $this->model
					->lang(LANG)
					->where('id', '<>', $id)
					->where('slug', 'like', '%'.$slug)
					->count();

	}

	/**
	 * [resetHomePage description]
	 * @return [type] [description]
	 */
	public function resetHomePage()
	{
		return $this->model
					->lang(LANG)
				   	->home(1)
				   	->update(array('is_home' => 0));
	}

}