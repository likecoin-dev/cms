<div class="form-group" rel="{{$name}}">
	<label for="{{$name}}">{{t('label.' . $label)}}</label>
	{{Build::inputField($form, $name, $prefix, array('class' => 'form-control', 'id' => $name), $value, $opt_values)}}
	{{Build::validateField($name, $validate)}}
</div>