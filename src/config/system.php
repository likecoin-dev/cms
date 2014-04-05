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
			'depes' => '',

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
			'depes' => '',

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
				
				'Pongo\Cms\Classes\Pongo',
				'Pongo\Cms\Classes\Theme',

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
	 * IoC manager binds
	 */

	'managers' => array(

		'loginManager' => array(

			'method'		=> 'bind',
			'interface' 	=> 'Pongo\Cms\Services\Managers\LoginManagerInterface',
			'class' 		=> 'Pongo\Cms\Services\Managers\LoginManager',

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
		
		'file' => array(

			'method'		=> 'bind',
			'interface' 	=> 'Pongo\Cms\Repositories\FileRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\FileRepositoryEloquent',

		),

		/*'page' => array(

			'method'		=> 'singleton',
			'interface' 	=> 'Pongo\Cms\Support\Repositories\PageRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Support\Repositories\PageRepositoryEloquent',

		),	*/	

		'role' => array(

			'method'		=> 'bind',
			'interface' 	=> 'Pongo\Cms\Repositories\RoleRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\RoleRepositoryEloquent',

		),

		'user' => array(

			'method'		=> 'bind',
			'interface' 	=> 'Pongo\Cms\Repositories\UserRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\UserRepositoryEloquent',

		),

		'userdetail' => array(

			'method'		=> 'bind',
			'interface' 	=> 'Pongo\Cms\Repositories\UserDetailRepositoryInterface',
			'class' 		=> 'Pongo\Cms\Repositories\UserDetailRepositoryEloquent',

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

		'pongo:import_asset' 		=> 'Pongo\Cms\Support\Commands\ImportAssetCommand',
		'pongo:change_auth_model' 	=> 'Pongo\Cms\Support\Commands\ChangeAuthModelCommand',
		'pongo:create_migration'	=> 'Pongo\Cms\Support\Commands\CreateMigrationCommand',

	),

);