@extends('cms::layouts.base')

@section('element-bar')
	@include('cms::partials.rightbars.layoutbar')
@stop

@section('option-bar')
	@include('cms::partials.options.page')
@stop

@section('subbar')
	@include('cms::partials.subbars.layout')
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/vm/page/layout.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.page.'.$section.'_title')}}</h3>

	<form role="form" id="page-layout-form">
		<input type="hidden" name="page_id" value="{{$page_id}}">
		<div class="form-group">
			<label for="template" class="control-label">{{t('label.page.layout.template')}}</label>
			<select name="template" class="form-control" id="template">
				@foreach($templates as $name => $template)
				<option value="{{$name}}"{{selected($name, $template_selected)}}>{{st('settings.template.' . $name, $template)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="header" class="control-label">{{t('label.page.layout.header')}}</label>
			<select name="header" class="form-control" id="header">
				@foreach($headers as $name => $header)
				<option value="{{$name}}"{{selected($name, $header_selected)}}>{{st('settings.header.' . $name, $header)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="layout" class="control-label">{{t('label.page.layout.layout')}}</label>
			<select name="layout" class="form-control" id="layout">
				@foreach($layouts as $name => $layout)
				<option value="{{$name}}"{{selected($name, $layout_selected)}}>{{st('settings.layout.' . $name, $layout)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="footer" class="control-label">{{t('label.page.layout.footer')}}</label>
			<select name="footer" class="form-control" id="footer">
				@foreach($footers as $name => $footer)
				<option value="{{$name}}"{{selected($name, $footer_selected)}}>{{st('settings.footer.' . $name, $footer)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-buttons">
			{{link_to_route('api.page.layout.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
		</div>
	</form>

@stop