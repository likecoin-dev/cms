<?php namespace Pongo\Cms\Repositories;

interface PageRepositoryInterface {

	public function getPageList($parent_id, $lang);
	
	/*public function attachPageFile($page, $file_id);

	public function attachPageRel($page, $rel_id);

	public function countPageElements($page);

	public function countPageFiles($page);

	public function createPage($page_arr);

	public function deletePage($page);

	public function deletePageElements($element);	

	public function detachPageElement($page, $element_id);

	public function detachPageFile($page, $file_id);

	public function detachPageFiles($page);

	public function detachPageRel($page, $rel_id);
	
	public function getPage($page_id);

	public function getPageBySlug($slug);

	public function getPageCheck($field, $value);

	public function getPageElements($page_id);

	public function getPageFiles($page_id);

	

	public function getPagePath($path);

	public function getPageRels($page, $to_array);

	public function getLangHomePage();

	public function getSubPages($page_id);

	public function resetHomePage();

	public function savePage($page);

	public function savePageFile($page, $file);

	public function savePageElement($page, $element, $order);*/
	
}