<?php namespace Pongo\Cms\Controllers\Api;

use Pongo\Cms\Services\Managers\SettingsManager;

class SettingsController extends ApiController {

	public function __construct(SettingsManager $manager)
	{
		// Apply auth filter
		parent::__construct();
		$this->manager = $manager; 
	}

	/**
	 * Save global settings
	 * @return json object
	 */
	public function save()
	{
		if ($this->manager->withInput()->saveSettings()) {
			return $this->manager->success();
		} else {
			return $this->manager->errors();
		}
	}

}