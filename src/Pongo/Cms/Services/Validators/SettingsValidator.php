<?php namespace Pongo\Cms\Services\Validators;

class SettingsValidator extends BaseValidator {

	protected $rules = array(
		'settings' => array(
			'theme' => 'required',
		)
	);

	protected $messages = array(
		'required' 	=> 'validation.errors.required'
	);

}