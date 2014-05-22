<?php namespace Pongo\Cms\Services\Picture;

interface PictureInterface {
	public function make($path);
	public function save($image, $file_name);
	public function thumb($image, $file_name, $thumb_type);
}