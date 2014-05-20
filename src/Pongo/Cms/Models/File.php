<?php namespace Pongo\Cms\Models;

use Pongo\Cms\Models\Observers\FileObserver;

class File extends BaseModel {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';

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
	 * Pages relationship
	 * Each file has many and belongs to many pages
	 * 
	 * @return mixed
	 */
	public function pages()
	{
		return $this->belongsToMany('Pongo\Cms\Models\Page');
	}

	/**
	 * [boot description]
	 * @return [type] [description]
	 */
	public static function boot()
	{
		parent::boot();
		self::observe(new FileObserver);
	}

}