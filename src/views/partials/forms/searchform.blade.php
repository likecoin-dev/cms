<div class="search-form">
	{{ Form::open(array('route' => 'api.'.$model.'.search'), array('class' => 'form-inline', 'role' => 'form')) }}
		<div class="row">
			<div class="col-xs-2">
				<select name="field" id="field" class="form-control">
					@foreach($items as $item)
					<option value="{{$item}}">{{t('form.select.'.$item)}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-2 no-margin">
				<select name="search" id="search" class="form-control">
					<option value="equal">{{t('form.select.equal_to')}}</option>
					<option value="contain">{{t('form.select.contains')}}</option>
				</select>
			</div>
			<div class="col-xs-6">
				<input type="text" name="q" class="form-control" placeholder="{{t('placeholder.search')}}">
			</div>
			<div class="col-xs-2 no-margin-left">
				<button class="btn btn-primary pongo-submit">
					<i class="fa fa-search"></i> {{t('form.button.search')}}
				</button>
			</div>
		</div>
	{{ Form::close() }}
</div>