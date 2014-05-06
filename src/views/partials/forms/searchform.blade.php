<div class="search-form">
	{{ Form::open(array('route' => $model.'.search'), array('class' => 'form-inline', 'role' => 'form')) }}
		<div class="row">
			<div class="col-xs-2">
				<select name="field" id="field" class="form-control">
					@foreach($items as $item)
					<option value="{{$item}}"{{ Tool::isSelected(Input::old('field'), $item) }}>{{ t('form.search.'.$item) }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-2 no-margin">
				<select name="type" id="type" class="form-control">
					<option value="equal"{{ Tool::isSelected(Input::old('type'), 'equal') }}>{{ t('form.search.equal_to') }}</option>
					<option value="contain"{{ Tool::isSelected(Input::old('type'), 'contain') }}>{{ t('form.search.contains') }}</option>
					<option value="start"{{ Tool::isSelected(Input::old('type'), 'start') }}>{{ t('form.search.start_by') }}</option>
				</select>
			</div>
			<div class="col-xs-6">
				<input type="text" name="q" class="form-control" value="{{Input::old('q')}}" placeholder="{{t('placeholder.search')}}">
			</div>
			<div class="col-xs-2 no-margin-left">
				<button class="btn btn-primary pongo-form-submit pongo-loading">
					<i class="fa fa-search"></i> {{ t('form.button.search') }}
				</button>
			</div>
		</div>
	{{ Form::close() }}
</div>