<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Repositories\TagRepositoryInterface as Tag;

class TagManager extends BaseManager {	

	public function __construct(Tag $tag)
	{
		$this->model = $tag;

		$this->section = 'tags';
	}

	/**
	 * Get full list of tags per language
	 * @return array
	 */
	public function getTags()
	{
		return $this->model->getTagsList($this->input['q'], LANG);
	}

}