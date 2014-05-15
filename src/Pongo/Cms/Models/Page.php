<?php namespace Pongo\Cms\Models;

use Pongo\Cms\Models\Observers\PageObserver;

class Page extends BaseModel {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

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
	 * Elements relationship
	 * Each element has many and belongs to many pages
	 * 
	 * @return mixed
	 */
	public function blocks()
	{
		return $this->belongsToMany('Pongo\Cms\Models\Block')
					->withPivot('order_id', 'is_active')
					->orderBy('order_id', 'asc');
	}

	/**
	 * Files relationship
	 * Each page has many and belongs to many files
	 * 
	 * @return mixed
	 */
	public function files()
	{
		return $this->belongsToMany('Pongo\Cms\Models\File');
	}

	/**
	 * Other page relationship
	 * Each page has many and belongs to many related pages
	 * 
	 * @return mixed
	 */
	public function rels()
	{
		return $this->belongsToMany('Pongo\Cms\Models\Page', 'page_page', 'page_id', 'rel_id');
	}

	/**
	 * Page has subpages
	 * @return [type] [description]
	 */
	public function subpages()
	{
		return $this->hasMany('Pongo\Cms\Models\Page', 'parent_id');
	}

	/**
	 * Author relationship
	 * Each page has one author
	 * 
	 * @return mixed
	 */
	public function author()
	{
		return $this->hasOne('Pongo\Cms\Models\User', 'author_id');
	}

	/**
	 * [boot description]
	 * @return [type] [description]
	 */
	public static function boot()
	{
		parent::boot();
		self::observe(new PageObserver);
	}

}