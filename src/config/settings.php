<?php

return array(

	/**
	 * PongoCMS :: Active theme name
	 *
	 * Saved into THEME constant in start.php
	 */
	
	'theme' => 'default',

	/**
	 * PongoCMS :: Default language
	 */
	
	'language' => 'en',

	/**
	 * PongoCMS :: Available languages and directionality (ltr | rtl)
	 *
	 * Check http://www.tinymce.com/i18n/index.php for locale file.
	 */
	
	'languages' => array(

		'en' => array(

			'lang' 		=> 'English',
			'locale'	=> 'en',
			'dir'		=> 'ltr',

		),

		'it' => array(

			'lang' 		=> 'Italiano',
			'locale'	=> 'it',
			'dir'		=> 'ltr',

		),

	),

	/**
	 * PongoCMS :: pagination items per page
	 */
	'pag' => 20,

	/**
	 * PongoCMS :: available editors
	 */
	'editors' => array(

		'TinyMCE',

	),

	/**
	 * PongoCMS :: Max upload size (in Mb)
	 */
	
	'max_upload_size' => 1,

	/**
	 * PongoCMS :: Max n of items to upload (php.ini limit) 
	 */
	
	'max_upload_items' => 20,

	/**
	 * PongoCMS :: Mime types allowed for upload
	 */
	
	'mimes' => 'jpg, jpeg, gif, png, mp3, mp4, pdf, zip',

	/**
	 * PongoCMS :: Image compression quality
	 */
	
	'image_quality' => 80,

	/**
	 * PongoCMS :: upload path under '/public'
	 */
	
	'upload_path' => 'upload/',

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

);