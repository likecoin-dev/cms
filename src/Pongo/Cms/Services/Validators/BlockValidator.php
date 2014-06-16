<?php namespace Pongo\Cms\Services\Validators;

class BlockValidator extends BaseValidator {

	protected $rules = array(
		'settings' => array(
			'name' 		=> 'required|min:2|unique:blocks,name,{id}',
			'attrib'	=> 'required|min:2|alpha_dash|unique:blocks,attrib,{id}',
		),

		'content' => array(
			
		),
	
	);

	protected $messages = array(
		'alpha_dash'		=> 'validation.errors.alpha_dash',
		'min' 				=> 'validation.errors.min',
		'required' 			=> 'validation.errors.required',
		'unique' 			=> 'validation.errors.unique',
	);

}