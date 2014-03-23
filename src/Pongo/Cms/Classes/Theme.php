<?php namespace Pongo\Cms\Classes;

class Theme {

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		// $this->name = \Pongo::settings('theme');
	}

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
	 * Load a theme view from themes/{theme name}
	 * Folder /themes instead /views loaded on boot from SiteServiceProvider
	 * 
	 * @return string
	 */
	public function view($name, array $data = array())
	{
		$view_name = 'site::' . \Pongo::settings('theme') . '.' . $name;

		// Set to 'default' view if view not found
		if ( ! \View::exists($view_name)) {

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
	 * Get active theme name
	 * 
	 * @return string Name of the theme
	 */
	/*public function className()
	{
		return $this->name;
	}*/
	
}