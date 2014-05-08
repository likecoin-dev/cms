<div class="tab-pane" id="details">

	{{ Form::model($user->details, array('route' => 'api.user.save.details')) }}

		{{ Form::hidden('id', $user->id) }}
		{{ Form::hidden('section', 'details') }}
		
		{{Build::formFields($input_form, 'user.details')}}
		
		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{ t('form.button.save') }}</button>
			<a href="{{ route('users') }}" class="btn btn-primary">{{ t('form.button.back') }}</a>
		</div>

	{{ Form::close() }}

</div>