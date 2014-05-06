<?php namespace Pongo\Cms\Models;

use Eloquent;

class BaseModel extends Eloquent {

	public function scopeActive($query)
	{
		return $query->where('is_active', 1);
	}

	public function scopeInactive($query)
	{
		return $query->where('is_active', 0);
	}

	public function scopeMinLevel($query, $level)
	{
		$query->whereHas('role', function($q) use ($level) {
			$q->where('level', '>=', $level);
		});
	}

	public function scopeMaxLevel($query, $level)
	{
		$query->whereHas('role', function($q) use ($level) {
			$q->where('level', '<=', $level);
		});
	}

	public function scopeSearchHasRelated($query, $data)
	{
		$query->whereHas($data['related'], function($q) use ($data) {
			$q->where($data['field'], $data['sign'], $data['search']);
		});
	}

}