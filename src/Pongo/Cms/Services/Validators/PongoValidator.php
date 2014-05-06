<?php namespace Pongo\Cms\Services\Validators;

use Illuminate\Validation\Validator as LaravelValidator;

class PongoValidator extends LaravelValidator {
	
	public function validateAccess($attribute, $value, $parameters)
	{
		return false;
	}

	public function validateCurrentPassword($attribute, $value, $parameters)
	{
		return \Auth::validate(array('username' => USERNAME, 'password' => $value));
		/*D($attribute);
		D($value);
		D($parameters, true);*/
	}

}