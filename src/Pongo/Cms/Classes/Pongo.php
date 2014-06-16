<?php namespace Pongo\Cms\Classes;

class Pongo {

	/**
	 * Flatten the systems sections array
	 * 
	 * @return [type] [description]
	 */
	public function flattenSections()
	{
		$sections = $this->system('sections');
		$return = array();
		foreach ($sections as $key => $item) {
			$arr = array_keys($item);
			if(is_array($item[$arr[0]])) {
				foreach ($arr as $subkey) {
					$return[$subkey] = $item[$subkey];
				}
			} else {
				$return[$key] = $item;
			}
		}
		return $return;
	}

	/**
	 * Get config form values
	 * 
	 * @param  string $key
	 * @return array
	 */
	public function forms($key)
	{
		return \Config::get('cms::forms.' . $key);
	}

	/**
	 * [languages description]
	 * @return [type] [description]
	 */
	public function languages($get = 'lang')
	{
		$languages = $this->settings('languages');
		foreach ($languages as $lang_key => $lang) {
			$langs[$lang_key] = $lang[$get];
		}
		return $langs;
	}

	/**
	 * Get markers from config markers
	 *
	 * @param $key string
	 * @return array
	 */
	public function markers($key = null)
	{
		return (is_null($key)) ? \Config::get('cms::markers') : \Config::get('cms::markers.' . $key);
	}

	/**
	 * Turn off PHP memory limit
	 * 
	 * @return void
	 */
	public function memoryLimitOff()
	{
		ini_set('memory_limit', '-1');
	}

	/**
	 * Get config settings values
	 * 
	 * @param  string $key
	 * @return string
	 */
	public function settings($key)
	{
		return \Config::get('cms::settings.' . $key);
	}

	/**
	 * Get config system values
	 * 
	 * @param  string $key
	 * @return string
	 */
	public function system($key)
	{
		return \Config::get('cms::system.' . $key);
	}

	/**
	 * Show alert wrapper
	 * 
	 * @return string Alert message
	 */
	public function showAlert()
	{
		$format = $this->system('alert_tpl');

		foreach (\Alert::all($format) as $alert) {
			return $alert;
		}
	}

	/**
	 * [viewAccess description]
	 * @return [type] [description]
	 */
	public function viewAccess()
	{
		$view_access = array();
		$view_access[] = t('form.select.at_least');
		$view_access[] = t('form.select.only_by');
		return $view_access;
	}

	/**
	 * Share a var value with views
	 * 
	 * @param  string $var
	 * @param  mixed  $value
	 * @return void
	 */
	public function viewShare($var, $value)
	{
		return \View::share($var, $value);
	}

	/**
	 * Get Class name back
	 * 
	 * @return string Name of the class
	 */
	public function className()
	{
		return get_class($this);
	}
	
}