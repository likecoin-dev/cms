<?php namespace Pongo\Cms\Classes;

class Tool {	

	/**
	 * Find attributes in a html tag string
	 * 
	 * @param  string $attrib
	 * @param  string $text
	 * @return string
	 */
	public function getAllAttributes($attrib, $text)
	{
		$regex = '/' . preg_quote($attrib) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';

		if (preg_match_all($regex, $text, $match)) {

			return $match[2];
		}

		return false;
	}

	/**
	 * Add class= .. active if true
	 * 
	 * @param  string $var 
	 * @param  string $fix 
	 * @return bool
	 */
	public function addActive($var, $fix)
	{
		return ($var == $fix) ? ' active' : '';
	}

	/**
	 * Lead zero to number
	 * @param int $number
	 */
	public function addZero($number)
	{
		return ($number < 10) ? '0' . $number : $number;
	}

	/**
	 * Print out class=active if true
	 * 
	 * @param  string $var 
	 * @param  string $fix 
	 * @return bool
	 */
	public function isActive($var, $fix)
	{
		return ($var == $fix) ? ' class="active"' : '';
	}

	/**
	 * Print out checked=checked if true
	 * 
	 * @param  string $var 
	 * @param  string $fix 
	 * @return bool
	 */
	public function isChecked($var, $fix)
	{
		if(is_array($fix)) {

			return (in_array($var, $fix)) ? ' checked="checked"' : '';
		}

		return ($var == $fix) ? ' checked="checked"' : '';
	}

	/**
	 * Print icon homepage
	 * 
	 * @param  string $is_valid
	 * @return string
	 */
	public function isHome($is_home)
	{
		return ($is_home) ? '<i class="fa fa-home" style="display: visible"></i>' : '<i class="fa fa-home" style="display: none"></i>';
	}

	/**
	 * Print out selected=selected if true
	 * 
	 * @param  string $var 
	 * @param  string $fix 
	 * @return bool
	 */
	public function isSelected($var, $fix)
	{
		return ($var == $fix) ? ' selected="selected"' : '';
	}

	/**
	 * Print class invalid if not valid
	 * 
	 * @param  string $is_valid
	 * @return string
	 */
	public function isValid($is_valid)
	{
		return (!$is_valid) ? ' invalid' : '';
	}

	/**
	 * Print icon checked/unchecked
	 * 
	 * @param  string $is_valid
	 * @return string
	 */
	public function unChecked($is_valid)
	{
		return ($is_valid) ? '<i class="fa fa-check-square-o check"></i>' : '<i class="fa fa-unchecked check"></i>';
	}

	/**
	 * Reduce slug chunks
	 * 
	 * @param  string  $url  
	 * @param  integer $back Chunks to subtract
	 * @return string        Partial slug
	 */
	public function slugBack($url, $back = 0)
	{
		if($back > 0) {

			$segments = explode('/', $url);

			if(is_array($segments)) {

				$n_segments = count($segments) - $back;

				$tmp_url = '';

				for ($i=1; $i < $n_segments; $i++) {

					$tmp_url .= '/' . $segments[$i];
				}

				return $tmp_url;
			}

		}

		return $url;
	}
	
	/**
	 * Slice a slug in chunks
	 * 
	 * @param  string  $url
	 * @param  integer $back
	 * @return mixed	back = 1 string || back > 1 array
	 */
	public function slugSlice($url, $back = 0)
	{
		if($back > 0) {

			$segments = array_reverse(explode('/', $url));

			array_pop($segments);

			if(is_array($segments)) {

				if($back == 1) {

					return $segments[0];
				}

				return $segments;
			}

		}

		return $url;
	}

	/**
	 * Validate a date by its format
	 * 
	 * @param  date $date
	 * @param  string $format
	 * @return bool
	 */
	public function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = \Carbon\Carbon::createFromFormat($format, $date);
		
		return !empty($d) && $d->format($format) == $date;
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

}