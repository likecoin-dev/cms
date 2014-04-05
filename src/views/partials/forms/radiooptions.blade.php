@foreach($options as $option)
	<label class="radio-inline">
		{{Form::radio($name, $option)}}	{{t('form.' . $name . '.' . $option)}}
	</label>
@endforeach