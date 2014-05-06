<div class="form-inline">
@foreach($options as $option)
	<label>
		{{Form::radio($name, $option)}}	{{t('form.' . $name . '.' . $option)}}
	</label>
@endforeach
</div>