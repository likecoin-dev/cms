<?php namespace Pongo\Cms\Classes;

use Pongo\Cms\Services\Validators\GenericValidator as GenericValidator;

class Build {

	/**
	 * Manage custom fields
	 * 
	 * @param  string $form
	 * @param  string $name
	 * @param  array  $attributes
	 * @param  string $value
	 * @param  string $opt_values
	 * @param  string $prefix
	 * @return string
	 */
	public function customField($form, $name, $attributes = array(), $value = null, $opt_values = null, $prefix = null)
	{
		switch ($form) {
			case 'date':
				return $this->dateField($name, $attributes, $prefix);
				break;

			case 'datetime':
				return $this->dateTimeField($name, $attributes, $prefix);
				break;

			case 'multiRadio':
				return $this->multiRadioField($name, $attributes, $opt_values);
				break;
			
			default:
				return 'No method ' . $form;
				break;
		}
	}

	/**
	 * Create date form control
	 * 
	 * @param  string  $name        
	 * @param  array   $attributes
	 * @param  integer $year_past
	 * @param  integer $year_future
	 * @return string
	 */
	public function dateField($name, $attributes = array(), $prefix, $year_past = 99, $year_future = 1)
	{
		$item_view = \Render::view('partials.forms.dates.date');
		$item_view['name']			= $name;
		$item_view['date']			= \Carbon\Carbon::now();
		$item_view['day_name']		= $prefix . '_day';
		$item_view['month_name']	= $prefix . '_month';		
		$item_view['year_name']		= $prefix . '_year';
		$item_view['year_past']		= $year_past;
		$item_view['year_future'] 	= $year_future;
		$item_view['months']		= $this->monthNames();

		return $item_view;
	}

	/**
	 * Create date time form control
	 * 
	 * @param  string  $name        
	 * @param  array   $attributes
	 * @param  integer $year_past
	 * @param  integer $year_future
	 * @return string
	 */
	public function dateTimeField($name, $attributes = array(), $prefix, $year_past = 99, $year_future = 1)
	{
		$item_view = \Render::view('partials.forms.dates.datetime');
		$item_view['name']			= $name;
		$item_view['date']			= \Carbon\Carbon::now();
		$item_view['day_name']		= $prefix . '_day';
		$item_view['month_name']	= $prefix . '_month';
		$item_view['year_name']		= $prefix . '_year';
		$item_view['hh_name']		= $prefix . '_hh';
		$item_view['mm_name']		= $prefix . '_mm';
		$item_view['year_past']		= $year_past;
		$item_view['year_future'] 	= $year_future;
		$item_view['months']		= $this->monthNames();
		$item_view['hours']			= $this->timeHours();
		$item_view['minutes']		= $this->timeMinutes();

		return $item_view;
	}

	/**
	 * Build an input fields list to put inside a form
	 * 
	 * @param  array $input_form
	 * @param  string $label_ns
	 * @return blade view
	 */
	public function formFields($input_form, $label_ns, $value = null)
	{
		$form_view = '';

		foreach ($input_form as $name => $option) {
			$field_view = \Render::view('partials.forms.fielditem');

			$field_view['name'] 		= $name;
			$field_view['form'] 		= $option['form'];
			$field_view['value'] 		= $value;
			$field_view['opt_values']	= array_key_exists('values', $option) ? $option['values'] : null;
			$field_view['prefix']		= array_key_exists('prefix', $option) ? $option['prefix'] : null;
			$field_view['label'] 		= array_key_exists('label', $option) ? $option['label'] : $label_ns . '.' . $name;
			$field_view['validate'] 	= array_key_exists('validate', $option) ? $option['validate'] : null;

			$form_view .= $field_view . "\n";
		}

		return $form_view;
	}

	/**
	 * Build an input field
	 * 
	 * @param  string $form
	 * @param  string $name
	 * @param  string $prefix
	 * @param  array  $attributes
	 * @param  mixed $value
	 * @param  string $opt_values
	 * @return string
	 */
	public function inputField($form, $name, $prefix = null, $attributes = array(), $value = null, $opt_values = null)
	{
		if(method_exists(app('form'), $form)) {

			return \Form::$form($name, $value, $attributes);

		} else {

			return $this->customField($form, $name, $attributes, $value, $opt_values, $prefix);
		}
	}

	/**
	 * Create months array
	 * 
	 * @return array
	 */
	protected function monthNames()
	{
		$months = array();

		for ($i = 1; $i <= 12; $i++) { 
			$months[$i] = t('datetime.month.' . $i);
		}

		return $months;
	}

	/**
	 * [multiRadioField description]
	 * @param  [type] $name       [description]
	 * @param  array  $attributes [description]
	 * @return [type]             [description]
	 */
	public function multiRadioField($name, $attributes = array(), $opt_values)
	{
		$options = explode('|', $opt_values);

		$item_view = \Render::view('partials.forms.radiooptions');
		$item_view['name']	= $name;
		$item_view['options'] = $options;

		return $item_view;
	}

	/**
	 * Build a search input
	 * 
	 * @param  string $type
	 * @param  string $name
	 * @param  string $value
	 * @param  array  $options
	 * @param  array  $fields
	 * @return blade view
	 */
	public function searchField($type, $name, $value = null, $options = array(), $fields = array())
	{
		$field_view = \Render::view('partials.forms.searchitem');
		$field_view['type'] 	= $type;
		$field_view['name'] 	= $name;
		$field_view['value'] 	= $value;
		$field_view['options'] 	= $options;
		$field_view['fields'] 	= $fields;

		return $field_view;
	}

	/**
	 * Create hours array
	 * 
	 * @return array
	 */
	protected function timeHours()
	{
		$hours = array();

		for ($i = 0; $i <= 23; $i++) { 
			$hours[\Tool::addZero($i)] = \Tool::addZero($i);
		}

		return $hours;
	}

	/**
	 * Create minutes array
	 * 
	 * @return array
	 */
	protected function timeMinutes()
	{
		$minutes = array();

		for ($i = 0; $i <= 59; $i++) { 
			$minutes[\Tool::addZero($i)] = \Tool::addZero($i);
		}

		return $minutes;
	}

	/**
	 * Write validations rules hidden field
	 * 
	 * @param  string $name
	 * @param  string $validation_rules
	 * @return string
	 */
	public function validateField($name, $validation_rules = null)
	{
		if(!is_null($validation_rules)) {

			return \Form::hidden("valid[$name]", $validation_rules) . "\n";
		}
	}

	/**
	 * Validate an auto-build form
	 * 
	 * @return array variables 
	 */
	public function validForm()
	{
		$input = \Input::all();

		if(is_array($input['valid'])) {

			$v = new GenericValidator($input['valid']);

			if(! $v->passes()) return json_encode($v->formatErrors());
		}

		return $input;
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