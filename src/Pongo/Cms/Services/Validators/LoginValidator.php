<?php namespace Pongo\Cms\Services\Validators;

class LoginValidator extends BaseValidator {

	/**
	 * Validation rules and messages
	 */
	public function __construct() {
		
		parent::__construct();
		
		static::$rules = array(
			'username'		=> 'required',
			'password'		=> 'requires'
		);

		static::$messages = array(
			'required' 		=> 'Il campo è richiesto'
		);
	}
	
}