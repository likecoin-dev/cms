<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\File as File;

class FileRepositoryEloquent extends BaseRepositoryEloquent implements FileRepositoryInterface {

	function __construct(File $file)
	{
		$this->model = $file;
	}

	public function countFilePages($file_id)
	{
		return $this->model
					->find($file_id)
					->pages()
					->count();
	}

}