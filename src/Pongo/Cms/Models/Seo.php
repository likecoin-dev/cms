<?php namespace Pongo\Cms\Models;

use Pongo\Cms\Models\Observers\SeoObserver;

class Seo extends BaseModel {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'seo';

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
	 * [seoble description]
	 * @return [type] [description]
	 */
	public function seoable()
    {
        return $this->morphTo();
    }

	/**
	 * [boot description]
	 * @return [type] [description]
	 */
	public static function boot()
	{
		parent::boot();
		self::observe(new SeoObserver);
	}

}