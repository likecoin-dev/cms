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
	 * [$validator description]
	 * @var [type]
	 */
	protected $validator;

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
		if( ! empty($this->data)) {
			$this->rules = $this->formatRules();
		}
		
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
	 * Format custom validation rule parameters
	 * @return array
	 */
	private function formatRules()
	{
		foreach ($this->rules as $field => $rule) {
			foreach ($this->data as $var) {
				if(array_key_exists($var, $this->input)) {
					$rules[$field] = str_replace('{'.$var.'}', $this->input[$var], $rule);
				}
			}
		}
		return $rules;
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
				$error_msg[$name] = t($errors->first($name));
			}
		}
		return array(
			'status' 	=> 'error',
			'msg'		=> t($msg),
			'errors'	=> $error_msg
		);
	}
	
}