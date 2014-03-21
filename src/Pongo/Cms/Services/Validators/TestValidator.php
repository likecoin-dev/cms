<?php namespace Pongo\Cms\Services\Validators;

class TestValidator extends BaseValidator {

	/**
	 * Validation rules and messages
	 */
	public function __construct() {
		
		parent::__construct();
		
		static::$rules = array(
			'name'		=> 'required',
		);

		static::$messages = array(
			'required' 		=> 'Il campo è richiesto'
		);
	}
	
}