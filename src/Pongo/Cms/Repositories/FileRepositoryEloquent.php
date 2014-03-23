<?php namespace Pongo\Cms\Support\Repositories;

use Pongo\Cms\Models\File as File;

class FileRepositoryEloquent extends BaseRepositoryEloquent implements FileRepositoryInterface {

	function __construct(File $model)
	{
		$this->model = $model;
	}

	public function countFilePages($file_id)
	{
		return $this->model
					->find($file_id)
					->pages()
					->count();
	}

}