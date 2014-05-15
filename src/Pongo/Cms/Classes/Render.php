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
	public function breadCrumb($routes, $last = null)
	{
		if (is_string($routes)) $routes = func_get_args();
		$breadcrumb_view = $this->view('partials.breadcrumb');
		$breadcrumb_view['sections'] = \Pongo::flattenSections();
		$breadcrumb_view['routes'] = $routes;
		$breadcrumb_view['last'] = $last;
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
	 * [currentLanguage description]
	 * @return [type] [description]
	 */
	public function currentLanguage()
	{
		return $this->language(LANG);
	}

	/**
	 * [language description]
	 * @param  [type] $lang [description]
	 * @return [type]       [description]
	 */
	public function language($lang)
	{
		$languages = \Pongo::settings('languages');
		return $languages[$lang]['lang'];
	}

	/**
	 * [noResult description]
	 * @param  string $name [description]
	 * @return [type]       [description]
	 */
	public function noResult($name = 'empty')
	{
		$item_view = $this->view('partials.items.noresult');
		$item_view['name'] = $name;
		return $item_view;
	}

	/**
	 * [optionsToggle description]
	 * @param  string $icon [description]
	 * @return [type]       [description]
	 */
	public function optionsToggle($icon = 'fa-bars')
	{
		$otbutton_view = $this->view('partials.optionstoggle');
		$otbutton_view['icon'] = $icon;
		return $otbutton_view;
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
	 * Create Bottstrap class array to take in layout
	 * @return [type] [description]
	 */
	private function getBootstrapClasses()
	{
		$base_classes = array('col-xs-', 'col-sm-', 'col-md-', 'col-lg-');
		$class = array('row');
		foreach ($base_classes as $base_class) {
			for ($i = 1; $i <= 12; $i++) { 
				$class[] = $base_class.$i;
			}
		}
		return $class;
	}

	/**
	 * Render a cleaned and formatted layout preview
	 * 
	 * @param  string $layout
	 * @return string
	 */
	public function layoutPreview($layout)
	{
		$layout_view = \Theme::view('layouts.' . $layout);
		$layout_zones = \Theme::layout($layout);

		// Loop layout zones and set name and partials.layout.zone for each
		foreach ($layout_zones as $zone => $name) {
			$zone_content[$zone] = $this->view('partials.layout.zone');
			$zone_content[$zone]['name'] = st('settings.layout.' . $layout . '.' . $zone, $name);
			$zone_content[$zone]['value'] = $zone;
			
			$layout_view[$zone] = st('settings.layout.' . $layout . '.' . $zone, $name);
		}

		// Strip all attributes from layouts but div
		$layout_view = strip_tags($layout_view, '<div>');
		$attrib_to_remove = array('class', 'id', 'rel');
		$classes_to_take = $this->getBootstrapClasses();

		// Remove unwanted attributes and create array of present classes
		foreach ($attrib_to_remove as $attrib) {			
			$attrib_values = \Tool::getAllAttributes($attrib, $layout_view);
			if(!empty($attrib_values)) {
				foreach ($attrib_values as $value) {
					if( $attrib != 'class' ) {
						// Remove attributes but classes
						$layout_view = str_replace(' '.$attrib.'="'.$value.'"', '', $layout_view);
					} else {
						// Put css values in array
						$css_values[] = $value;
					}					
				}
			}
		}

		// Normalize classes in one string and array them
		$css_string = implode(' ', $css_values);
		$css_array = explode(' ', $css_string);

		// Loop classes and remove not Bootstrap classes
		foreach ($css_array as $css_class) {
			if( ! in_array($css_class, $classes_to_take)) {
				$layout_view = trim(str_replace($css_class, '', $layout_view));
			}
		}

		// Replace title with partials.layout.zone
		foreach ($layout_zones as $zone => $name) {
			$layout_view = str_replace(
				st('settings.layout.' . $layout . '.' . $zone, $name),
				$zone_content[$zone]->render(),
				$layout_view
			);
		}

		$view = $this->view('partials.layout.overall');
		$view['layout'] = $layout_view;

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
	 * Render PongoCMS search engine
	 * @param  [type] $model [description]
	 * @param  array  $items [description]
	 * @return [type]        [description]
	 */
	public function searchForm($model, $items = array())
	{
		$search_view = $this->view('partials.forms.searchform');
		$search_view['model'] = $model;
		$search_view['items'] = $items;
		return $search_view;
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