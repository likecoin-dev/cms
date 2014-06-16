<?php namespace Pongo\Cms\Repositories;

interface FileRepositoryInterface {

	public function countFilePages($file_id);
	public function getFilesPage($page_id);
	
}