<?php namespace Pongo\Cms\Services\Validators;

class UserValidator extends BaseValidator {

	protected $rules = array(
		'settings' => array(
			'username' 	=> 'required|min:2|max:20|unique:users,username,{id}',
			'email'		=> 'required|email|unique:users,email,{id}',
		),
		'password' => array(
			'password_now' 	=> 'required|current_password',
			'password' 		=> 'required|min:8|confirmed',
		),		
	);

	protected $messages = array(
		'confirmed'			=> 'validation.errors.confirmed',
		'current_password' 	=> 'validation.errors.current_password',
		'email'				=> 'validation.errors.email',
		'max'				=> 'validation.errors.max',
		'min' 				=> 'validation.errors.min',
		'required' 			=> 'validation.errors.required',
		'unique' 			=> 'validation.errors.unique',
	);

}