<?php namespace Pongo\Cms\Services\Validators;

class PageValidator extends BaseValidator {

	protected $rules = array(
		'settings' => array(
			'name' 		=> 'required|min:2|unique:pages,name,{id},id,lang,{lang}',
			// 'slug'		=> 'required|is_slug:{is_home}|unique_slug:{id},{lang}',
			'slug'		=> 'required|is_slug|reserved_slug|unique_slug:{id},{lang}',
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
		'is_slug'			=> 'validation.errors.is_slug',
		'max' 				=> 'validation.errors.max',
		'min' 				=> 'validation.errors.min',
		'required' 			=> 'validation.errors.required',
		'reserved_slug'		=> 'validation.errors.reserved_slug',
		'unique' 			=> 'validation.errors.unique',
		'unique_slug'		=> 'validation.errors.unique_slug',
	);

}