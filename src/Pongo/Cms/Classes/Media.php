<?php namespace Pongo\Cms\Classes;

class Media {

	/**
	 * Convert a number to Kb or Mb size
	 * 
	 * @param  int $size
	 * @param  string $type
	 * @return int
	 */
	public function convertFileSize($size, $type = 'kb')
	{
		$check_type = strtolower($type);

		switch ($check_type) {
			case 'kb':
				$value = $size * 1024;
				break;
			case 'mb':
				$value = $size * 1024000;
				break;
			default:
				$value = $size * 1024;
				break;
		}

		return $value;
	}
	
	/**
	 * Delete a file and its thumbs (if image)
	 * 
	 * @param  string $file_name
	 * @return bool
	 */
	public function deleteFile($file_name)
	{
		$file_path = $this->getFilePath($file_name);

		if(file_exists($file_path)) unlink($file_path);

		if($this->isImage($file_name)) {

			foreach (\Theme::config('thumb') as $key => $value) {

				$thumb_name = $this->formatFileThumb($file_name, $key);

				$thumb_path = $this->getFilePath($thumb_name);

				if(file_exists($thumb_path)) unlink($thumb_path);
			}
		}

		return true;
	}

	/**
	 * Get file extension
	 * 
	 * @param  string $file
	 * @return string
	 */
	public function fileExtension($file_name)
	{
		$temp = explode('.', $file_name);

		return strtolower(end($temp));
	}

	/**
	 * Format a file name
	 * 
	 * @param  string $file
	 * @param  bool   $add_ext
	 * @return string
	 */
	public function formatFileName($file_name, $add_ext = true)
	{
		$temp = explode('.', $file_name);

		$extension = strtolower(end($temp));

		$temp_name = $temp[0];

		$temp_name = \Str::slug($temp_name, '_');

		return  ($add_ext) ? $temp_name . '.' . $extension : $temp_name;
	}

	/**
	 * Format a thumb file name
	 *
	 * $thumb must be one of the site::theme.thumb keys
	 * 
	 * @param  string $file
	 * @param  string $thumb
	 * @return string
	 */
	public function formatFileThumb($file_name, $thumb = 'cms')
	{
		$temp = explode('.', $file_name);

		$extension = end($temp);

		$temp_name = $temp[0];

		return \Str::slug($temp_name, '_') . '_' . $thumb . '.' . $extension;
	}

	/**
	 * Format a number to Kb, Mb ... size
	 * 
	 * @param  integer  $bytes
	 * @param  integer  $precision [description]
	 * @return string
	 */
	public function formatFileSize($bytes, $precision = 2) { 
		$units = array('Bytes', 'Kb', 'Mb', 'Gb', 'Tb'); 

		$bytes = max($bytes, 0);

		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		
		$pow = min($pow, count($units) - 1); 

		$bytes /= pow(1024, $pow);

		return round($bytes, $precision) . ' ' . $units[$pow]; 
	}

	/**
	 * Get file info
	 * 
	 * @param  object $file
	 * @return string
	 */
	public function getFileInfo($file)
	{
		return ($file->is_image) ? $file->w . ' x ' . $file->h : $this->formatFileSize($file->size);
	}

	/**
	 * Get real path of a file
	 * 
	 * @param  string $file_name
	 * @return string
	 */
	public function getFilePath($file_name)
	{
		return public_path(\Pongo::settings('upload_path') . $this->getFolderName($file_name) . $file_name);
	}

	/**
	 * Get folder name where to copy uploaded file
	 * 
	 * @param  string $file_name
	 * @return string
	 */
	public function getFolderName($file_name)
	{
		if($this->isImage($file_name)) {

			return 'img/';

		} else {

			return $this->fileExtension($file_name) . '/';
		}
	}

	/**
	 * Get public folder http path
	 * 
	 * @param $path
	 * @return string
	 */
	public function getFolderPublic($path = '')
	{
		$path_arr = explode('/', public_path());

		return '/' . end($path_arr).($path ? '/'.$path : $path);;
	}

	/**
	 * Get http path of a file
	 * 
	 * @param  string $file_name
	 * @return string
	 */
	public function getHttpPath($file_path)
	{
		return asset($file_path);
	}

	/**
	 * Check if file is not an Image
	 * 
	 * @param  string  $file_name
	 * @return boolean
	 */
	public function isFile($file_name)
	{
		return ($this->isImage($file_name)) ? false : true;
	}

	/**
	 * Check if file is a Image
	 * 
	 * @param  string  $file_name
	 * @return boolean
	 */
	public function isImage($file_name)
	{
		$images = array('bmp', 'gif', 'jpg', 'jpeg', 'png');

		$ext = $this->fileExtension($file_name);

		return (in_array($ext, $images)) ? true : false;
	}


}