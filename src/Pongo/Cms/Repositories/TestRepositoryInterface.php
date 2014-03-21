<?php namespace Pongo\Cms\Repositories;

interface TestRepositoryInterface {

	public function getById($model_id);

	public function getAll();

	public function getModel();
	
}