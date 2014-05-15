<?php namespace Pongo\Cms\Services\Validators;

class BlockValidator extends BaseValidator {

	protected $rules = array(
		'settings' => array(
			'name' 		=> 'required|min:2|unique:pages,name,{id},id,lang,{lang}',
			'slug'		=> 'required|min:2|unique_slug:{id},{lang}',
		),

		'content' => array(
			'template'		=> 'required',
			'header'		=> 'required',
			'layout'		=> 'required',
			'footer'		=> 'required',
		),
	
	);

	protected $messages = array(
		'max' 				=> 'validation.errors.max',
		'min' 				=> 'validation.errors.min',
		'required' 			=> 'validation.errors.required',
		'unique' 			=> 'validation.errors.unique',
		'unique_slug'		=> 'validation.errors.unique_slug',
	);

}