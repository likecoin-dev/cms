<?php namespace Pongo\Cms\Classes;

class Theme {

	/**
	 * Get a theme config entry
	 * 
	 * @param  string $key
	 * @return mixed
	 */
	public function config($key)
	{
		return \Config::get('site::theme.'.$key);
	}

	/**
	 * Get layout array in theme by name
	 * 
	 * @param  string $name
	 * @return array
	 */
	public function layout($name)
	{
		return $this->config('layout_' . $name);
	}

	/**
	 * Get service array in theme by name
	 * 
	 * @param  string $name
	 * @return array
	 */
	public function service($name)
	{
		return $this->config('service_' . $name);
	}

	/**
	 * [layoutName description]
	 * @param  string $layout [description]
	 * @param  [type] $zone   [description]
	 * @return [type]         [description]
	 */
	public function layoutName($zone, $layout = 'default')
	{
		if($zone)
		{
			return $this->layout($layout)[$zone];
		}
	}

	/**
	 * Create virtual array for theme change
	 * @return array
	 */
	public function themes()
	{
		$path = themes_path();

		$dir_arr = \File::directories($path);

		$themes = array();

		foreach ($dir_arr as $path)
		{
			$name_arr = explode('/', $path);

			$name = array_pop($name_arr);

			$theme_name = array_get(theme_settings($path), 'theme_name');

			$themes[$name] = $theme_name;
		}

		return $themes;
	}

	/**
	 * Load a theme view from themes/{theme name}
	 * Folder /themes instead /views loaded on boot from SiteServiceProvider
	 * 
	 * @return string
	 */
	public function view($name, array $data = array())
	{
		$view_name = 'site::' . THEME . '.' . $name;

		// Set to 'default' view if view not found
		if ( ! \View::exists($view_name))
		{
			$view_name_arr = explode('.', $view_name);
			$view_name = str_replace(end($view_name_arr), 'default', $view_name);
		}

		return \View::make($view_name, $data);
	}

	/**
	 * Return layout zones for a specific page layout as set in theme.php
	 * @param  string $page_layout
	 * @return array
	 */
	public function zones($page_layout)
	{
		$layout_name = 'layout_' . $page_layout;

		$layout_zones = $this->config($layout_name);

		return (is_array($layout_zones)) ? $layout_zones : array();
	}

	/**
	 * [zoneName description]
	 * @param  [type] $page_layout [description]
	 * @param  [type] $zone        [description]
	 * @return [type]              [description]
	 */
	public function zoneName($page_layout, $zone)
	{
		if($zone)
		{
			return $this->layout($page_layout)[$zone];
		}
	}
	
}