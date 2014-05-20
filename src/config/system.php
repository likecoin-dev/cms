<?php

return array(

	'version' => '2.0.0',

	/**
	 * PongoCMS :: Locales
	 */
	
	'locale' => array(
		
		'en' => 'en_US',

		'it' => 'it_IT',
	),

	/**
	 * PongoCMS :: Date and time format
	 */
	
	'date_format' => 'm/d/Y',
	'time_format' => 'H:i',

	/**
	 * Default order_id
	 */
	
	'default_order' => 1000,

	/**
	 * Pongo CMS minimum role access to backend
	 */
	
	'min_access' => 'editor',

	/**
	 * Pongo CMS startup roles and levels
	 */

	'roles' => array(
		
		'admin' 	=> 50,

		'manager' 	=> 40,

		'editor' 	=> 30,

		'user' 		=> 1,

		'guest' 	=> 0,
	),

	/**
	 * Page wrapper type id
	 */
	
	'wrappers' => array(

		0 => 'pages',

		1 => 'blogs',

		2 => 'products',

	),

	/**
	 * Settings :: cache_time options
	 */

	'cache_time' => array(
		10 => '10 min',
		20 => '20 min',
		30 => '30 min',
		40 => '40 min',
		50 => '50 min',
		60 => '60 min',
		120 => '120 min'
	),

	/**
	 * Settings :: per_page options
	 */

	'per_page' => array(
		10 => '10 items',
		20 => '20 items',
		30 => '30 items',
		40 => '40 items',
		50 => '50 items',
		100 => '100 items'
	),

	/**
	 * PongoCMS :: Notification alert template
	 */
	
	'alert_tpl' => '<div class="alert-msg :key">:message</div>',

	/**
	 * PongoCMS :: Default thumb for interface
	 */
	
	'thumb' => array(

		'cms' => array(

			'width'		=> 130,
			'height' 	=> 90,
			'suffix' 	=> '_cms',

		),

	),

	/**
	 * Custom Service Providers
	 *
	 * PongoServiceProvider loaded on runtime by /app/config/app.php
	 * Loaded on boot by PongoServiceProvider -> loadServiceProviders()
	 */

	'providers' => array(

		'EventServiceProvider',
		'FilterServiceProvider',
		'MarkerServiceProvider',
		'ValidatorServiceProvider',

		// Dependency providers

		'Prologue\Alerts\AlertsServiceProvider',
		'Intervention\Image\ImageServiceProvider',
		'Intervention\Helper\DateServiceProvider',
		'Intervention\Helper\StringServiceProvider',
		'Laracasts\Utilities\UtilitiesServiceProvider',

	),

	/**
	 * Custom Facades
	 *
	 * Loaded on boot by PongoServiceProvider -> activateFacades()
	 */

	'facades' => array(

		'Access' => array(

			'class' => 'Pongo\Cms\Classes\Access',
			'alias' => 'Pongo\Cms\Support\Facades\Access',
			'depes' => array(
				
				array('interface' => 'Pongo\Cms\Repositories\RoleRepositoryInterface'),

			),

		),

		'Asset' => array(

			'class'	=> 'Pongo\Cms\Classes\Asset',
			'alias'	=> 'Pongo\Cms\Support\Facades\Asset',
			'depes' => '',

		),

		'Build' => array(

			'class'	=> 'Pongo\Cms\Classes\Build',
			'alias'	=> 'Pongo\Cms\Support\Facades\Build',
			'depes' => '',

		),

		'Load' => array(

			'class' => 'Pongo\Cms\Classes\Load',
			'alias' => 'Pongo\Cms\Support\Facades\Load',
			'depes' => array(
				
				array('interface' => 'Pongo\Cms\Repositories\FileRepositoryInterface'),
				array('interface' => 'Pongo\Cms\Repositories\PageRepositoryInterface'),
				array('interface' => 'Pongo\Cms\Repositories\RoleRepositoryInterface'),

			),

		),

		'Marker' => array(

			'class'	=> 'Pongo\Cms\Classes\Marker',
			'alias'	=> 'Pongo\Cms\Support\Facades\Marker',
			'depes' => '',

		),

		'Media' => array(

			'class'	=> 'Pongo\Cms\Classes\Media',
			'alias'	=> 'Pongo\Cms\Support\Facades\Media',
			'depes' => '',

		),

		'Picture' => array(

			'class'	=> 'Pongo\Cms\Classes\Picture',
			'alias'	=> 'Pongo\Cms\Support\Facades\Picture',
			'depes' => array(
				
				array('class' => 'Pongo\Cms\Classes\Pongo'),
				array('class' => 'Pongo\Cms\Classes\Media'),

			),

		),

		'Pongo' => array(

			'class'	=> 'Pongo\Cms\Classes\Pongo',
			'alias'	=> 'Pongo\Cms\Support\Facades\Pongo',
			'depes' => '',

		),

		'Render' => array(

			'class' => 'Pongo\Cms\Classes\Render',
			'alias' => 'Pongo\Cms\Support\Facades\Render',
			'depes' => '',

		),

		'Theme' => array(

			'class' => 'Pongo\Cms\Classes\Theme',
			'alias' => 'Pongo\Cms\Support\Facades\Theme',
			'depes' => '',

		),

		'Tool' => array(

			'class' => 'Pongo\Cms\Classes\Tool',
			'alias' => 'Pongo\Cms\Support\Facades\Tool',
			'depes' => '',

		),

		// Dependency facades

		'Alert' => array(

			'class' => 'Prologue\Alerts\Alert',
			'alias' => 'Prologue\Alerts\Facades\Alert',
			'depes' => '',

		),

		'Image' => array(

			'class' => 'Intervention\Image\Image',
			'alias' => 'Intervention\Image\Facades\Image',
			'depes' => '',

		),

		'Date' => array(

			'class' => 'Intervention\Helper\Date',
			'alias' => 'Intervention\Helper\Facades\Date',
			'depes' => '',

		),

		'String' => array(

			'class' => 'Intervention\Helper\String',
			'alias' => 'Intervention\Helper\Facades\String',
			'depes' => '',

		),

	),

	/**
	 * IoC repository binds
	 *
	 * Loaded on boot by PongoServiceProvider -> bindRepositories()
	 */
	
	'repositories' => array(

		'block' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Repositories\BlockRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\BlockRepositoryEloquent',

		),
		
		'file' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Repositories\FileRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\FileRepositoryEloquent',

		),

		'page' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Repositories\PageRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\PageRepositoryEloquent',

		),

		'role' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Repositories\RoleRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\RoleRepositoryEloquent',

		),

		'tag' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Repositories\TagRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\TagRepositoryEloquent',

		),

		'user' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Repositories\UserRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\UserRepositoryEloquent',

		),

		'userdetail' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Repositories\UserDetailRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\UserDetailRepositoryEloquent',

		),

	),

	/**
	 * IoC manager binds
	 */

	'services' => array(

		'cacheService' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Services\Cache\CacheInterface',
			'class' 		=> 'Pongo\Cms\Services\Cache\LaravelCache',

		),

		'searchService' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Services\Search\SearchInterface',
			'class' 		=> 'Pongo\Cms\Services\Search\Search',

		),

	),
	
	/**
	 * Admin interface - Sections Menu array
	 */
	
	'sections' => array(

		'pages' => array(

			'class' 		=> 'pages-toggle',
			'min_access' 	=> 'editor',
			'dashb_icon'	=> 'fa-sitemap',

		),

		'dashboard' => array(

			'route' 		=> 'dashboard',
			'min_access' 	=> 'editor',

		),

		'access' => array(
			
			'roles' => array(

				'route' 		=> 'roles',
				'min_access' 	=> 'manager',
				'dashb_icon'	=> 'fa-users',

			),
			
			'users' => array(
				
				'route' 		=> 'users',
				'min_access' 	=> 'manager',
				'dashb_icon'	=> 'fa-user',

			),
		),

		'settings' => array(

			'class' 		=> 'options-toggle',
			'min_access' 	=> 'admin',
			'dashb_icon'	=> 'fa-cogs',

		),

		'blog' => array(

			// 'route' 		=> 'blog.edit',
			'class' 		=> 'options-toggle',
			'min_access' 	=> 'editor',
			'dashb_icon'	=> 'fa-calendar',

		),

		'images' => array(

			// 'route'			=> 'file.upload',
			'class' 		=> 'options-toggle',
			'min_access' 	=> 'editor',
			'dashb_icon'	=> 'fa-picture-o',

		),

		'files' => array(

			// 'route'			=> 'file.upload',
			'class' 		=> 'options-toggle',
			'min_access' 	=> 'editor',
			'dashb_icon'	=> 'fa-archive',

		),

		/*'shop' => array(

			'route' 		=> 'shop',
			'min_access' 	=> 'editor'

		),*/

		'tools' => array(

			'banners' => array(

				// 'route' 		=> 'banners',
				'class' 		=> 'options-toggle',
				'min_access' 	=> 'editor',
				'dashb_icon'	=> 'fa-external-link',

			),

			'downloads' => array(

				// 'route' 		=> 'downloads',
				'class' 		=> 'options-toggle',
				'min_access' 	=> 'editor',
				'dashb_icon'	=> 'fa-download',

			),

			'galleries' => array(

				// 'route' 		=> 'galleries',
				'class' 		=> 'options-toggle',
				'min_access' 	=> 'editor',
				'dashb_icon'	=> 'fa-th',

			),		

			'menu' => array(

				// 'route' 		=> 'menu',
				'class' 		=> 'options-toggle',
				'min_access' 	=> 'editor',
				'dashb_icon'	=> 'fa-list',

			),

			'locale' => array(

				// 'route' 		=> 'translation',
				'class' 		=> 'options-toggle',
				'min_access' 	=> 'editor',
				'dashb_icon'	=> 'fa-book',

			),

		)

	),

	/**
	 * Custom Artisan pongo:<command>
	 *
	 * Loaded on boot by PongoServiceProvider -> bootCommands()
	 */
	
	'commands' => array(

		'pongo:import_asset' 		=> 'Pongo\Cms\Support\Commands\ImportAssetCommand',
		'pongo:change_auth_model' 	=> 'Pongo\Cms\Support\Commands\ChangeAuthModelCommand',
		'pongo:create_migration'	=> 'Pongo\Cms\Support\Commands\CreateMigrationCommand',

	),

);