<div class="wrapper-search">
	{{ Form::open(array('method' => 'post', 'id' => 'search-form')) }}
		<div class="form-group">
			<div class="input-group">
				{{ Form::input($type, $name, $value, $options) }}
				<span class="input-group-btn">
					<button class="btn btn-default button" type="button" id="submit-search">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>

			@foreach($fields as $key => $field)
				<label class="radio-inline">
					<input type="radio" name="field" value="{{ $field }}"{{ checked($key, 0) }}> <span>{{ $field }}</span>
				</label>
			@endforeach
		</div>

	{{ Form::close() }}
</div>