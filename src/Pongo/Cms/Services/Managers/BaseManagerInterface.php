<?php namespace Pongo\Cms\Services\Managers;

interface BaseManagerInterface {
	public function getOne($id);
	public function getAll();
	public function getPaginate($per_page);
	public function delete($id);
	public function errors();
	public function withInputOnly();
	public function hasInput();
	public function redirect();
	public function redirectTo($route);
	public function success();
	public function with(array $input, $data);
	public function withInput($data);
	public function withFileInput($section);
	public function withSimpleInput();
}