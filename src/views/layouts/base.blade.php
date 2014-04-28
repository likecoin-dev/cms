@extends('cms::templates.default')

@section('layout')
	
	{{Pongo::showAlert()}}

	@yield('modal')

	<div class="wrapper">

		@include('cms::partials.navbar')

		<div class="container">

			@yield('content')

		</div>

		<footer>PongoCMS v2.0.1 - 2014 &copy; Pongoweb.it</footer>

		@yield('debug')
		
	</div>

@stop

@section('sidebar')
	@include('cms::partials.sidebar')
@stop

@section('footer-js')
	{{Render::asset('js/logged.js')}}
@stop