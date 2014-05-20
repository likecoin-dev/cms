<?php namespace Pongo\Cms\Services\Validators;

interface ValidatorInterface {

	/**
	 * [passes description]
	 * @return [type] [description]
	 */
	public function passes();

	/**
	 * [fails description]
	 * @return [type] [description]
	 */
	public function fails();

	/**
	 * [errors description]
	 * @return [type] [description]
	 */
	public function errors($msg);

	/**
	 * [uploadValidate description]
	 * @param  [type] $section [description]
	 * @return [type]          [description]
	 */
	public function uploadValidate($section);

}