<?php namespace Pongo\Cms\Services\Search;

interface SearchInterface {	
	public function getResults($per_page);
	public function setParams($input);
}