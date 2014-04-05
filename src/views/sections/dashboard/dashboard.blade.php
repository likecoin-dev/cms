@extends('cms::layouts.base')

@section('header')	
	@parent
@stop

@section('footer-js')
	@parent
	{{--Render::asset('scripts/sections/dashboard.js')--}}
@stop

@section('content')

	<h1>Dashboard</h1>

	{{LEVEL}}

	{{MARKER('[$IMAGE[{"file":"test.jpg", "value":"1"}]]')}}

	{{MARKER('[$IMAGE[file:test.jpg|value:1]]')}}

	{{MARKER('[$IMAGE[file:test.jpg]]')}}

	{{MARKER('[$IMAGE[file:test.jpg|value1:1|value2:2]]')}}

@stop