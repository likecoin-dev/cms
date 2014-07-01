<?php

return array(

	/**
	 * 	PongoCMS :: array asset parameters
	 *
	 * 	[index] => conventional asset name
	 *  - 'put' => asset location (under ../public)
	 *  - 'into' => asset container name (as defined in ../templates/[template].blade.php)
	 *  - 'after' => to put after this conventional asset name (defined as array index)
	 */

	/**
	 * 	PongoCMS :: Use Twitter Bootstrap as base stylesheet
	 * 	- put_bootstrap => put it inside this container
	 */
	'use_bootstrap' => true,
	'put_bootstrap' => 'header',

	/**
	 * PongoCMS :: CSS Stylesheets assets
	 */
	'styles' => array(

		'site' => array(

			'put' 	=> '/css/site.css',
			'into'	=> 'header',
			'after' => 'bootstrap'

		),

	),

	/**
	 * PongoCMS :: Javascript assets
	 */
	'scripts' => array(

		'modernizr' => array(

			'put' 	=> '/js/lib/modernizr.js',
			'into'	=> 'header',
			'after' => null

		),

		'jquery' => array(

			'put' 	=> '/js/lib/jquery.js',
			'into'	=> 'footer',
			'after' => null

		),

		'plugin' => array(

			'put' 	=> '/js/plugins/jquery.plugin.js',
			'into'	=> 'footer',
			'after' => 'jquery'

		),

		'site' => array(

			'put' 	=> '/js/site.js',
			'into'	=> 'footer',
			'after' => 'plugin'

		),

	),

);