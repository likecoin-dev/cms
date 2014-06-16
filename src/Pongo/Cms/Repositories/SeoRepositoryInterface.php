<?php namespace Pongo\Cms\Repositories;

interface SeoRepositoryInterface {

	public function countPageWithSlug($slug, $id, $lang);
	public function getContentBySlug($slug);
	
}