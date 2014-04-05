<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Support\Repositories\FileRepositoryInterface as File;

class FileController extends BaseController {

	/**
	 * Class constructor
	 */
	public function __construct()
	{

	}

	public function uploadFile()
	{
		$view = \Render::view('sections.file.upload');
		$view['section']	= 'upload';
		$view['page_id'] 	= 0;

		return $view;
	}

}