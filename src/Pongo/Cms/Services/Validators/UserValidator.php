<?php namespace Pongo\Cms\Services\Validators;

class UserValidator extends BaseValidator {

	protected $rules = array(
		'name' => 'required|min:2|unique:roles,name,{id}'
	);

	protected $messages = array(
		'required' 	=> 'validation.errors.required',
		'min' 		=> 'validation.errors.min',
		'unique' 	=> 'validation.errors.unique'
	);

}