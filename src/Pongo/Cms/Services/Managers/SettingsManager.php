<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Access;
use Illuminate\Filesystem\Filesystem as FileSystem;
use Illuminate\Events\Dispatcher as Events;
use Pongo\Cms\Services\Validators\SettingsValidator as Validator;


class SettingsManager extends BaseManager {	

	/**
	 * [$file description]
	 * @var [type]
	 */
	protected $file;

	/**
	 * [$settings description]
	 * @var [type]
	 */
	protected $settings;

	public function __construct(Access $access, FileSystem $file, Events $events, Validator $validator)
	{
		$this->access = $access;
		$this->file = $file;
		$this->events = $events;
		$this->validator = $validator;

		// Load config/settings.php
		$this->settings = config_path('settings.php');

		$this->section = 'settings';
	}

	/**
	 * [saveSiteSettings description]
	 * @return [type] [description]
	 */
	public function saveSiteSettings()
	{
		if($check = $this->canEdit())
		{
			$content = $this->file->get($this->settings);

			$field = str_replace(' ', '', trim("'{$this->input['item_name']}'=>"));
			$old_value = \Tool::getBetween($content, $field, ',');
			$search = $field.$old_value;

			if(isset($this->input['action']))
			{
				// Process true/false			
				$replace = $field.$this->input['action'];
			}
			else
			{
				// Process values
				$replace = $field.$this->input['value'];
				
				if($this->input['item_name'] == 'theme')
				{
					$replace = $field."'{$this->input['value']}'";
				}
			}

			$content = str_replace($search, $replace, $content);
			$this->file->put($this->settings, $content);

			return $this->setSuccess('alert.success.settings_saved');

		}
		else
		{
			return $check;
		}
	}

}