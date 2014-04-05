<?php namespace Pongo\Cms\Services\Managers;

interface BaseManagerInterface {

	public function create($id);

	public function delete($id);

	public function update($id);
	
}