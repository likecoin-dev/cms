<?php namespace Pongo\Cms\Services\Managers;

use Pongo\Cms\Classes\Theme;
use Pongo\Cms\Classes\Pongo;
use Pongo\Cms\Classes\Access;
use Pongo\Cms\Classes\Marker;

class SiteManager extends BaseManager {	

	/**
	 * [$theme description]
	 * @var [type]
	 */
	public $theme;

	/**
	 * [$pongo description]
	 * @var [type]
	 */
	public $pongo;

	/**
	 * [$access description]
	 * @var [type]
	 */
	public $access;

	/**
	 * [$marker description]
	 * @var [type]
	 */
	public $marker;

	/**
	 * [$isHome description]
	 * @var boolean
	 */
	public $isHome = true;

	/**
	 * [$slug_first description]
	 * @var [type]
	 */
	public $slug_first = '/';

	/**
	 * [$slug_full description]
	 * @var [type]
	 */
	public $slug_full = '/';

	/**
	 * [$slug_last description]
	 * @var [type]
	 */
	public $slug_last = '/';

	/**
	 * [$slug_prev description]
	 * @var [type]
	 */
	public $slug_prev = '/';

	/**
	 * [$lang description]
	 * @var [type]
	 */
	protected $lang;

	/**
	 * Redirect to child page id
	 * @var [type]
	 */
	protected $redirect;

	/**
	 * [$seo description]
	 * @var [type]
	 */
	protected $seo;

	/**
	 * [$view_access description]
	 * @var integer
	 */
	protected $view_access = 0;

	/**
	 * [$view_level description]
	 * @var integer
	 */
	protected $view_level = 0;

	/**
	 * Page array
	 * @var array
	 */
	protected $page = array();

	/**
	 * Page blocks array
	 * @var array
	 */
	protected $blocks = array();

	/**
	 * Post, products, etc. array
	 * @var array
	 */
	protected $extra = array();

	/**
	 * Seo data (title, keyw, descr)
	 * @var array
	 */
	protected $seo_data = array();

	/**
	 * Template, header, footer partials
	 * @var array
	 */
	protected $template_partials = array();

	/**
	 * Extra type (post, product, etc)
	 * @var [type]
	 */
	protected $extra_type;

	/**
	 * Layout array as in theme.php
	 * @var [type]
	 */
	protected $layout_arr;

	/**
	 * [__construct description]
	 * @param Theme  $theme  [description]
	 * @param Access $access [description]
	 * @param Search $search [description]
	 * @param Seo    $seo    [description]
	 * @param Block  $block  [description]
	 */
	public function __construct(Theme $theme, Pongo $pongo, Access $access, Marker $marker)
	{
		$this->theme = $theme;
		$this->pongo = $pongo;
		$this->access = $access;
		$this->marker = $marker;

		// Set local language
		$this->lang = LANG;
	}

	/**
	 * Check if requested page has public access
	 * 
	 * @param  [type] $uri [description]
	 * @return [type]      [description]
	 */
	public function publicPage($uri)
	{
		if($this->setupContent($uri))
		{
			return ($this->access->allowedPage($this->view_access, $this->view_level)) ? true : false;
		}
		else
		{
			\App::abort(404);
		}
	}

	/**
	 * Shows a page
	 * @param  array  $inject [description]
	 * @return [type]         [description]
	 */
	public function showPage($inject = array())
	{
		if($this->redirect)
		{
			// If page empty, redirect to first child page
			return \Redirect::to($this->redirect);
		}

		return $this->renderPage($inject);		
	}

	/**
	 * [authPage description]
	 * @return [type] [description]
	 */
	public function authPage()
	{
		$service_page = $this->theme->service('auth');

		return $this->renderPage($service_page);
	}

	/**
	 * Render a page
	 * @param  boolean $static       	True if it's a static service page, otherwise false
	 * @param  array   $service_page 	An array that binds partials to page layout
	 * @return string                	The page
	 */
	private function renderPage($service_page = array())
	{
		// Load site assets
		$assets = $this->loadSiteAssets();

		// Get the page layout
		$layout = $this->getPageLayout($service_page);

		if($assets and $layout and $this->seo_data)
		{
			$html = $this->theme->view($this->template_partials['template'])
						->with('title', $this->seo_data['title'])
						->with('keyw', $this->seo_data['keyw'])
						->with('descr', $this->seo_data['descr'])
						->nest('header', $this->template_partials['header'])
						->with('layout', $layout)
						->nest('footer', $this->template_partials['footer']);

			return $html;
		}
	}

	/**
	 * Load site assets from /config/assets.php
	 * @return bool
	 */
	private function loadSiteAssets()
	{
		$assets = $this->pongo->assets();

		// Load Bootstrap
		if(array_key_exists('use_bootstrap', $assets) and $assets['use_bootstrap'])
		{
			\Asset::container($assets['put_bootstrap'])->add('bootstrap', '/packages/pongocms/cms/css/lib.css', null);
		}

		if($assets)
		{
			foreach ($assets['styles'] as $name => $param)
			{
				$after = array_key_exists('after', $param) ? $param['after'] : null;

				\Asset::container($param['into'])->add($name, $param['put'], $after);
			}

			foreach ($assets['scripts'] as $name => $param)
			{
				$after = array_key_exists('after', $param) ? $param['after'] : null;

				\Asset::container($param['into'])->add($name, $param['put'], $after);
			}

			return true;
		}

		return false;
	}

	/**
	 * Get page, block and extra content
	 * @param  string $uri The $uri slug
	 * @return bool
	 */
	private function setupContent($uri)
	{
		// Get Seo repo
		$page_repo = \App::make($this->pongo->system('repositories.page.interface'));

		if($this->checkIsHome($uri))
		{
			// get page where $this->lang and is_home(1)
			$this->page = $page_repo->getHomePageWithBlocksAndSeo();
			$this->blocks = $this->page['blocks'];

			// Set seo data
			$this->seo_data = $this->getSeoData($this->page['seo'][0]);
		}
		else
		{
			// Get Seo repo
			$seo_repo = \App::make($this->pongo->system('repositories.seo.interface'));

			// Get content by full slug
			$seo_content = $seo_repo->getContentBySlug($this->slug_full);

			// If a full slug is found (a page)
			if(isset($seo_content))
			{
				$this->page = $seo_content->seoable->toArray();
				$this->blocks = $seo_content->seoable->blocks->toArray();

				// If empty $this->blocks, set a redirect slug
				if( ! $this->blocks)
				{
					$child_page = $page_repo->getChildByParentId($this->page['id']);

					if($child_page)
					{
						$this->redirect = $child_page->seo->first()->slug;
					}
				}

				// Set seo data
				$this->seo_data = $this->getSeoData($seo_content);
			}
			// Else if not a page (an extra)
			else
			{
				$seo_content = $seo_repo->getContentBySlug($this->slug_prev);
				$seo_extra = $seo_repo->getContentBySlug($this->slug_last);

				if( ! is_null($seo_content))
				{
					// Page slug matches but not the extra one
					if($seo_extra)
					{
						$this->page = $seo_content->seoable->toArray();
						$this->blocks = $seo_content->seoable->blocks->toArray();
						$this->extra = $seo_extra->seoable->toArray();

						// Set extra type
						$this->setExtraType($seo_extra->seoable);

						// Set seo data
						$this->seo_data = $this->getSeoData($seo_content, $seo_extra);
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}				
			}
		}

		// Set access and level
		$this->view_access = $this->page['view_access'];
		$this->view_level = $this->page['view_level'];

		return ( ! empty($this->page)) ? true : false;
	}

	/**
	 * Get seo data
	 * @return array
	 */
	private function getSeoData($seo_content, $seo_extra = null)
	{
		$data = array(
			'title' => '',
			'keyw'	=> $this->pongo->settings('keywords'),
			'descr'	=> $this->pongo->settings('description'),
		);

		if($seo_content)
		{
			$data['title'] 	= ($seo_content['title']) ?: $this->page['name'];
			$data['keyw'] 	= ($seo_content['keyw'])  ?: $this->pongo->settings('keywords');
			$data['descr'] 	= ($seo_content['descr']) ?: $this->pongo->settings('description');
		}

		if($seo_extra)
		{
			$data['title'] 	= ($seo_extra['title']) ?: $this->extra['title'];
			$data['keyw'] 	= ($seo_extra['keyw'])  ?: $this->pongo->settings('keywords');
			$data['descr'] 	= ($seo_extra['descr']) ?: $this->pongo->settings('description');
		}

		return $data;
	}

	/**
	 * Set template data
	 * @param  [type] $inject [description]
	 * @return [type]         [description]
	 */
	private function getTemplatePartials($inject)
	{
		$data = array();

		$template 	= (isset($inject['template'])) ? $inject['template'] : $this->page['template'];
		$header 	= (isset($inject['header'])) ? $inject['header'] : $this->page['header'];
		$footer 	= (isset($inject['footer'])) ? $inject['footer'] : $this->page['footer'];

		$data['template'] 	= 'templates.' . $template;
		$data['header'] 	= 'site::'.THEME.'.partials.headers.' . $header;
		$data['footer'] 	= 'site::'.THEME.'.partials.footers.' . $footer;

		return $data;
	}

	/**
	 * Return the page layout
	 * @param  array  $inject
	 * @return object         The layout view object
	 */
	private function getPageLayout($inject = array())
	{
		// Get the page layout
		$page_layout = empty($inject) ? $this->page['layout'] : $inject['layout']['name'];

		// If page layout not set, then it's 'default'
		if( ! isset($page_layout)) $page_layout = 'default';

		// Get layout array from theme.php
		$this->layout_arr = $this->theme->config('layout_' . $page_layout);

		// Load theme layout
		$layout = $this->theme->view('layouts.' . $page_layout);

		if($this->page)
		{
			// Set some layout variables
			$layout['NAME'] = $this->page['name'];
			$layout['CLASSNAME'] = \Str::slug($this->page['name']);
		}

		return $this->bindBlocksToZones($layout, $inject);
	}

	/**
	 * Binds block to layout ZONE variables
	 * @param  object $layout layout view object
	 * @param  array $inject  optional inject layout
	 * @return object         layout
	 */
	private function bindBlocksToZones($layout, $inject)
	{
		$layout = $this->preBindZoneToEmpty($layout);

		// Blocks are present
		if($this->blocks)
		{
			$zone = array();
			// Loop blocks to wrap each of them inside a div
			// to marker decode their contend
			// and to bind them to a ZONE variable
			foreach ($this->blocks as $block)
			{
				
				$block_html  = '<div id="' . $block['attrib'] . '" class="' . $this->pongo->settings('block_class') . '">';
				$block_html .= $this->marker->decode($block['content']);
				$block_html .= '</div>';

				// Bind zone content to zone variable
				$zone[$block['pivot']['zone']][] = $block_html;
			}

			// If inject, override zone content
			if( ! empty($inject)) $zone[$inject['layout']['zone']][0] = $this->theme->view($inject['layout']['block'])->render();
			

			// Loop again to bind zone array item to layout ZONE variable
			foreach ($this->blocks as $block)
			{
				$layout[strtoupper($block['pivot']['zone'])] = trim(implode("\n", $zone[$block['pivot']['zone']]));
			}
		}

		// It's an extra content
		if($this->extra)
		{
			$layout = $this->bindExtraToZone($layout);
		}

		// Set template data
		$this->template_partials = $this->getTemplatePartials($inject);

		return $layout;
	}

	/**
	 * [bindExtraToZone description]
	 * @param  [type] $layout [description]
	 * @return [type]         [description]
	 */
	private function bindExtraToZone($layout)
	{
		// Get extra array by type from theme.php
		$extra_arr = $this->theme->config('extra_' . $this->extra_type);

		// Get extra template and pass extra object to template
		$extra_tpl = $this->theme->view('partials.extras.' . key($extra_arr));
		$extra_tpl['extra'] = $this->extra;

		// Set extra template to ZONE var
		$layout[strtoupper($extra_arr[$this->extra_type])] = trim(implode("\n", array($extra_tpl)));

		return $layout;
	}

	/**
	 * Get actual url segments
	 * -> full, first, last, prev
	 * 
	 * @return array
	 */
	private function checkIsHome($uri)
	{
		if($uri != '/')
		{
			// Get and clean uri
			$segments = explode('/', $uri);

			// Check if first segment is language
			$segments = $this->setLanguage($segments);

			// if empty, redirect to home
			if(empty($segments))
			{
				$this->isHome = true;
			}
			else
			{
				$n = count($segments);
				$this->slug_full 	= '/' . $uri;
				$this->slug_first 	= '/' . $segments[0];
				$this->slug_last	= '/' . $segments[$n - 1];
				$this->slug_prev	= str_replace($this->slug_last, '', $this->slug_full);

				$this->isHome = false;
			}
		}

		return $this->isHome;
	}

	/**
	 * Pre-bind all zones to empty
	 * @param  object $layout
	 * @return object
	 */
	private function preBindZoneToEmpty($layout)
	{
		if($layout and $this->layout_arr)
		{
			foreach ($this->layout_arr as $zone => $zone_name)
			{
				$layout[strtoupper($zone)] = '';
			}
		}

		return $layout;
	}

	/**
	 * [setExtraType description]
	 * @param [type] $seoable [description]
	 */
	private function setExtraType($seoable)
	{
		$extras = $this->pongo->system('extras');

		$model = get_class($seoable);

		$this->extra_type = $extras[$model];
	}

	/**
	 * Check if language is specified in the uri
	 * 
	 * @param [type] $uri [description]
	 */
	private function setLanguage($segments)
	{
		$first_segment = $segments[0];

		if(array_key_exists($first_segment, $this->pongo->settings('languages')))
		{
			// Override local language
			$this->lang = $first_segment;

			// Set language in session
			\Session::put('LANG', $first_segment);

			// remove lang chunk from segments
			array_shift($segments);
		}

		return $segments;
	}

}