<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Pongo\Cms\Services\Search\Search;
use Illuminate\Events\Dispatcher as Events;
use Pongo\Cms\Services\Validators\UserValidator as Validator;
use Pongo\Cms\Repositories\UserRepositoryInterface as User;
use Pongo\Cms\Repositories\UserDetailRepositoryInterface as UserDetail;

class UserManager extends BaseManager {

	public function __construct(Access $access, Search $search, Events $events, Validator $validator, User $user, UserDetail $userdetail)
	{
		$this->access = $access;
		$this->events = $events;
		$this->validator = $validator;
		$this->model = $user;
		$this->related['details'] = $userdetail;

		$this->section = 'users';

		// Enabling search
		$this->search = $search;
		$this->search->model = $this->model;
	}

	/**
	 * Create a new empty role
	 * @return bool
	 */
	public function createEmptyUser()
	{
		$msg = t('alert.success.user_created');

		$user_account = \Pongo::settings('user_account');
		
		$default_user = array(
			'role_id'	=> $user_account['role_id'],
			'username' 	=> $user_account['username'],
			'email'		=> $user_account['email'],
			'password'	=> \Hash::make($user_account['password']),
			'lang'		=> CMSLANG,
			'editor'	=> 0,
			'is_active' => 0
		);

		$user = $this->model->create($default_user);
		$this->events->fire('user.create', array($user));
		$this->related['details']->createUserDetails($user->id);

		$response = array(
			'render'		=> 'user',
			'status' 		=> 'success',
			'msg'			=> $msg,
			'id'			=> $user->id,
			'username'		=> $user_account['username'],
			'url_edit'		=> route('user.edit', array('user_id' => $user->id)),
			'url_delete'	=> route('api.user.delete', array('user_id' => $user->id))
		);

		return $this->setSuccess($response);
	}

	/**
	 * [deleteRole description]
	 * @return [type] [description]
	 */
	public function deleteUser()
	{
		$user_id = $this->input['item_id'];

		if($this->delete($user_id)) {

			$this->events->fire('user.delete', array($this->related['details'], $user_id));

			$response = array(
				'remove' 	=> $user_id,
				'status' 	=> 'success',
				'msg'		=> t('alert.success.user_deleted')
			);

			return $this->setSuccess($response);

		} else {

			return $this->setError('alert.error.user_deleted');
		}
		
	}

	/**
	 * Get full list of roles
	 * @return array
	 */
	public function getUsersList()
	{
		return $this->model->getUsersWithRole(XPAGE, LEVEL);
	}

	/**
	 * [saveUserSettings description]
	 * @return [type] [description]
	 */
	public function saveUserSettings()
	{
		if($check = $this->canEdit()) {

			if ($this->validator->fails()) {

				return $this->setError($this->validator->errors());

			} else {

				$id = $this->input['id'];
				$user = $this->model->find($id);
				$user->username = $this->input['username'];
				$user->email = $this->input['email'];
				$user->editor = $this->input['editor'];
				$user->lang = $this->input['lang'];
				$user->save();

				$this->events->fire('user.save.settings', array($user));
				return $this->setSuccess('alert.success.save');
			}

		} else {

			return $check;
		}
	}

	/**
	 * [saveUserPassword description]
	 * @return [type] [description]
	 */
	public function saveUserPassword()
	{
		if($check = $this->canEdit()) {

			if ($this->validator->fails()) {

				return $this->setError($this->validator->errors());

			} else {
				
				$id = $this->input['id'];
				$user = $this->model->find($id);
				$user->password = \Hash::make($this->input['password']);
				$user->save();
				
				return $this->setSuccess('alert.success.save');
			}

		} else {

			return $check;
		}
	}

	/**
	 * [saveUserDetails description]
	 * @return [type] [description]
	 */
	public function saveUserDetails()
	{
		if($check = $this->canEdit()) {

			if ($this->validator->fails()) {

				return $this->setError($this->validator->errors());

			} else {

				return $this->saveCustomForm('details', 'user_details');
			}

		} else {

			return $check;
		}
	}

	/**
	 * [roleUser description]
	 * @return [type] [description]
	 */
	public function roleUser()
	{
		if($this->input) {

			$role_id = $this->input['item_id'];
			$user_id = $this->input['user_id'];
			
			if(\Pongo::settings('admin_account.id') == $user_id) {
				
				return $this->setError('alert.error.user_admin_role');
				
			} else {
				
				$user = $this->model->find($user_id);
				$user->role_id = $role_id;
				$user->save();

				$this->events->fire('user.changerole', array($user, $user->role));

				return $this->setSuccess('alert.success.role_modified');
			}
		}
	}

	/**
	 * [validRole description]
	 * @return [type] [description]
	 */
	public function validUser()
	{
		if($this->input) {
			
			$user_id = $this->input['item_id'];
			$value = $this->input['action'];
			$user = $this->model->find($user_id);
			$user->is_active = $value;
			$user->save();
			
			return $this->setSuccess('alert.success.user_modified');
		}
	}

}