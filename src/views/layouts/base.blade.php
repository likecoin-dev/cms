@extends('cms::templates.default')

@section('layout')
	
	{{Pongo::showAlert()}}

	@section('modal')
		
		@include('cms::partials.modals.pagedelete')

	@show

	<div class="wrapper">

		@include('cms::partials.navbar')

		<div class="overlay fade in"></div>

		<div class="container cms">

			@yield('content')

		</div>

		@include('cms::partials.footer')

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