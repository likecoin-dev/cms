<?php namespace Pongo\Cms\Models;

use Eloquent;

class BaseModel extends Eloquent {

	/**
	 * [scopeActive description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeActive($query)
	{
		return $query->where('is_active', 1);
	}

	/**
	 * [scopeInactive description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeInactive($query)
	{
		return $query->where('is_active', 0);
	}

	/**
	 * [scopeMinLevel description]
	 * @param  [type] $query [description]
	 * @param  [type] $level [description]
	 * @return [type]        [description]
	 */
	public function scopeMinLevel($query, $level)
	{
		$query->whereHas('role', function($q) use ($level) {
			$q->where('level', '>=', $level);
		});
	}

	/**
	 * [scopeMaxLevel description]
	 * @param  [type] $query [description]
	 * @param  [type] $level [description]
	 * @return [type]        [description]
	 */
	public function scopeMaxLevel($query, $level)
	{
		$query->whereHas('role', function($q) use ($level) {
			$q->where('level', '<=', $level);
		});
	}

	/**
	 * [scopeSearchHasRelated description]
	 * @param  [type] $query [description]
	 * @param  [type] $data  [description]
	 * @return [type]        [description]
	 */
	public function scopeSearchHasRelated($query, $data)
	{
		$query->whereHas($data['related'], function($q) use ($data) {
			$q->where($data['field'], $data['sign'], $data['search']);
		});
	}

}