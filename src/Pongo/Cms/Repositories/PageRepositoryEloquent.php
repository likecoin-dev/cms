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

	public function getPageActiveFiles($id)
	{
		return $this->model
					->with(array('files' => function($q) {
						$q->wherePivot('is_active', 1);
					}))
					->where('pages.id', '=', $id)
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
						$q->where('block_page.zone', '=', $zone);
					}))
					->where('pages.id', $id)
					->first();
	}

	/**
	 * [getChildByParentId description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getChildByParentId($id)
	{
		return $this->model
					->parent($id)
					->lang(LANG)
					->active()
					->first();
	}

	/**
	 * [getHomePage description]
	 * @return [type] [description]
	 */
	public function getHomePageWithBlocksAndSeo()
	{
		return $this->model
					->with(array('blocks', 'seo'))
					->lang(LANG)
					->active()
				   	->home(1)
				   	->first()
				   	->toArray();
	}

	/**
	 * [resetHomePage description]
	 * @return [type] [description]
	 */
	public function resetHomePage($id)
	{
		return $this->model
					->lang(LANG)
				   	->home(1)
				   	->where('id', '<>', $id)
				   	->update(array('is_home' => 0));
	}

}