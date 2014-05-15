<?php namespace Pongo\Cms\Services\Validators;

use App, Auth, Pongo;
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