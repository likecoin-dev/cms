<?php namespace Pongo\Cms\Models;

class Role extends BaseModel {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * No timestamp needed
	 * 
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Guarded mass-assignment property
	 * 
	 * @var array
	 */
	protected $guarded = array('id');
	
	/**
	 * Users relationship
	 * Each role has many users
	 * 
	 * @return mixed
	 */
	public function users()
	{
		return $this->hasMany('Pongo\Cms\Models\User');
	}



}