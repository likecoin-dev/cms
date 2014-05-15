<?php namespace Pongo\Cms\Services\Validators;

class PageValidator extends BaseValidator {

	protected $rules = array(
		'settings' => array(
			'name' 		=> 'required|min:2|unique:pages,name,{id},id,lang,{lang}',
			'slug'		=> 'required|min:2|unique_slug:{id},{lang}',
		),

		'layout' => array(
			'template'		=> 'required',
			'header'		=> 'required',
			'layout'		=> 'required',
			'footer'		=> 'required',
		),

		'seo' => array(
			'title'		=> 'required|max:70',
			'descr'		=> 'required|max:250',
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