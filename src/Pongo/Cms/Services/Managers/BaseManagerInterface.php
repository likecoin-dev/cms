<?php namespace Pongo\Cms\Services\Managers;

interface BaseManagerInterface {
	public function create($id);
	public function delete($id);
	public function update($id);
	public function errors();
	public function redirect($route);
	public function success();
	public function with(array $input);
	
}