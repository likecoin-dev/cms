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
	 * [createFile description]
	 * @return [type] [description]
	 */
	public function createFile()
	{
		if($check = $this->canEdit())
		{
			if ($this->validator->fails())
			{
				return $this->setError($this->validator->errors());
			}
			else
			{
				$id = $this->input['id'];

				$file_name = $this->input['file_name'];
				$file_size = $this->input['file_size'];
				$size_type = $this->input['size_type'];

				$folder_name = \Media::getFolderName($file_name);

				$format_name = \Media::formatFileName($file_name);

				$file_ext = \Media::fileExtension($file_name);

				$file_size = \Media::convertFileSize($file_size, $size_type);

				$http_path = '/' . \Pongo::settings('upload_path') . $folder_name . $format_name;

				$file_arr = array(
					'name' 		=> $format_name,
					'original'	=> $file_name,
					'ext'		=> $file_ext,
					'size'		=> $file_size,
					'w'			=> 0,
					'h'			=> 0,
					'path'		=> $http_path,
					'is_image'	=> 0,
					'is_active'	=> 1
				);

				// Write file to db
				$new_file = $this->model->create($file_arr);

				// Attach new_file to page in pivot
				$new_file->pages()->attach($id, array('is_active' => 1));

				$response = array(
					'status' 	=> 'success',
					'msg'		=> t('alert.success.file_created'),
					'print'		=> array(

						'text' => t('form.infos.create_file', array(

							'rename' => $format_name,
							'upload' => \Media::getFolderPublic(\Pongo::settings('upload_path') . $folder_name . $format_name)

						)),

						'item' => array(

							'id' => $new_file->id,
							'is_image' => \Media::isImage($new_file->name),
							'file_name' => $new_file->name,
							'url_link' => \Media::getImgPath($new_file->name),
							'ico' => \Media::loadThumb($new_file->path, 'cms'),
							'url_edit' => route('file.edit', array('file_id' => $new_file->id))

						)

					)
				);

				return $this->setSuccess($response);
			}
		} 
		else
		{
			return $check;
		}
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

			// Check if upload comes from editor
			$from_editor = array_key_exists('type', $this->input) ? true : false;

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

			// Check if upload is from Froala
			if($from_editor and isset($new_file))
			{
				$response['link'] = \Media::getImgPath($new_file[0]->name);
			}
			elseif($from_editor and $has_errors)
			{
				$response['error'] = $this->validator->singleError();
			}

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