<?php

return array(

	/**
	 * PongoCMS :: default site META keywords 
	 */
	'keywords' 		=> '',

	/**
	 * PongoCMS :: default site META description 
	 */
	'description' 	=> 'This is a PongoCMS default description',

	/**
	 * PongoCMS :: Default language
	 */
	
	'language' => 'en',

	/**
	 * PongoCMS :: Available languages and directionality (ltr | rtl)
	 */
	
	'languages' => array(

		'en' => array(

			'file'		=> 'en_us',
			'lang' 		=> 'English',
			'locale'	=> 'en_US',
			'dir'		=> 'ltr',

		),

		'it' => array(

			'file'		=> 'it',
			'lang' 		=> 'Italiano',
			'locale'	=> 'it_IT',
			'dir'		=> 'ltr',

		),

	),

	/**
	 * PongoCMS :: available editors
	 */
	'editors' => array(

		'Froala WYSIWYG Editor',

	),

	/**
	 * PongoCMS :: Max upload size (in Mb)
	 */
	
	'max_upload_size' => 1,

	/**
	 * PongoCMS :: Max n of items to upload (php.ini limit) 
	 */
	
	'max_upload_items' => 10,

	/**
	 * PongoCMS :: Mime types allowed for upload
	 */
	
	// 'mimes' => 'jpg, jpeg, gif, png, mp3, mp4, pdf, zip',
	'mimes' => array(

		'jpg' 	=> 'img',
		'jpeg'	=> 'img',
		'gif'	=> 'img',
		'png'	=> 'img',
		'mp3'	=> 'fa fa-file-audio-o fa-2',
		'mp4'	=> 'fa fa-file-video-o fa-2',
		'pdf'	=> 'fa fa-file-pdf-o fa-2',
		'zip'	=> 'fa fa-file-archive-o fa-2'

	),

	/**
	 * PongoCMS :: Image compression quality
	 */
	
	'image_quality' => 80,

	/**
	 * PongoCMS :: upload path under '/public'
	 */
	
	'upload_path' => 'upload/',

	/**
	 * PongoCMS :: default block wrapper class
	 */
	
	'block_class' => 'block',

	/**
	 * PongoCMS :: Default Admin account
	 */
	
	'admin_account' => array(

		'id'		=> 1,

		'username' 	=> 'admin',

		'email' 	=> 'admin@admin.tld',

		'password'	=> 'admin'

	),

	/**
	 * PongoCMS :: Default User account
	 */
	
	'user_account' => array(

		'role_id'	=> 4,
		
		'username' 	=> 'user',

		'email' 	=> 'user@user.tld',

		'password'	=> 'user'

	),

	/**
	 * PongoCMS Global settings
	 * managed by CMS interface.
	 *
	 * DO NOT TOUCH AND CHANGE MANUALLY!!!
	 */
	
	// THEME constant in site/start.php
	'theme'=>'default',
	// Global site availablility
	'site_live'=>true,
	// Chache enabled
	'cache_enabled'=>true,
	// Default cache time
	'cache_time'=>60,
	// XPAGE constant in cms/start.php
	'per_page'=>20,

);