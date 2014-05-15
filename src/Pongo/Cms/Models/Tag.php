<?php namespace Pongo\Cms\Models;

use Pongo\Cms\Models\Observers\TagObserver;

class Tag extends BaseModel {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

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
	 * 
	 * @return mixed
	 */
	public function pages()
	{
		return $this->MorphedByMany('Pongo\Cms\Models\Page', 'taggable');
	}

	/**
	 * Posts relationship
	 * 
	 * @return mixed
	 */
	public function posts()
	{
		return $this->MorphedByMany('Pongo\Cms\Models\Post', 'taggable');
	}

	/**
	 * Pages relationship
	 * 
	 * @return mixed
	 */
	public function files()
	{
		return $this->MorphedByMany('Pongo\Cms\Models\File', 'taggable');
	}

	/**
	 * [boot description]
	 * @return [type] [description]
	 */
	public static function boot()
	{
		parent::boot();
		self::observe(new TagObserver);
	}

}