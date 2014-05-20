<?php namespace Pongo\Cms\Models;

use Pongo\Cms\Models\Observers\UserDetailObserver;

class UserDetail extends BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_details';

	/**
	 * Append virtual values
	 * 
	 * @var array
	 */
	protected $appends = array('birth_day', 'birth_month', 'birth_year');

	/**
	 * Timestamp needed
	 * 
	 * @var boolean
	 */
	public $timestamps = true;

	/**
	 * Guarded mass-assignment property
	 * 
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * User relationship
	 * Each detail has one user
	 * 
	 * @return mixed
	 */
	public function user()
	{
		return $this->belongsTo('Pongo\Cms\Models\User', 'user_id');
	}

	// CUSTOM ATTRIBUTES

	public function getBirthDayAttribute()
	{
		$d = \Tool::validateDate($this->attributes['birth_date'], 'Y-m-d');

		return $d ? \Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['birth_date'])->day
				  : \Carbon\Carbon::now()->day;
	}

	public function getBirthMonthAttribute()
	{
		$d = \Tool::validateDate($this->attributes['birth_date'], 'Y-m-d');

		return $d ? \Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['birth_date'])->month
				  : \Carbon\Carbon::now()->month;
	}

	public function getBirthYearAttribute()
	{
		$d = \Tool::validateDate($this->attributes['birth_date'], 'Y-m-d');

		return $d ? \Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['birth_date'])->year
				  : \Carbon\Carbon::now()->year;
	}

	/**
	 * [boot description]
	 * @return [type] [description]
	 */
	public static function boot()
	{
		parent::boot();
		self::observe(new UserDetailObserver);
	}

}