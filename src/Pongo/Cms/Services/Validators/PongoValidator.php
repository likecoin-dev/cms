<?php namespace Pongo\Cms\Services\Validators;

use App, Auth, Pongo, Media, Str;
use Illuminate\Validation\Validator as LaravelValidator;

class PongoValidator extends LaravelValidator {

	/**
	 * [validateCurrentPassword description]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function validateCurrentPassword($attribute, $value, $parameters)
	{
		return Auth::validate(array('username' => USERNAME, 'password' => $value));
	}

	/**
	 * [validateExtMimes description]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function validateExtMimes($attribute, $value, $parameters)
	{
		$ext = $value;

		// $mimes = str_replace(' ', '', Pongo::settings('mimes'));

		// $mimes_arr = explode(',', $mimes);
		$mimes_arr = array_keys(\Pongo::settings('mimes'));

		return (in_array($ext, $mimes_arr)) ? true : false;
	}

	/**
	 * [validateFileSize description]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function validateFileSize($attribute, $value, $parameters)
	{
		$max_size = Pongo::settings('max_upload_size') * 1024000;

		return (is_int($value) and $value < $max_size);
	}

	/**
	 * [validateIsSlug description]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function validateIsSlug($attribute, $value, $parameters)
	{
		return $value == Str::slug(str_replace('_', '-', $value));
	}

	/**
	 * [validateUniqueFile description]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function validateUniqueFile($attribute, $value, $parameters)
	{
		$file_name = Media::formatFileName($value);

		$upload_path = Pongo::settings('upload_path');

		$folder_name = Media::getFolderName($file_name);

		$file_path = public_path($upload_path . $folder_name . $file_name);
		
		return (file_exists($file_path)) ? false : true;
	}

	/**
	 * [validateUniqueSlug description]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function validateUniqueSlug($attribute, $value, $parameters)
	{
		$page = App::make(Pongo::system('repositories.page.interface'));
		return $page->countPageWithSlug($value, $parameters[0]) == 0;
	}

}