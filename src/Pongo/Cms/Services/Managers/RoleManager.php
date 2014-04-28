<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Pongo\Cms\Services\Validators\RoleValidator as Validator;
use Pongo\Cms\Repositories\RoleRepositoryInterface as Role;

class RoleManager extends BaseManager {

	public function __construct(Access $access, Validator $validator, Role $role)
	{
		$this->access = $access;
		$this->validator = $validator;
		$this->model = $role;
	}

	/**
	 * Create a new empty role
	 * @return bool
	 */
	public function createEmptyRole()
	{
		$name = t('template.role.new');
		$msg = t('alert.success.role_created');
		
		$default_role = array(
			'name' 		=> $name,
			'level' 	=> 2,		// Set as 'user'+1 level
			'is_valid'	=> 0
		);

		$role = $this->model->create($default_role);

		$response = array(
			'render'		=> 'role',
			'status' 		=> 'success',
			'msg'			=> $msg,
			'id'			=> $role->id,
			'name'			=> $name,
			'url_edit'		=> route('role.edit', array('role_id' => $role->id)),
			'url_delete'	=> route('api.role.delete', array('role_id' => $role->id))
		);

		return $this->setSuccess($response);
	}

	/**
	 * [deleteRole description]
	 * @return [type] [description]
	 */
	public function deleteRole()
	{
		$role_id = $this->input['item_id'];
		if($this->delete($role_id)) {

			\Event::fire('role.delete', array($role_id));

			$response = array(
				'remove' 	=> $role_id,
				'status' 	=> 'success',
				'msg'		=> t('alert.success.role_deleted')
			);

			return $this->setSuccess($response);
		}
		return false;
	}

	/**
	 * Get full list of roles
	 * @return array
	 */
	public function getRolesList()
	{	
		return $this->model->getRolesListPaginate(XPAGE);
	}

	/**
	 * Reorder roles
	 * 
	 * @return string json encoded object
	 */
	public function moveRole()
	{
		if($this->input) {
			
			$roles = get_json('items');

			foreach ($roles as $key => $role_arr) {
				$role = $this->model->find($role_arr['id']);
				// Process non sys roles only
				if( ! \Access::isSystemRole($role->name)) {					
					if(array_key_exists($key-1, $roles)) {
						$prev_role = $this->model->find($roles[$key-1]['id']);
						$role->level = $prev_role->level - 1;
						if($role->level <= 0) $role->level = 0;
						$role->save();
					}
				}		
			}

			return $this->setSuccess('alert.success.element_order');
		}
	}

	/**
	 * [saveRole description]
	 * @return [type] [description]
	 */
	public function saveRole()
	{
		if ($this->validator->fails()) {
			return $this->setError($this->validator->errors());
		} else {
			$id = $this->input['id'];
			$role = $this->model->find($id);
			$role->name = $this->input['name'];
			$role->save();
			return true;
		}
	}

	/**
	 * [validRole description]
	 * @return [type] [description]
	 */
	public function validRole()
	{
		if($this->input) {
			$role_id = $this->input['item_id'];
			$value = $this->input['action'];
			$role = $this->model->find($role_id);
			$role->is_valid = $value;
			$role->save();
			return $this->setSuccess('alert.success.role_modified');
		}
	}

}