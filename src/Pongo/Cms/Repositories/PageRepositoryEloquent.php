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

	public function getPageList($parent_id, $lang)
	{
		return Page::where('parent_id', $parent_id)
				   // ->where('is_virtual', 0)
				   ->where('lang', $lang)
				   ->orderBy('order_id')
				   ->get();
	}

	/*public function attachPageFile($page, $file_id)
	{
		return $page->files()->attach($file_id);
	}

	public function attachPageRel($page, $rel_id)
	{
		return $page->rels()->attach($rel_id);
	}

	public function countPageElements($page)
	{
		return $page->elements->count();
	}

	public function countPageFiles($page)
	{
		return $page->files->count();
	}

	public function createPage($page_arr)
	{
		return Page::create($page_arr);
	}

	public function deletePage($page)
	{
		return $page->delete();
	}

	public function deletePageElements($element)
	{
		return $element->pivot->delete();
	}

	public function detachPageElement($page, $element_id)
	{
		return $page->elements()->detach($element_id);
	}

	public function detachPageFile($page, $file_id)
	{
		return $page->files()->detach($file_id);
	}

	public function detachPageFiles($page)
	{
		return $page->files()->detach();
	}

	public function detachPageRel($page, $rel_id)
	{
		return $page->rels()->detach($rel_id);
	}

	public function getPage($page_id)
	{
		return Page::find($page_id);
	}

	public function getPageBySlug($slug)
	{
		return Page::where('slug', $slug)
				   ->where('is_active', 1)
				   ->first();
	}

	public function getPageCheck($field, $value)
	{
		return Page::where('lang', LANG)
				   ->where($field, $value)
				   ->first();
	}

	public function getPageElements($page_id)
	{
		return Page::find($page_id)->elements;
	}

	public function getPageFiles($page_id)
	{
		return Page::find($page_id)->files;
	}

	public function getPagePath($path)
	{
		return Page::where('lang', LANG)
				   ->where('slug', $path)
				   ->first();
	}

	public function getPageRels($page, $to_array = false)
	{
		return ($to_array) ? $page->rels->toArray() : $page->rels;
	}

	public function getLangHomePage()
	{
		return Page::where('lang', LANG)
				   ->where('is_home', 1)
				   ->first();
	}

	public function getLangHomePages()
	{
		return Page::where('lang', LANG)
				   ->where('is_home', 1)
				   ->first();
	}

	public function getSubPages($page_id)
	{
		return Page::where('parent_id', $page_id)->get();
	}

	public function resetHomePage()
	{
		return Page::where('lang', LANG)
				   ->where('is_home', 1)
				   ->update(array('is_home' => 0));
	}

	public function savePage($page)
	{
		return $page->save();
	}

	public function savePageFile($page, $file)
	{
		return $page->files()->save($file);
	}

	public function savePageElement($page, $element, $order)
	{
		return $page->elements()->save($element, array('order_id' => $order));
	}*/

}