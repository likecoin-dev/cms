<?php namespace Pongo\Cms\Services\Validators;

class LoginValidator extends BaseValidator {

	protected $rules = array(

		'username' => 'required',
		'password' => 'required'
	);

	protected $messages = array(
		
		'required' 	=> 'validation.errors.required'
	);

}