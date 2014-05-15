<div class="tab-pane active" id="settings">

	{{ Form::open(array('route' => 'api.role.save')) }}

		{{ Form::hidden('id', $role->id) }}
		{{ Form::hidden('section', 'settings') }}
		
		<div class="form-group" rel="name">
			{{ Form::label('name', t('label.role.settings.name')) }}
			{{ Form::text('name', $role->name, array('class' => 'form-control', 'placeholder' => t('placeholder.role.settings.name'), 'data-bind' => 'value: itemName, valueUpdate: "afterkeydown"')) }}
		</div>
		
		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{ t('form.button.save') }}</button>
			<a href="{{route('roles')}}" class="btn btn-primary">{{ t('form.button.back') }}</a>
		</div>

	{{ Form::close() }}

</div>