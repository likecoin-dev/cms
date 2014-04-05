@extends('cms::templates.default')

@section('layout')

	<div class="container">

		{{Pongo::showAlert()}}

		<div class="section" id="login">

			<div class="row">

				<div class="col-sm-12">

					<h1>Pongo<span>CMS</span> <small>v2</small></h1>

					{{Form::open(array('route' => 'post.login'))}}
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" autocorrect="off" autocapitalize="off" placeholder="{{t('form.placeholder.username')}}">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password" placeholder="{{t('form.placeholder.password')}}">
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary btn-block login">login</button>
						</div>
					{{Form::close()}}

					<footer>PongoCMS v2.0.0 &copy; Pongoweb.it</footer>

				</div>

			</div>

		</div>

	</div>

@stop