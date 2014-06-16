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
					->withPivot('zone', 'order_id', 'is_active')
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
		return $this->belongsToMany('Pongo\Cms\Models\File')
					->withPivot('is_active')
					->orderBy('id', 'desc');
	}

	/**
	 * [tags description]
	 * @return [type] [description]
	 */
	public function tags()
	{
		return $this->morphToMany('Pongo\Cms\Models\Tag', 'taggable')
					->lang(LANG);
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
	 * [seo description]
	 * @return [type] [description]
	 */
	public function seo()
    {
        return $this->morphMany('Pongo\Cms\Models\Seo', 'seoable');
    }

	/**
	 * Get files() relation paginated
	 * @return [type] [description]
	 */
	public function getFilesPaginatedAttribute()
	{
		return $this->files()
					->where('files.is_active', 1)
					->paginate(XPAGE);
	}

	/**
	 * Accessor to get tag array
	 * @return [type] [description]
	 */
	public function getTagArrayAttribute()
	{
		return $this->tags()
					->lang(LANG)
					->get(array('tags.id', 'name'))
					->toArray();
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