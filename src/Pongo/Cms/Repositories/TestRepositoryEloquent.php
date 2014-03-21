<?php namespace Pongo\Cms\Repositories;

use Pongo\Cms\Models\Test as Test;

class TestRepositoryEloquent extends BaseRepositoryEloquent implements TestRepositoryInterface {

	/**
	 * @var Test model
	 */
	protected $model;

	function __construct(Test $model)
	{
		$this->model = $model;
	}
	
}