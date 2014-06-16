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
	
	'posts' => array(

		'datetime_on' => array(

			'form' 		=> 'dateTime',
			'type' 		=> 'dateTime',
			'len'  		=> null

		),

		'datetime_off' => array(

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

		'content' => array(

			'form' 		=> 'textarea',
			'type' 		=> 'text',
			'len'  		=> null

		),

	),

	'products' => array(

		'name' => array(

			'form' 		=> 'text',
			'type' 		=> 'string',
			'len'  		=> 100,
			'validate' 	=> 'required'

		),

		'content' => array(

			'form' 		=> 'textarea',
			'type' 		=> 'text',
			'len'  		=> null

		),

		'price' => array(

			'form' 		=> 'text',
			'type' 		=> 'decimal',
			'len'  		=> array(9, 2),
			'validate' 	=> 'required|numeric'

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

		'gender' => array(

			'form' 		=> 'multiRadio',
			'type' 		=> 'string',
			'len'  		=> 1,
			'values'	=> 'm|f',
			'validate' 	=> 'required'

		),
		
		'birth_date' => array(

			'form' 		=> 'date',
			'type' 		=> 'date',
			'len'  		=> null,
			'prefix'	=> 'birth'

		),

	),

);