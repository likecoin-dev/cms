<?php namespace Pongo\Cms\Services\Validators;

use Illuminate\Validation\Factory as PongoValidator;

abstract class BaseValidator implements ValidatorInterface {

	/**
	 * [$input description]
	 * @var [type]
	 */
	public $input = array();

	/**
	 * [$data description]
	 * @var [type]
	 */
	public $data = array();

	/**
	 * [$section description]
	 * @var [type]
	 */
	public $section;

	/**
	 * [$validator description]
	 * @var [type]
	 */
	protected $validator;

	/**
	 * [$custom_rules description]
	 * @var array
	 */
	public $custom_rules;

	/**
	 * [$custom_messages description]
	 * @var array
	 */
	public $custom_messages;

	/**
	 * [$errors description]
	 * @var array
	 */
	protected $errors = array();

	/**
	 * [$rules description]
	 * @var array
	 */
	protected $rules = array();

	/**
	 * [$messages description]
	 * @var array
	 */
	protected $messages = array();

	/**
	 * BaseValidator constructor
	 */
	public function __construct(PongoValidator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Make the validation
	 * @return bool
	 */
	public function passes()
	{
		// Check if custom rules exist
		if( ! empty($this->custom_rules)) {
			$rules = empty($this->data) ?
				$this->createCustomRules() :
				$this->formatRules($this->createCustomRules());
			$messages = $this->createCustomMessages($rules);
		} else {
			$rules = empty($this->data) ?
				$this->rules[$this->section] :
				$this->formatRules($this->rules[$this->section]);
			$messages = $this->formatMessages();
		}
		// Set new rules and messages
		$this->rules = $rules;
		$this->messages = $messages;

		// Make validation
		$validator = $this->validator->make(
			$this->input,
			$this->rules,
			$this->messages
		);

		if($validator->fails())	{
			$this->errors = $validator->messages();
			return false;
		}
		return true;
	}

	/**
	 * [createCustomRules description]
	 * @return [type] [description]
	 */
	private function createCustomRules()
	{
		foreach ($this->custom_rules as $field => $value) {
			$rules[$field] = $value;
		}
		return $rules;
	}

	/**
	 * [createCustomMessages description]
	 * @param  [type] $rules [description]
	 * @return [type]        [description]
	 */
	private function createCustomMessages($rules)
	{
		foreach($rules as $rule) {
			$rules_arr = explode('|', $rule);
			foreach ($rules_arr as $rule_name) {				
				$name = str_replace(strstr($rule_name, ':'), '', $rule_name);
				$rule_msg[$name] = t('validation.errors.' . $name);
			}
		}
		return $rule_msg;
	}

	/**
	 * Format custom validation rule parameters
	 * @return array
	 */
	private function formatRules($rules)
	{
		foreach ($rules as $field => $rule) {
			foreach ($this->data as $var) {
				if(array_key_exists($var, $this->input)) {
					$rule = str_replace('{'.$var.'}', $this->input[$var], $rule);
				}
			}
			$rules[$field] = $rule;
		}
		return $rules;
	}

	/**
	 * [formatMessages description]
	 * @return [type] [description]
	 */
	private function formatMessages()
	{
		foreach ($this->messages as $rule => $message) {
			$msg[$rule] = t($message);
		}
		return $msg;
	}

	/**
	 * [fails description]
	 * @return [type] [description]
	 */
	public function fails()
	{
		return ! $this->passes();
	}

	/**
	 * [errors description]
	 * @return [type] [description]
	 */
	public function errors($msg = 'alert.error.input_validator')
	{
		return $this->formatErrors($msg);
	}

	/**
	 * Format errors array
	 * 
	 * @return array
	 */
	private function formatErrors($msg)
	{
		$errors = $this->errors;
		foreach ($this->rules as $name => $rule) {
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
	 * Format upload errors array
	 * 
	 * @return array
	 */
	public function uploadErrors()
	{
		$errors = $this->errors;
		foreach ($this->rules[$this->section] as $name => $rule) {
			if($errors->has($name)) {
				$error_msg[$name] = t($errors->first($name));
			}
		}

		return array(
			'status' 	=> 'error',
			'icon'		=> 'fa fa-times error',
			'errors'	=> $error_msg
		);
	}

	/**
	 * [uploadValidate description]
	 * @param  string $section [description]
	 * @return [type]          [description]
	 */
	public function uploadValidate($section = 'files')
	{
		// Make validation
		$validator = $this->validator->make(
			$this->input,
			$this->rules[$section],
			$this->messages
		);

		if($validator->fails())	{
			$this->errors = $validator->messages();
			return false;
		}
		return true;
	}
	
}