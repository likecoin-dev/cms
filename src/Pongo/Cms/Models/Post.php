<?php namespace Pongo\Cms\Models;

use Pongo\Cms\Models\Observers\PostObserver;

class Post extends BaseModel {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

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
	 * [seo description]
	 * @return [type] [description]
	 */
	public function seo()
    {
        return $this->morphMany('Pongo\Cms\Models\Seo', 'seoable');
    }

	/**
	 * [boot description]
	 * @return [type] [description]
	 */
	public static function boot()
	{
		parent::boot();
		self::observe(new PostObserver);
	}

}