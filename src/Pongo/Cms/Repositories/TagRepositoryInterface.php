<?php namespace Pongo\Cms\Repositories;

interface TagRepositoryInterface {

	/**
	 * Custom methods for Tag
	 */
	
	public function getTagsList($search, $lang);

}