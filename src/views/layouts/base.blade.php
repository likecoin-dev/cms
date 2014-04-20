@extends('cms::templates.default')

@section('layout')
	
	<div class="wrapper">

		{{Pongo::showAlert()}}

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

@yield('modal')

@section('footer-js')
	{{Render::asset('js/logged.js')}}
@stop