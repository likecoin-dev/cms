<div class="form-inline">
@foreach($options as $option)

	<label class="radio mini">

		{{Form::radio($name, $option)}}
		<strong></strong>
		{{t('form.' . $name . '.' . $option)}}

	</label>

@endforeach
</div>