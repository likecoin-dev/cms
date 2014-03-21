<?php namespace Pongo\Cms\Services\Validators;

use Input, Validator;

abstract class BaseValidator {

	/**
	 * Incoming POST data
	 * 					
	 * @var mix
	 */
	protected $input;

	/**
	 * Validation errors
	 * 
	 * @var object
	 */
	public $errors;

	/**
	 * Validation messages
	 * 
	 * @var array
	 */
	public static $messages;

	/**
	 * Validations rules
	 * 
	 * @var array
	 */
	public static $rules;


	public function __construct($input = null)
	{
		$this->input = $input ? $input : Input::all();
	}

	/**
	 * Format errors array
	 * 
	 * @return array
	 */
	public function formatErrors($msg = 'alert.error.input_validator')
	{
		$errors = $this->errors;

		foreach (static::$rules as $name => $rule) {

			if($errors->has($name)) {
				$error_msg[$name] = $errors->first($name);	
			}			

		}

		return array(
			'status' 	=> 'error',
			'msg'		=> t($msg),
			'errors'	=> $error_msg
		);
	}

	/**
	 * Get validation errors
	 * 
	 * @return object
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Check validation
	 * 
	 * @return bool validation result
	 */
	public function passes()
	{		
		$validation = Validator::make($this->input, static::$rules, static::$messages);

		if ($validation->passes()) return true;

		$this->errors = $validation->messages();

		return false;
	}

	/**
	 * Format upload errors array
	 * 
	 * @return array
	 */
	public function uploadErrors()
	{
		$errors = $this->errors;

		foreach (static::$rules as $name => $rule) {

			if($errors->has($name)) {
				$error_msg[$name] = $errors->first($name);	
			}			

		}

		return array(
			'status' 	=> 'error',
			'icon'		=> 'fa fa-times error',
			'errors'	=> $error_msg
		);
	}

}