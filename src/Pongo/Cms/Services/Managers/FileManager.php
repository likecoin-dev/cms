<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Illuminate\Events\Dispatcher as Events;
use Pongo\Cms\Services\Validators\FileValidator as Validator;
use Pongo\Cms\Repositories\FileRepositoryInterface as File;

class FileManager extends BaseManager {	

	public function __construct(Access $access, Events $events, Validator $validator, File $file)
	{
		$this->access = $access;
		$this->events = $events;
		$this->validator = $validator;
		$this->model = $file;

		$this->section = 'files';
	}

	/**
	 * [deleteBlock description]
	 * @return [type] [description]
	 */
	public function deleteFile()
	{
		if($this->input)
		{
			$file_id = $this->input['item_id'];
			$page_id = $this->input['current_page'];

			$file = $this->model->find($file_id);
			$file->pages()->detach($page_id);

			$this->events->fire('file.delete', array($file, $page_id));
			
			$response = array(
				'remove' 	=> $file_id,
				'status' 	=> 'success',
				'msg'		=> t('alert.success.file_deleted')
			);

			return $this->setSuccess($response);
		}
	}

	/**
	 * [uploadFiles description]
	 * @return [type] [description]
	 */
	public function uploadFiles()
	{
		if($this->input)
		{
			$files = $this->input['files'];
			$page_id = $this->input['page_id'];

			$has_errors = false;

			foreach ($files as $key => $file)
			{
				// Set the single file as validator input
				// for being checked against valitation rules
				$this->validator->input = $this->makeFileArray($file);

				if ($this->validator->uploadValidate())
				{
					// Save file on disk and save entry into DB
					$new_file = $this->events->fire('file.upload', array($this->model, $file, $page_id));

					$response[$key]['status'] = 'success';
					$response[$key]['icon'] = 'fa fa-check success';

					$response[$key]['item']['id'] = $new_file[0]->id;
					$response[$key]['item']['is_image'] = \Media::isImage($new_file[0]->name);
					$response[$key]['item']['file_name'] = $new_file[0]->name;
					$response[$key]['item']['url_link'] = \Media::getImgPath($new_file[0]->name);
					$response[$key]['item']['ico'] = \Media::loadThumb($new_file[0]->path, 'cms');
					$response[$key]['item']['url_edit'] = route('file.edit', array('file_id' => $new_file[0]->id));
				}
				else
				{
					$response[$key] = $this->validator->uploadErrors();
					$has_errors = true;
				}

			}

			$response['status'] = 'success';
			$response['msg'] = $has_errors ? t('alert.success.upload_comp_err') : t('alert.success.upload_completed');

			return $this->setSuccess($response);
		}
	}

	/**
	 * [validRole description]
	 * @return [type] [description]
	 */
	public function validFile()
	{
		if($this->input)
		{
			$file_id = $this->input['item_id'];
			$page_id = $this->input['page_id'];
			$value = $this->input['action'];

			$file = $this->model->find($file_id);

			foreach ($file->pages as $page) {
				if($page->pivot->page_id == $page_id) {
					$page->pivot->is_active = $value;
					$page->pivot->save();
				}
			}
			
			return $this->setSuccess('alert.success.save');
		}
	}

	/**
	 * Transform file Obj in file Array for validation
	 * 
	 * @param  object $input
	 * @return array
	 */
	protected function makeFileArray($input)
	{
		$file_name = $input->getClientOriginalName();

		$file_arr = array();

		$file_arr['file_name'] = \Media::formatFileName($file_name);
		$file_arr['file_size'] = $input->getSize();
		$file_arr['ext_mimes'] = \Media::fileExtension($file_name);

		return $file_arr;
	}

}