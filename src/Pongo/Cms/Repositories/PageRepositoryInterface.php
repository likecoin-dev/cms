<?php namespace Pongo\Cms\Repositories;

interface PageRepositoryInterface {

	/**
	 * Custom methods for Page
	 */
	public function getPageList($parent_id, $lang);
	public function getPageZoneBlocks($id, $zone);
	public function countPageWithSlug($slug, $id);
	public function resetHomePage();
}