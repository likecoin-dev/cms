<?php namespace Pongo\Cms\Services\Validators;

class FileValidator extends BaseValidator {

	protected $rules = array(
		'files' => array(
			'file_name' => 'unique_file',
			'file_size' => 'file_size',
			'ext_mimes' => 'ext_mimes'
		)
	);

	protected $messages = array(
		'unique_file' 	=> 'validation.errors.unique_file',
		'file_size' 	=> 'validation.errors.file_size',
		'ext_mimes' 	=> 'validation.errors.ext_mimes',
	);

}