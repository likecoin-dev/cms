<?php namespace Pongo\Cms\Services\Events;

class FileSubscriber extends BaseSubscriber {

	/**
	 * [onCreate description]
	 * @param  [type] $file [description]
	 * @return [type]      [description]
	 */
	public function onCreate($file)
	{
		// D('Role has been created!');
	}

	/**
	 * [onDelete description]
	 * @param  [type] $file    [description]
	 * @param  [type] $page_id [description]
	 * @return [type]          [description]
	 */
	public function onDelete($file, $page_id)
	{
		// Delete block if not attached to other zones
		if(count($file->pages) == 0) {
			$file->delete();
		}
	}

	/**
	 * [onMove description]
	 * @param  [type] $file [description]
	 * @return [type]      [description]
	 */
	public function onMove($file)
	{
		// 
	}

	/**
	 * [onSave description]
	 * @param  [type] $file [description]
	 * @return [type]      [description]
	 */
	public function onSave($file)
	{
		// 
	}

	public function onUpload($model, $file, $page_id)
	{
		$path = \Pongo::settings('upload_path');
		// file name
		$file_name 	= $file->getClientOriginalName();
		// file size
		$file_size 	= $file->getSize();
		// file extension
		$file_ext 	= $file->getClientOriginalExtension();
		// dir type
		$folder_name = \Media::getFolderName($file_name);
		// upload path
		$upload_path = public_path($path . $folder_name);
		
		// Format file name
		$format_name = \Media::formatFileName($file_name);
		
		// Save to disk
		$file->move($upload_path, $format_name);

		// file path
		$file_path = $upload_path . $format_name;

		// http path
		$http_path = '/' . $path . $folder_name . $format_name;
		
		if(\Media::isImage($format_name)) {
			$image 		= \Picture::get($file_path);
			$image_w 	= $image->width;
			$image_h 	= $image->height;
			$is_image 	= 1;

			// Create thumb?
			\Picture::createThumb($image, $format_name, 'cms');

		} else {
			$image_w 	= 0;
			$image_h 	= 0;
			$is_image 	= 0;
		}					

		$file_arr = array(
			'name' 		=> $format_name,
			'original'	=> $file_name,
			'ext'		=> $file_ext,
			'size'		=> $file_size,
			'w'			=> $image_w,
			'h'			=> $image_h,
			'path'		=> $http_path,
			'is_image'	=> $is_image,
			'is_active'	=> 1
		);		

		// Create file in 'files'
		$new_file = $model->create($file_arr);

		// Update pivot 'file_page'
		$new_file->pages()->attach($page_id, array('is_active' => 1));

		return $new_file;
	}

	/**
	 * [subscribe description]
	 * @param  [type] $events [description]
	 * @return [type]         [description]
	 */
	public function subscribe($events)
	{
		$events->listen('file.create', $this->eventPath . 'FileSubscriber@onCreate');
		$events->listen('file.delete', $this->eventPath . 'FileSubscriber@onDelete');
		$events->listen('file.move',   $this->eventPath . 'FileSubscriber@onMove');
		$events->listen('file.save',   $this->eventPath . 'FileSubscriber@onSave');
		$events->listen('file.upload', $this->eventPath . 'FileSubscriber@onUpload');
	}
}