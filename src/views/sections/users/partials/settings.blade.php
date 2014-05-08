<div class="tab-pane active" id="settings">

	{{ Form::open(array('route' => 'api.user.save.settings')) }}

		{{ Form::hidden('id', $user->id) }}
		{{ Form::hidden('section', 'settings') }}
		
		<div class="form-group" rel="username">
			{{ Form::label('username', t('label.user.settings.username')) }}
			{{ Form::text('username', $user['username'], array('class' => 'form-control', 'placeholder' => t('placeholder.user.settings.username'))) }}
		</div>

		<div class="form-group" rel="email">
			{{ Form::label('email', t('label.user.settings.email')) }}
			{{ Form::text('email', $user['email'], array('class' => 'form-control', 'placeholder' => t('placeholder.user.settings.email'))) }}
		</div>

		<div class="form-group">
			{{ Form::label('editor', t('label.user.settings.editor')) }}
			{{ Form::select('editor', Pongo::settings('editors'), $user['editor'], array('id' => 'editor', 'class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('lang', t('label.user.settings.lang')) }}
			{{ Form::select('lang', Pongo::languages(), $user['lang'], array('id' => 'lang', 'class' => 'form-control')) }}
		</div>
		
		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{t('form.button.save')}}</button>
			<a href="{{ route('users') }}" class="btn btn-primary">{{ t('form.button.back') }}</a>
		</div>

	{{ Form::close() }}

</div>