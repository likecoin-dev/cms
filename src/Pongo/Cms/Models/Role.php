<?php namespace Pongo\Cms\Models;

use Pongo\Cms\Models\Observers\RoleObserver;

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

	/**
	 * [scopeEditor description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeEditor($query)
	{
		return $query->where('level', '>=', \Access::levelEditor());
	}

	/**
	 * [scopeOrder description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeOrder($query)
	{
		return $query->orderBy('level', 'desc')
					 ->orderBy('id', 'asc');
	}

	/**
	 * [scopeHasLevel description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeHasLevel($query)
	{
		return $query->where('level', '>', 0);
	}

	/**
	 * [scopeLevelUnderEqual description]
	 * @param  [type] $query [description]
	 * @param  [type] $level [description]
	 * @return [type]        [description]
	 */
	public function scopeLevelUnderEqual($query, $level)
	{
		return $query->where('level', '<=', $level);
	}

	/**
	 * [boot description]
	 * @return [type] [description]
	 */
	public static function boot()
	{
		parent::boot();
		self::observe(new RoleObserver);
	}

}