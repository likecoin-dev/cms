@extends('cms::templates.default')

@section('layout')
	<div class="container">
		{{ Pongo::showAlert() }}
		<div class="section" id="login">
			<div class="row">
				<div class="col-sm-12">
					<h1>Pongo<span>CMS</span> <small>v2</small></h1>
					{{ Form::open(array('route' => 'api.login')) }}
						
						{{ Form::hidden('section', 'login') }}

						<div class="form-group" rel="username">
							{{ Form::label('username', t('label.login.form.username')) }}
							{{ Form::text('username', null, array('class' => 'form-control', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'placeholder' => t('placeholder.login.username'))) }}
						</div>
						<div class="form-group" rel="password">
							{{ Form::label('password', t('label.login.form.password')) }}
							{{ Form::password('password', array('class' => 'form-control', 'placeholder' => t('placeholder.login.password'))) }}
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label class="checkbox-inline"><input type="checkbox" name="remember"> {{ t('label.login.form.remember') }}</label>
								</div>
								<div class="col-md-6">
									{{ Form::select('cmslang', Pongo::languages(), null, array('class' => 'form-control')) }}
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="pongo-ajax-submit pongo-loading btn btn-primary btn-block">{{t('form.button.login')}}</button>
						</div>
					{{ Form::close() }}
					<footer>PongoCMS v2.0.0 &copy; Pongoweb.it</footer>
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer-js')
	{{Render::asset('js/sections/login.js')}}
@stop