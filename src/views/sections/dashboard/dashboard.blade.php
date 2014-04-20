@extends('cms::layouts.base')

@section('content')
	
	<div class="section" id="dashboard">
					
		{{Render::sectionDashboard()}}

	</div>

@stop

@section('footer-js')
	@parent
	{{Render::asset('js/pages/dashboard.js')}}
@stop

@section('debug')
{{--LEVEL}}
{{MARKER('[$IMAGE[{"file":"test.jpg", "value":"1"}]]')}}
{{MARKER('[$IMAGE[file:test.jpg|value:1]]')}}
{{MARKER('[$IMAGE[file:test.jpg]]')}}
{{MARKER('[$IMAGE[file:test.jpg|value1:1|value2:2]]')--}}
@stop