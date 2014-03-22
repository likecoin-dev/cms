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
	 * PongoCMS :: Notification alert template
	 */
	
	'alert_tpl' => '<div class="alert-msg :key">:message</div>',

	/**
	 * Custom Service Providers
	 *
	 * PongoServiceProvider loaded on runtime by /app/config/app.php
	 * Loaded on boot by PongoServiceProvider -> loadServiceProviders()
	 */

	'providers' => array(

		'EventServiceProvider',
		'MarkerServiceProvider',

		// Dependency providers

		'Prologue\Alerts\AlertsServiceProvider',

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
			'repos' => '',

		),

		'Asset' => array(

			'class'	=> 'Pongo\Cms\Classes\Asset',
			'alias'	=> 'Pongo\Cms\Support\Facades\Asset',
			'repos' => '',

		),

		/*'Build' => array(

			'class'	=> 'Pongo\Cms\Classes\Build',
			'alias'	=> 'Pongo\Cms\Support\Facades\Build',
			'repos' => '',

		),*/

		/*'Image' => array(

			'class'	=> 'Pongo\Cms\Classes\Image',
			'alias'	=> 'Pongo\Cms\Support\Facades\Image',
			'repos' => array(
				
				'PHPImageWorkshop\ImageWorkshop',

			),

		),*/

		/*'Load' => array(

			'class' => 'Pongo\Cms\Classes\Load',
			'alias' => 'Pongo\Cms\Support\Facades\Load',
			'repos' => array(

				'Pongo\Cms\Support\Repositories\FileRepositoryEloquent',
				'Pongo\Cms\Support\Repositories\PageRepositoryEloquent',

			),

		),*/

		'Marker' => array(

			'class'	=> 'Pongo\Cms\Classes\Marker',
			'alias'	=> 'Pongo\Cms\Support\Facades\Marker',
			'repos' => '',

		),

		/*'Media' => array(

			'class'	=> 'Pongo\Cms\Classes\Media',
			'alias'	=> 'Pongo\Cms\Support\Facades\Media',
			'repos' => '',

		),*/

		'Pongo' => array(

			'class'	=> 'Pongo\Cms\Classes\Pongo',
			'alias'	=> 'Pongo\Cms\Support\Facades\Pongo',
			'repos' => '',

		),

		/*'Render' => array(

			'class' => 'Pongo\Cms\Classes\Render',
			'alias' => 'Pongo\Cms\Support\Facades\Render',
			'repos' => '',

		),*/

		/*'Theme' => array(

			'class' => 'Pongo\Cms\Classes\Theme',
			'alias' => 'Pongo\Cms\Support\Facades\Theme',
			'repos' => '',

		),*/

		/*'Tool' => array(

			'class' => 'Pongo\Cms\Classes\Tool',
			'alias' => 'Pongo\Cms\Support\Facades\Tool',
			'repos' => '',

		),*/

		// Dependency facades

		'Alert' => array(

			'class' => 'Prologue\Alerts\Alert',
			'alias' => 'Prologue\Alerts\Facades\Alert',
			'repos' => '',

		),

	),

	/**
	 * IoC repository binds
	 *
	 * Loaded on boot by PongoServiceProvider -> bindRepositories()
	 */
	
	'repositories' => array(

		/*'element' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Support\Repositories\ElementRepositoryInterface',
			'repository' 	=> 'Pongo\Cms\Support\Repositories\ElementRepositoryEloquent',

		),*/
		
		/*'file' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Support\Repositories\FileRepositoryInterface',
			'repository' 	=> 'Pongo\Cms\Support\Repositories\FileRepositoryEloquent',

		),*/

		/*'page' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Support\Repositories\PageRepositoryInterface',
			'repository' 	=> 'Pongo\Cms\Support\Repositories\PageRepositoryEloquent',

		),	*/	

		'role' => array(

			'method'		=> 'bind',
			'interface' 	=> 'Pongo\Cms\Repositories\RoleRepositoryInterface',
			'repository' 	=> 'Pongo\Cms\Repositories\RoleRepositoryEloquent',

		),

		'user' => array(

			'method'		=> 'bind',
			'interface' 	=> 'Pongo\Cms\Support\Repositories\UserRepositoryInterface',
			'repository' 	=> 'Pongo\Cms\Support\Repositories\UserRepositoryEloquent',

		),

	),
	
	/**
	 * Admin interface - Sections Menu array
	 */
	
	'sections' => array(

		'dashboard' => array(

			'route' 		=> 'dashboard',
			'min_access' 	=> 'editor'

		),

		'access' => array(
			
			'roles' => array(

				'route' 		=> 'role.settings',
				'min_access' 	=> 'manager'

			),
			
			'users' => array(
				
				'route' 		=> 'users',
				'min_access' 	=> 'manager'

			),
		),

		/*'blog' => array(

			'route' 		=> 'blog.edit',
			'min_access' 	=> 'editor'

		),

		'files' => array(

			'route'			=> 'file.upload',
			'min_access' 	=> 'editor'

		),*/

		/*'shop' => array(

			'route' 		=> 'shop',
			'min_access' 	=> 'editor'

		),

		'tools' => array(

			'banners' => array(

				'route' 		=> 'banners',
				'min_access' 	=> 'editor'

			),

			'downloads' => array(

				'route' 		=> 'downloads',
				'min_access' 	=> 'editor'

			),

			'galleries' => array(

				'route' 		=> 'galleries',
				'min_access' 	=> 'editor'

			),		

			'menu' => array(

				'route' 		=> 'menu',
				'min_access' 	=> 'editor'

			),

			'translations' => array(

				'route' 		=> 'translation',
				'min_access' 	=> 'editor'

			),

		)*/

	),

	/**
	 * Custom Artisan pongo:<command>
	 *
	 * Loaded on boot by PongoServiceProvider -> bootCommands()
	 */
	
	'commands' => array(

		// 'pongo:import_asset' 		=> 'Pongo\Cms\Commands\ImportAssetCommand',
		// 'pongo:change_auth_model' 	=> 'Pongo\Cms\Commands\ChangeAuthModelCommand',
		'pongo:create_migration'	=> 'Pongo\Cms\Support\Commands\CreateMigrationCommand',

	),

);