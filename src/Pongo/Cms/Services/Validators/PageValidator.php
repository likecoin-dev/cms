<?php namespace Pongo\Cms\Services\Validators;

class PageValidator extends BaseValidator {

	protected $rules = array(
		'name' => 'required|min:2',
		'slug' => 'required'
	);

	protected $messages = array(
		'required' 	=> 'validation.errors.required',
		'min' 		=> 'validation.errors.min'
	);

}