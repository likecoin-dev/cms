<?php namespace Pongo\Cms\Services\Validators;

class TagValidator extends BaseValidator {

	protected $rules = array(
		'settings' => array(
			'name' => 'required',
		)
	);

	protected $messages = array(
		'required' 	=> 'validation.errors.required'
	);

}