<?php

return array(

	/**
	 * Build a PongoCMS interface form
	 *
	 * key_index => input field | db column name
	 * 		
	 * 		form => Form class method
	 *   	type => SchemaBuilder method
	 *    	len => DB field length
	 *     	validate => validation rules (optional)
	 * 
	 */
	
	'blogs' => array(

		'datetime_on' => array(

			'form' 		=> 'dateTime',
			'type' 		=> 'dateTime',
			'len'  		=> null

		),

		'title' => array(

			'form' 		=> 'text',
			'type' 		=> 'string',
			'len'  		=> 255,
			'validate' 	=> 'required'

		),

		'slug' => array(

			'form'		=> 'text',
			'type' 		=> 'string',
			'len'  		=> 255,
			'validate' 	=> 'required|is_slug'

		),

		'text' => array(

			'form' 		=> 'textarea',
			'type' 		=> 'text',
			'len'  		=> null

		),

		'datetime_off' => array(

			'form' 		=> 'dateTime',
			'type' 		=> 'dateTime',
			'len'  		=> null

		),

	),

	'user_details' => array(

		'firstname' => array(

			'form' 		=> 'text',
			'type' 		=> 'string',
			'len'  		=> 255,
			'validate' 	=> 'required|min:2'

		),

		'lastname' => array(

			'form' 		=> 'text',
			'type' 		=> 'string',
			'len'  		=> 255,
			'validate' 	=> 'required|min:2'

		),

		'gender' => array(

			'form' 		=> 'multiRadio',
			'type' 		=> 'string',
			'len'  		=> 1,
			'values'	=> 'm|f',
			'validate' 	=> 'required'

		),

		'city' => array(

			'form' 		=> 'text',
			'type' 		=> 'string',
			'len'  		=> 255

		),

		'bio' => array(

			'form' 		=> 'textarea',
			'type' 		=> 'text',
			'len'  		=> null

		),

		'birth_date' => array(

			'form' 		=> 'date',
			'type' 		=> 'date',
			'len'  		=> null,
			'prefix'	=> 'birth'

		),

	),

);