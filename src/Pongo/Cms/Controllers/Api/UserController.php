<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\UserManager;

class UserController extends ApiController {

	public function __construct(UserManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager;
	}

	/**
	 * Create a new empty user
	 * @return [type] [description]
	 */
	public function create()
	{
		if ($this->manager->createEmptyUser()) {
			return $this->manager->success();
		}
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		if ($this->manager->withInput()->deleteUser()) {
			return $this->manager->success();
		}
	}

	/**
	 * Save the role model
	 * @return json object
	 */
	public function save()
	{
		if ($this->manager->withInput('id')->saveUser()) {
			return $this->manager->redirectTo('users');
		} else {
			return $this->manager->errors();
		}
	}

	/**
	 * [valid description]
	 * @return [type] [description]
	 */
	public function valid()
	{
		if ($this->manager->withInput()->validUser()) {
			return $this->manager->success();
		}
	}






	/**
	 * Save user details
	 * 
	 * @return json object
	 */
	public function userDetailsSave()
	{
		if(\Input::has('user_id')) {
			
			$validation = \Build::validForm();

			if(!is_array($validation)) return $validation;

			extract($validation);

			$user = $this->user->getUser($user_id);

			if(is_array($unauth = \Access::grantEdit('access.users')))
					return json_encode($unauth);

			$user_details = $this->user->getUserDetails($user);

			foreach (\Pongo::forms('user_details') as $field => $value) {
				
				if($value['form'] == 'date') {
					
					$user_details->$field = \Carbon\Carbon::create($birth_year, $birth_month, $birth_day);

				} elseif($value['form'] == 'datetime') {

					$user_details->$field = \Carbon\Carbon::create($birth_year, $birth_month, $birth_day, $birth_hh, $birth_mm);

				} else {

					$user_details->$field = $$field;

				}
			}

			$this->user->saveUserDetails($user_details);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.save')
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.save')
			);

		}

		return json_encode($response);
	}

	/**
	 * Delete a user
	 * 
	 * @return void
	 */
	public function userSettingsDelete()
	{
		if(\Input::has('user_id')) {

			$user_id = \Input::get('user_id');

			$user = $this->user->getUser($user_id);

			$user_level = $this->user->getUserLevel($user);

			// Check if deleting last admin user
			if($user->id == 1 and $user_level == \Access::roleMaxLevel()) {

				\Alert::error(t('alert.error.user_admin'))->flash();

				return \Redirect::back();

			} else {

				// You can delete
				if(LEVEL >= $user_level) {
					
					$this->user->deleteUser($user);

					\Alert::success(t('alert.success.user_deleted'))->flash();

					return \Redirect::route('user.settings');

				} else {

					\Alert::error(t('alert.error.user_deleted'))->flash();

					return \Redirect::back();
				}				
			}

		} else {

			\Alert::error(t('alert.error.user_deleted'))->flash();

			return \Redirect::back();
		}

	}

	/**
	 * Attach user to role
	 * 
	 * @return json object
	 */
	public function userSettingsLink()
	{
		if(\Input::has('user_id') and \Input::has('role_id') and \Input::has('level')) {

			$user_id 	= \Input::get('user_id');
			$role_id 	= \Input::get('role_id');
			$level 		= \Input::get('level');

			if(\Pongo::settings('admin_account.id') == $user_id) {

				$response = array(
					'status' 	=> 'error',
					'msg'		=> t('alert.error.user_admin_role')
				);

			} else {

				$user = $this->user->getUser($user_id);

				$user->role_id = $role_id;

				$this->user->saveUser($user);

				if($user_id == USERID) \Session::put('LEVEL', $level);

				$response = array(
					'status' 	=> 'success'
				);
			}			

		} else {

			$response = array(
				'status' 	=> 'error'
			);
		}

		return json_encode($response);
	}

	/**
	 * Save user settings
	 * 
	 * @return json object
	 */
	public function userSettingsSave()
	{
		if(\Input::has('user_id')) {

			$input = \Input::all();

			$v = new SettingsValidator($input['user_id']);

			if($v->passes()) {

				extract($input);

				$user = $this->user->getUser($user_id);

				if(is_array($unauth = \Access::grantEdit('access.users')))
					return json_encode($unauth);
				
				$user->username = $name;
				$user->email 	= $email;
				$user->lang 	= $lang;
				$user->editor 	= $editor;

				if($user_id == USERID) \Session::put('USERNAME', $name);

				$this->user->saveUser($user);

				$response = array(
					'status' 	=> 'success',
					'msg'		=> t('alert.success.save'),
					'user'	=> array(

						'id' 		=> $user_id,
						'name'		=> $name
						
					)
				);

			} else {

				return json_encode($v->formatErrors());

			}

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.save')
			);

		}

		return json_encode($response);
	}

	/**
	 * Save valid status
	 * 
	 * @return json object
	 */
	public function userSettingsValid()
	{
		if(\Input::has('item_id') and \Input::has('action')) {

			$user_id 	= \Input::get('item_id');
			$valid 		= \Input::get('action');

			$user = $this->user->getUser($user_id);

			$user->is_valid = $valid;

			$this->user->saveUser($user);

			$response = array(
				'status' 	=> 'success'
			);

		} else {

			$response = array(
				'status' 	=> 'error'
			);
		}

		return json_encode($response);
	}

	/**
	 * Save user password
	 * 
	 * @return json object
	 */
	public function userPasswordSave()
	{
		if(\Input::has('user_id')) {

			$input = \Input::all();

			$v = new PasswordValidator($input['user_id']);

			if($v->passes()) {

				extract($input);

				$user = $this->user->getUser($user_id);

				if(is_array($unauth = \Access::grantEdit('access.users')))
					return json_encode($unauth);
				
				$user->password = \Hash::make($password);

				$this->user->saveUser($user);

				$response = array(
					'status' 	=> 'success',
					'msg'		=> t('alert.success.save'),
					'element'	=> array(

						'id' 		=> $user_id,
						'name'		=> $name
						
					)
				);

			} else {

				return json_encode($v->formatErrors());

			}

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.save')
			);

		}

		return json_encode($response);
	}

	/**
	 * Search a user
	 * 
	 * @return json object
	 */
	public function searchUser()
	{
		if(\Input::has('search')) {

			$input = \Input::all();

			extract($input);

			$users = $this->user->searchUser($search, $field);

			$response = array();

			foreach ($users as $user) {
				
				$user_obj = array(
					'id' => $user->id,
					'cls' => 'new',
					'name' => $user->username,
					'url' => route('user.settings', array('user_id' => $user->id)),
					'checked' => ($user->is_valid) ? ' checked="checked"' : ''
				);

				$response[] = $user_obj;

			}

			return json_encode($response);
		}

	}

}