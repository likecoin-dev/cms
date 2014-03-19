<?php

return array(

	/**
	 * Available Marker settings
	 */

	'BACK' => array(

		'api' 		=> array(),

		'class' 	=> 'Pongo\Cms\Classes\Markers\BackMarker',

		'default' 	=> '[$BACK[]]',

	),

	'IMAGE' => array(

		'api'		=> array(

			'file' 	=> array('file_name', 'str', true),
			'w'		=> array('width', 'int', false),
			'h'		=> array('height', 'int', false),

		),

		'class'		=> 'Pongo\Cms\Classes\Markers\ImageMarker',

		'default' 	=> '[$IMAGE[file:{file name}]]',

	),

);