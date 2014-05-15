<?php namespace Pongo\Cms\Services\Managers;

use Illuminate\Filesystem\Filesystem as FileSystem;
use Illuminate\Events\Dispatcher as Events;
use Pongo\Cms\Services\Validators\SettingsValidator as Validator;


class SettingsManager extends BaseManager {	

	protected $file;

	protected $settings;

	// protected static $settings = config_path('settings.php');

	public function __construct(FileSystem $file, Events $events, Validator $validator)
	{
		$this->file = $file;
		$this->events = $events;
		$this->validator = $validator;

		// Load config/settings.php
		$this->settings = config_path('settings.php');

		$this->section = 'settings';
	}

	/**
	 * [saveSettings description]
	 * @return [type] [description]
	 */
	public function saveSettings()
	{
		$content = $this->file->get($this->settings);

		$field = str_replace(' ', '', trim("'{$this->input['item_name']}'=>"));
		$old_value = \Tool::getBetween($content, $field, ',');
		$search = $field.$old_value;

		if(isset($this->input['action'])) {
			// Process true/false			
			$replace = $field.$this->input['action'];

		} else {
			// Process values
			$replace = $field.$this->input['value'];
			if($this->input['item_name'] == 'theme') {
				$replace = $field."'{$this->input['value']}'";
			}
		}

		$content = str_replace($search, $replace, $content);
		$this->file->put($this->settings, $content);

		return $this->setSuccess('alert.success.settings_saved');
	}

}