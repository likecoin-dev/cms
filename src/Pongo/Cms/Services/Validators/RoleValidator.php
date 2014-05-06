<?php namespace Pongo\Cms\Services\Validators;

class RoleValidator extends BaseValidator {

	protected $rules = array(		
		'settings' => array(		
			'name' => 'required|min:2|unique:roles,name,{id}'
		)
	);

	protected $messages = array(
		'required' 	=> 'validation.errors.required',
		'min' 		=> 'validation.errors.min',
		'unique' 	=> 'validation.errors.unique'
	);

}