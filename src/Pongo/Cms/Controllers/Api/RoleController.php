<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Support\Repositories\RoleRepositoryInterface as Role;

use Pongo\Cms\Support\Validators\Role\SettingsValidator as SettingsValidator;

class RoleController extends ApiController {

	/**
	 * Default system roles
	 * 
	 * @var int
	 */
	private $system_roles;

	/**
	 * Class constructor
	 * @param Page    $page 
	 * @param Element $element
	 */
	public function __construct(Role $role)
	{
		parent::__construct();

		$this->role = $role;

		$this->system_roles = \Pongo::system('roles');
	}

	/**
	 * Create a new Role
	 * 
	 * @return json object
	 */
	public function createRole()
	{
		if(\Input::has('create')) {

			$role_name = t('template.role.new');

			$role_arr = array(
				'name' 		=> $role_name,
				'level' 	=> 1
			);

			$new_role = $this->role->createRole($role_arr);

			$response = array(
				'status' 	=> 'success',
				'msg'		=> t('alert.success.role_created'),
				'id'		=> $new_role->id,
				'name'		=> $new_role->name,
				'url'		=> route('role.settings', array('role_id' => $new_role->id)),
				'cls'		=> 'new'
			);

		} else {

			$response = array(
				'status' 	=> 'error',
				'msg'		=> t('alert.error.role_created')
			);

		}

		return json_encode($response);
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