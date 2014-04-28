<?php namespace Pongo\Cms\Classes;

class Render {
	
	/**
	 * Asset base path
	 * 
	 * @var string
	 */
	private $asset_path = 'packages/pongocms/cms/';

	/**
	 * Asset Development base path
	 * 
	 * @var string
	 */
	private $development_path = 'packages/pongocms/cms/';

	/**
	 * Asset shortcut
	 * 
	 * @param  string $source Asset path
	 * @param  array  $attributes
	 * @return string         Asset path
	 */
	public function asset($source = null, $attributes = array())
	{		
		if ( ! is_null($source)) {
			$type = (pathinfo($source, PATHINFO_EXTENSION) == 'css') ? 'style' : 'script';
			$path = env('local') ? $this->development_path : $this->asset_path;
			return \HTML::$type($path . $source, $attributes);
		} 
	}

	/**
	 * Append asset to wrapper
	 * 
	 * @param  string $container  Container name
	 * @param  string $name       Asset name
	 * @param  string $source     Asset source
	 * @param  string $dependency Asset dependency (comes after)
	 * @return string             Print out the asset
	 */
	public function assetAdd($container = 'default', $name = 'asset', $source = '', $dependency = null)
	{
		$path = env('local')  ? $this->development_path : $this->asset_path;
		return \Asset::container($container)->add($name, $path . $source, $dependency);
	}

	/**
	 * [breadCrumb description]
	 * @param  array  $routes [description]
	 * @return [type]         [description]
	 */
	public function breadCrumb($routes)
	{
		if (is_string($routes)) $routes = func_get_args();
		$breadcrumb_view = $this->view('partials.breadcrumb');
		$breadcrumb_view['sections'] = \Pongo::flattenSections();
		$breadcrumb_view['routes'] = $routes;
		return $breadcrumb_view;
	}

	/**
	 * Bootstrap virtual asset
	 * 
	 * @param  string $source
	 * @return string
	 */
	public function bootJs($source)
	{
		return \HTML::script($source);
	}

	/**
	 * Asset container wrapper for scripts
	 * 
	 * @param  string $name Container name
	 * @return string       Asset string
	 */
	public function scripts($name = 'default')
	{
		return \Asset::container($name)->scripts();
	}

	/**
	 * Asset container wrapper for styles
	 * 
	 * @param  string $name Container name
	 * @return string       Asset string
	 */
	public function styles($name = 'default')
	{
		return \Asset::container($name)->styles();
	}

	/**
	 * Get class name
	 * 
	 * @return string Name of the class
	 */
	public function className()
	{
		return get_class($this);
	}
	
	/**
	 * Render a cleaned and formatted layout preview
	 * 
	 * @param  string $header
	 * @param  string $layout
	 * @param  string $footer
	 * @return string
	 */
	public function layoutPreview($header, $layout, $footer)
	{
		$layout_view = \Theme::view('layouts.' . $layout);
		$layout_zones = \Theme::layout($layout);
		
		foreach ($layout_zones as $zone => $name) {
			$layout_view[$zone] = st('settings.layout.' . $layout . '.' . $zone, $name);
		}

		$layout_view = strip_tags($layout_view, '<div>');
		$attrib_to_remove = array('class', 'id', 'rel');

		foreach ($attrib_to_remove as $attrib) {			
			$attrib_values = \Tool::getAllAttributes($attrib, $layout_view);
			if(!empty($attrib_values)) {
				foreach ($attrib_values as $value) {
					if(substr($value, 0, 4) != 'col-')
						$layout_view = str_replace(' '.$attrib.'="'.$value.'"', '', $layout_view);
				}
			}
		}

		$view = $this->view('partials.previews.layout');
		$view['header'] = st('settings.header.' . $header, \Theme::config('header.' . $header));
		$view['layout'] = $layout_view;
		$view['footer'] = st('settings.footer.' . $footer, \Theme::config('footer.' . $footer));
		return $view;
	}

	/**
	 * Render Dashboard icons
	 * 
	 * @return string   View content
	 */
	public function sectionDashboard()
	{
		$dashboard_view = $this->view('sections.dashboard.partials.item');
		$dashboard_view['items'] = \Pongo::flattenSections();
		return $dashboard_view;
	}

	/**
	 * Render PongoCMS main menu
	 * Based on config/system.php sections array
	 *
	 * @param  array $sections
	 * @return void
	 */
	public function sectionMenu($sections = array())
	{
		$menu_view = $this->view('partials.items.menuitem');
		$menu_view['sections'] = (!empty($sections)) ? $sections : \Pongo::system('sections');
		return $menu_view;
	}

	/**
	 * \View::make a Pongo view
	 * 
	 * @param  string $name View location
	 * @param  array  $data Array of data
	 * @return string       View content
	 */
	public function view($name, array $data = array())
	{		
		// Point to cms views
		$view_name = 'cms::' . $name;
		// Set to 'default' view if view not found
		if ( ! \View::exists($view_name)) {
			$view_name_arr = explode('.', $view_name);			
			$view_name = str_replace(end($view_name_arr), 'default', $view_name);
		}
		return \View::make($view_name, $data);
	}
	
}