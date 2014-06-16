<?php namespace Pongo\Cms\Repositories;

interface PageRepositoryInterface {

	/**
	 * Custom methods for Page
	 */
	public function getPageList($parent_id, $lang);
	public function getPageActiveFiles($id);
	public function getPageZoneBlocks($id, $zone);
	public function getHomePageWithBlocksAndSeo();
	public function resetHomePage($id);
}