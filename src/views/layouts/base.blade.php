@extends('cms::templates.default')

@section('page-bar')
	@include('cms::partials.pagebar')
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/sections/page.js')}}
@stop

@section('layout')
	
	<div class="wrapper">

		{{Pongo::showAlert()}}

		@include('cms::partials.navbar')

		<div id="page" class="row">
			
			@yield('option-bar')

			@yield('element-bar')

			@yield('subbar')

			<div id="page-panel" class="col-xs-12">

				<div id="overlay"></div>

				@yield('content')

			</div>

		</div>
		
	</div>

@stop