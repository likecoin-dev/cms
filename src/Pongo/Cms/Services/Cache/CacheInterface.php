<?php namespace Pongo\Cms\Services\Cache;

interface CacheInterface {

	public function get($key);

	public function put($key, $value, $minutes = null);

	public function putPaginated(
		$currentPage,
		$perPage,
		$totalItem,
		$items,
		$key,
		$minutes = null
	);

	public function has($key);

	public function isEnabled();
}