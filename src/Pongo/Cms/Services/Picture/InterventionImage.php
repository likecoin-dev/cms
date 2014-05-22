<?php namespace Pongo\Cms\Services\Picture;

use Pongo\Cms\Classes\Pongo as Pongo;
use Pongo\Cms\Classes\Media as Media;
use Intervention\Image\ImageManagerStatic as Image;

class InterventionImage implements PictureInterface {

	/**
	 * [$image description]
	 * @var [type]
	 */
	protected $image;

	/**
	 * [$media description]
	 * @var [type]
	 */
	protected $media;

	/**
	 * Theme's thumb settings
	 * 
	 * @var array
	 */
	public $thumb = array();

	/**
	 * Image compression quality
	 * 
	 * @var int
	 */
	public $image_quality;

	/**
	 * [$thumb_name description]
	 * @var [type]
	 */
	public $thumb_name;

	/**
	 * Upload path
	 * 
	 * @var string
	 */
	public $upload_path;

	public function __construct(Pongo $pongo, Media $media, Image $image)
	{
		$this->image = $image;
		$this->media = $media;

		$this->thumb = $pongo->system('thumb');
		$this->image_quality = $pongo->settings('image_quality');
		$this->upload_path = $pongo->settings('upload_path') . 'img';
	}

	/**
	 * Get image instance
	 * 
	 * @param  string $file_path
	 * @return object
	 */
	public function make($file_path)
	{
		return Image::make($file_path);
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
		$thumb_path = public_path($this->upload_path.'/'.$thumb_name);

		return $image->save($thumb_path, $this->image_quality);
	}

	/**
	 * Create a new thumb image
	 * 
	 * @param  [type] $image     [description]
	 * @param  [type] $file_name [description]
	 * @param  string $thumb     [description]
	 * @return [type]            [description]
	 */
	public function thumb($image, $file_name, $thumb = 'cms')
	{
		$w = $this->thumb[$thumb]['width'];

		$h = $this->thumb[$thumb]['height'];

		// resize to best fitting
		$image->fit($w, $h);		

		$this->thumb_name = $this->media->formatFileThumb($file_name);

		$this->save($image, $this->thumb_name);

		return $this->media->getImgPath($file_name, $thumb);
	}

}