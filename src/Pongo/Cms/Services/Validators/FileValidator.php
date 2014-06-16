<?php namespace Pongo\Cms\Services\Validators;

class FileValidator extends BaseValidator {

	protected $rules = array(		
		'create' => array(
			'file_size'  => 'required|integer',
			'file_name'  => 'required|not_image|file_mimes|unique_file'
		),

		'files' => array(
			'file_name' => 'unique_file',
			'file_size' => 'file_size',
			'ext_mimes' => 'ext_mimes'
		)
	);

	protected $messages = array(		
		'ext_mimes' 	=> 'validation.errors.ext_mimes',
		'file_mimes'	=> 'validation.errors.file_mimes',
		'file_size' 	=> 'validation.errors.file_size',
		'not_image'		=> 'validation.errors.not_image',		
		'unique_file' 	=> 'validation.errors.unique_file',
	);

}