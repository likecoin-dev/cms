<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\FileManager;

class FileController extends ApiController {

	public function __construct(FileManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager;
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		if ($this->manager->withInput()->deleteFile()) {

			return $this->manager->success();

		} else {
			
			return $this->manager->errors();
		}
	}

	/**
	 * [upload description]
	 * @return [type] [description]
	 */
	public function upload()
	{
		if ($this->manager->withFileInput()->uploadFiles())
		{
			return $this->manager->success();
		}
		else
		{
			return $this->manager->errors();
		}
	}

	/**
	 * [valid description]
	 * @return [type] [description]
	 */
	public function valid()
	{
		if ($this->manager->withInput()->validFile()) {
			
			return $this->manager->success();
		}
	}

}