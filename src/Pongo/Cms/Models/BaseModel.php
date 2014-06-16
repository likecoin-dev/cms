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
	 * [scopePivotActive description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopePivotActive($query)
	{
		return $query->wherePivot('is_active', 1);
	}

	/**
	 * [scopePivotInactive description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopePivotInactive($query)
	{
		return $query->wherePivot('is_active', 0);
	}

	/**
	 * [scopeHome description]
	 * @param  [type] $query   [description]
	 * @param  [type] $is_home [description]
	 * @return [type]          [description]
	 */
	public function scopeHome($query, $is_home)
	{
		$query->where('is_home', $is_home);
	}

	/**
	 * [scopeMinLevel description]
	 * @param  [type] $query [description]
	 * @param  [type] $level [description]
	 * @return [type]        [description]
	 */
	public function scopeLang($query, $lang)
	{
		$query->where('lang', $lang);
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
	 * [scopeParent description]
	 * @param  [type] $query   [description]
	 * @param  [type] $id      [description]
	 * @return [type]          [description]
	 */
	public function scopeParent($query, $id)
	{
		$query->where('parent_id', $id);
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