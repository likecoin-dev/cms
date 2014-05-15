@extends('cms::templates.default')

@section('layout')
	
	{{Pongo::showAlert()}}

	@section('modal')
		
		@include('cms::partials.modals.pagedelete')

	@show

	<div class="wrapper">

		@include('cms::partials.navbar')

		<div class="overlay fade in"></div>

		<div class="container">

			@yield('content')

		</div>

		<footer>PongoCMS v2.0.1 - 2014 &copy; Pongoweb.it</footer>

		@yield('debug')
		
	</div>

@stop

@section('sidebar')
	
	@yield('sidebar-right')

	@include('cms::partials.sidebar')

@stop

@section('footer-js')
	{{Render::asset('js/logged.js')}}
@stop