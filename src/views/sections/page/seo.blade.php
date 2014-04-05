@extends('cms::layouts.base')

@section('element-bar')
	@include('cms::partials.rightbars.elementbar')
@stop

@section('option-bar')
	@include('cms::partials.options.page')
@stop

@section('subbar')
	@include('cms::partials.subbars.element')
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/vm/page/seo.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.page.'.$section.'_title')}}</h3>

	<form role="form" id="page-seo-form">
		<input type="hidden" name="page_id" value="{{$page_id}}">
		<div class="form-group">
			<label for="title" class="control-label">{{t('label.page.seo.title')}}  <span class="counter" data-bind="text: titleLen"></span></label>
			<input type="text" name="title" class="form-control" id="title" value="{{$title}}" data-bind="value: pageTitle, valueUpdate: 'afterkeydown'">
		</div>
		<div class="form-group">
			<label for="keyw" class="control-label">{{t('label.page.seo.keyw')}}</label>
			<input type="text" name="keyw" class="form-control" id="keyw" value="{{$keyw}}">
		</div>
		<div class="form-group">
			<label for="descr" class="control-label">{{t('label.page.seo.descr')}} <span class="counter" data-bind="text: descrLen"></span></label>
			<textarea name="descr" class="form-control" id="descr" data-bind="value: pageDescr, valueUpdate: 'afterkeydown'">{{$descr}}</textarea>
		</div>
		<div class="form-buttons">
			{{link_to_route('api.page.seo.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
		</div>
	</form>

@stop