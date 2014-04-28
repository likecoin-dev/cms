<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\RoleManager;

class RoleController extends ApiController {

	public function __construct(RoleManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager; 
	}

	/**
	 * Create a new empty role
	 * @return [type] [description]
	 */
	public function create()
	{
		if ($this->manager->createEmptyRole()) {
			return $this->manager->success();
		}
	}

	/**
	 * [delete description]
	 * @return [type] [description]
	 */
	public function delete()
	{
		if ($this->manager->withInput()->deleteRole()) {
			return $this->manager->success();
		}
	}

	/**
	 * Move role order
	 * 
	 * @return string json encoded object
	 */
	public function move()
	{
		if ($this->manager->withInput()->moveRole()) {
			return $this->manager->success();
		}
	}

	/**
	 * Save the role model
	 * @return json object
	 */
	public function save()
	{
		if ($this->manager->withInput('id')->saveRole()) {
			return $this->manager->redirectTo('roles');
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
		if ($this->manager->withInput()->validRole()) {
			return $this->manager->success();
		}
	}





















	/**
	 * Delete role and detach related users
	 * 
	 * @return void
	 */
	public function roleSettingsDelete()
	{
		if(\Input::has('role_id') and \Input::has('name')) {

			$role_id = \Input::get('role_id');

			$role_name = \Input::get('name');

			if( ! \Access::isSystemRole($role_name)) {

				$role = $this->role->getRole($role_id);

				if(\Input::has('force_delete')) {

					$this->role->deleteRoleUsers($role);
				}

				$this->role->deleteRole($role);

				\Alert::success(t('alert.success.role_deleted'))->flash();

				return \Redirect::route('role.settings');

			} else {

				\Alert::error(t('alert.error.role_system'))->flash();

				return \Redirect::back();
			}

		} else {

			\Alert::error(t('alert.error.role_deleted'))->flash();

			return \Redirect::back();
		}

	}

	/**
	 * Save role settings
	 * 
	 * @return json object
	 */
	public function roleSettingsSave()
	{
		if(\Input::has('role_id')) {

			$input = \Input::all();

			$v = new SettingsValidator($input['role_id']);

			if($v->passes()) {

				extract($input);

				$role = $this->role->getRole($role_id);

				// Author can edit the page
				if(is_array($unauth = \Access::grantEdit('access.roles')))
					return json_encode($unauth);
				
				$role->name = $name;

				$this->role->saveRole($role);

				$response = array(
					'status' 	=> 'success',
					'msg'		=> t('alert.success.save'),
					'role'	=> array(

						'id' 		=> $role_id,
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
	 * Reorder page elements
	 * 
	 * @return string json encoded object
	 */
	public function orderRoles()
	{
		if(\Input::has('roles')) {

			$mod_roles = json_decode(\Input::get('roles'), true);
			
			foreach ($mod_roles as $key => $role_arr) {

				$role = $this->role->getRole($role_arr['id']);

				// Process non sys roles only
				if( ! \Access::isSystemRole($role->name)) {
					
					if(array_key_exists($key-1, $mod_roles)) {

						$prev_role = $this->role->getRole($mod_roles[$key-1]['id']);

						$role->level = $prev_role->level - 1;

						if($role->level == 0) $role->level = 1;

						$this->role->saveRole($role); 
					}
				}		
			}

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.element_order')
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.element_order')
			);

		}		

		return json_encode($response);
	}

}