<?php namespace Pongo\Cms\Controllers;

use Pongo\Cms\Classes\Access as Access;
use Pongo\Cms\Repositories\UserDetailRepositoryInterface as UserDetail;
use Pongo\Cms\Services\Validators\TestValidator as TestValidator;
use Pongo\Cms\Services\Managers\CreateManager as CreateManager;

use Controller, Response;

class TestController extends Controller {
	
	private $test;

	private $validator;

	public function __construct(UserDetail $user, Access $access, TestValidator $validator)
	{
		$this->user = $user;
		$this->access = $access;
		$this->validator = $validator;
	}

	public function create()
	{
		/*$manager = new CreateManager($this->test, $this->access, $this->validator);

		$resp = $manager->save(Input::all());

		return Response::json($resp);*/
	}

	public function testing()
	{
		return $this->user->createUserDetails(100);
	}

}