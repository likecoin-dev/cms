<?php namespace Pongo\Cms\Classes;

class Img {

	/**
	 * Image compression quality
	 * 
	 * @var int
	 */
	private $image_quality;

	/**
	 * Theme's thumb settings
	 * 
	 * @var array
	 */
	private $thumb = array();

	/**
	 * Upload path
	 * 
	 * @var string
	 */
	private $upload_path;

	protected $pongo;

	protected $theme;

	/**
	 * Class constructor
	 * 
	 * @param File $file
	 */
	public function __construct(Pongo $pongo, Theme $theme)
	{
		$this->image_quality = $pongo->settings('image_quality');

		$this->upload_path = public_path($pongo->settings('upload_path').'img');

		$this->thumb = $theme->config('thumb');
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