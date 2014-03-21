<?php namespace Pongo\Cms\Classes;

class Marker {

	/**
	 * Print marker api
	 * 
	 * @param  string $marker
	 * @return string
	 */
	public function api($marker)
	{
		$view = \Render::view('partials.items.markerapi');

		$view['apis'] = \Pongo::markers($marker . '.api');

		return $view;
	}

	/**
	 * Decode Marker string text
	 * 
	 * @param  string $text Marker code
	 * @return string 		Marker's decoded blade view
	 */
	public function decode($text)
	{		
		$tmp_text = trim($text);

		//con json
		preg_match_all('/\[\$([!?A-Z_]+)\[([^$]+)?\]\]/i', $tmp_text, $matches);

		foreach ($matches[0] as $key => $value) {

			// Original marker string
			$marker_original = $matches[0][$key];

			// Method to execute
			$method = $matches[1][$key];

			// String found
			$found = $matches[2][$key];

			// Check if marker method is IoCed
			if (\App::bound($method)) {

				// Clean HTML
				$found = strip_tags($found);

				$found = html_entity_decode($found);

				// Try to decode Json $found
				$result = json_decode($found, true);

				// Check if $found is Json otherwise format it and return
				$vars = !is_null($result) ? $result : $this->formatNotJson($found);

				if ( ! is_array($vars) ) $vars = array();

				$decoded = $this->$method($vars);

			} else {

				return $marker_original;

			}

		}

		return $decoded;
	}

	/**
	 * Print marker default
	 * 
	 * @param  string $marker
	 * @return string
	 */
	public function defaults($marker)
	{
		return \Pongo::markers($marker . '.default');
	}

	/**
	 * Print marker description
	 * 
	 * @param  string $marker
	 * @return string
	 */
	public function description($marker)
	{
		return t('marker.' . strtolower($marker) . '.description');
	}

	/**
	 * Format string found and return like a json
	 * 
	 * @param  string $string_found
	 * @return array
	 */
	protected function formatNotJson($string_found)
	{
		$variables = explode('|', $string_found);

		$format = array();

		foreach ($variables as $variable) {
			
			$values = explode(':', $variable);

			$name 	= $values[0];
			
			$value 	= $values[1];
				
			$format[$name] = $value;
		}

		return $format;
	}

	/**
	 * Print mandatory or optional
	 * 
	 * @param  bool  $value
	 * @return string
	 */
	public function isMandatory($value)
	{
		return $value ? t('marker._api.mandatory') : t('marker._api.optional');
	}

	/**
	 * Get Class name back
	 * 
	 * @return string Name of the class
	 */
	public function className()
	{
		return get_class($this);
	}

	/**
	 * Marker magic method
	 * 
	 * @param  string $name      Marker tag
	 * @param  array $arguments  Marker arguments
	 * @return string            Marker's decoded blade view
	 */
	public function __call($name, $arguments)
	{		
		// Instantiate marker class
		$marker = \App::make($name);

		// Pass tag name
		$marker->name = $name;

		// Pass arguments as parameters
		$marker->parameters = $arguments;

		// Run instance
		return $marker->run();
	}

}