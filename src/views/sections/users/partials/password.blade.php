<div class="tab-pane" id="password">

	{{ Form::open(array('route' => 'api.user.save.password')) }}

		{{ Form::hidden('id', $user->id) }}
		{{ Form::hidden('section', 'password') }}
		
		<div class="form-group" rel="password_now">
			{{ Form::label('password_now', t('label.user.password.password_now')) }}
			{{ Form::password('password_now', array('class' => 'form-control', 'placeholder' => t('placeholder.user.password.password_now'))) }}
		</div>

		<div rel="password" data-bind="css: fieldStatus">
			{{ Form::label('password', t('label.user.password.password')) }}
			{{ Form::password('password', array('class' => 'form-control', 'placeholder' => t('placeholder.user.password.password'), 'data-bind' => 'value: itemPassword, valueUpdate: "afterkeydown"')) }}
			<span class="glyphicon glyphicon-warning-sign form-control-feedback" data-bind="visible: iconFeedbackError"></span>
			<span class="glyphicon glyphicon-ok form-control-feedback" data-bind="visible: iconFeedback"></span>
		</div>

		<div class="form-group" rel="password_confirmation" data-bind="css: passwordCheck">
			{{ Form::label('password_confirmation', t('label.user.password.password_confirmation')) }}
			{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => t('placeholder.user.password.password_confirmation'), 'data-bind' => 'value: itemConfirmed, valueUpdate: "afterkeydown"')) }}
			<span class="glyphicon glyphicon-warning-sign form-control-feedback" data-bind="visible: iconCheckError"></span>
			<span class="glyphicon glyphicon-ok form-control-feedback" data-bind="visible: iconCheck"></span>
		</div>
		
		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{t('form.button.save')}}</button>
			<a href="{{ route('users') }}" class="btn btn-primary">{{ t('form.button.back') }}</a>
		</div>

	{{ Form::close() }}

</div>