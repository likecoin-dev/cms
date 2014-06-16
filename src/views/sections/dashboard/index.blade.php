@extends('cms::layouts.base')

@section('content')
	
	<div class="section" id="dashboard">
					
		{{ Render::sectionDashboard() }}

	</div>

@stop

@section('sidebar-right')

	@include('cms::sections.dashboard.partials.settings')

@stop

@section('footer-js')
	
	@parent

	{{ Render::asset('js/sections/dashboard.js') }}

@stop