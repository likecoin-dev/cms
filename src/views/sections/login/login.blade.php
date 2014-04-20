@extends('cms::templates.default')

@section('layout')
	<div class="container">
		{{ Pongo::showAlert() }}
		<div class="section" id="login">
			<div class="row">
				<div class="col-sm-12">
					<h1>Pongo<span>CMS</span> <small>v2</small></h1>
					{{ Form::open(array('route' => 'post.login')) }}
						<div class="form-group" rel="username">
							<label for="username">{{ t('label.login.form.username') }}</label>
							<input type="text" class="form-control" name="username" autocorrect="off" autocapitalize="off" placeholder="{{ t('form.placeholder.username') }}">
						</div>
						<div class="form-group" rel="password">
							<label for="password">{{ t('label.login.form.password') }}</label>
							<input type="password" class="form-control" name="password" placeholder="{{ t('form.placeholder.password') }}">
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label class="checkbox-inline">
										<input type="checkbox" name="remember"> {{ t('label.login.form.remember') }}
									</label>
								</div>
								<div class="col-md-6">
									<select name="cmslang" class="form-control">
										@foreach ($languages as $key => $lang)
										<option value="{{ $key }}">{{ $lang['lang'] }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="pongo-login btn btn-primary btn-block">login</button>
						</div>
					{{ Form::close() }}
					<footer>PongoCMS v2.0.0 &copy; Pongoweb.it</footer>
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer-js')
	{{Render::asset('js/pages/login.js')}}
@stop