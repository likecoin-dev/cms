<?php namespace Pongo\Cms\Classes;

use Pongo\Cms\Classes\Pongo as Pongo;
use Pongo\Cms\Classes\Theme as Theme;

class Picture {

	/**
	 * Theme's thumb settings
	 * 
	 * @var array
	 */
	public static $thumb = array();

	/**
	 * Image compression quality
	 * 
	 * @var int
	 */
	public static $image_quality = \Pongo::settings('image_quality');

	/**
	 * Upload path
	 * 
	 * @var string
	 */
	public static $upload_path = public_path(\Pongo::settings('upload_path').'img');

	/**
	 * [$theme description]
	 * @var [type]
	 */
	protected $theme;

	/**
	 * Class constructor
	 * 
	 * @param File $file
	 */
	public function __construct(Theme $theme)
	{
		$this->theme = $theme;
	}

	/**
	 * Create a new thumb
	 * 
	 * @param  object $image
	 * @param  string $thumb_name
	 * @param  string $thumb
	 * @return void
	 */
	public function createThumb($image, $file_name, $thumb = 'cms')
	{
		$w = $this->thumb[$thumb]['width'];

		$h = $this->thumb[$thumb]['height'];

		$image->cropMaximumInPixel(0, 0, "MM");

		$image->resizeInPixel($w, $h);

		$thumb_name = \Media::formatFileThumb($file_name);

		$this->save($image, $thumb_name);
	}

	/**
	 * Get image instance through ImageWorkshop
	 * 
	 * @param  string $file_path
	 * @return object
	 */
	public function get($file_path)
	{
		// return $this->ImageWorkshop->initFromPath($file_path);
	}

	/**
	 * Save thumb to /img path
	 * 
	 * @param  object $image
	 * @param  string $thumb_name
	 * @return void
	 */
	public function save($image, $thumb_name)
	{
		$image->save($this->upload_path, $thumb_name, true, null, $this->image_quality);
	}

	/**
	 * Generate an img tag to thumb
	 * 
	 * @param  string $img_path
	 * @param  string $thumb
	 * @param  string $alt
	 * @return string
	 */
	public function showThumb($img_path, $thumb = 'cms', $alt = '')
	{
		$path_arr = explode('/', $img_path);
		
		$file_name = end($path_arr);

		if(\Media::isImage($file_name)) {

			$thumb_name = \Media::formatFileThumb($file_name, $thumb);

			$thumb_path = str_replace($file_name, $thumb_name, $img_path);

			return \HTML::image($thumb_path, $alt, array('class' => 'cms-thumb', 'width' => $this->thumb[$thumb]['width'], 'height' => $this->thumb[$thumb]['height']));

		} else {

			$ext = \Media::fileExtension($file_name);

			return '<span class="cms-thumb">'.$ext.'</span>';

		}
	}

}