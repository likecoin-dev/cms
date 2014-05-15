@extends('cms::layouts.base')

@section('element-bar')
	@include('cms::partials.rightbars.layoutbar')
@stop

@section('option-bar')
	@include('cms::partials.options.element')
@stop

@section('subbar')
	@include('cms::partials.subbars.layout')
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/vm/element/settings.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.page.'.$section.'_title')}}</h3>

	<form role="form" id="element-settings-form">
		<input type="hidden" name="page_id" value="{{$page_id}}">
		<input type="hidden" name="element_id" value="{{$element_id}}">

		<div class="form-group" rel="name">
			<label for="name" class="control-label">{{t('label.element.settings.name')}}</label>
			<input type="text" name="name" class="form-control" id="name" value="{{$name}}" data-bind="value: itemName, valueUpdate: 'afterkeydown'">
		</div>
		<div class="form-group" rel="attrib">
			<label for="attrib" class="control-label">{{t('label.element.settings.attrib')}}</label>
			<div class="input-group">
				<span class="input-group-addon">#</span>
				<input type="text" name="attrib" class="form-control" id="attrib" value="{{$attrib}}" data-bind="value: elementAttrib">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default button" data-bind="click: createAttrib">{{t('label.element.settings.create_attrib')}}</button>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="zone" class="control-label">{{t('label.element.settings.zone')}}</label>
			<select name="zone" class="form-control" id="zone">
				@foreach($zones as $zone => $name)
				<option value="{{$zone}}"{{selected($zone, $zone_selected)}}>{{st('settings.layout.' . $zone, $name)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-buttons">
			{{link_to_route('api.element.settings.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
			<a href="#clone-modal" class="btn btn-primary btn-block confirm">{{t('form.button.clone')}}</a>
			<a href="#delete-modal" class="btn btn-danger btn-block confirm">{{t('form.button.delete')}}</a>
		</div>
	</form>

@stop



@section('modal')

	<div class="modal-box" id="delete-modal">
		<button type="button" class="close close-modal">&times;</button>
		<h3>{{t('modal.title.detach_element')}}</h3>
		<form action="{{route('api.element.settings.delete')}}" method="POST">
			<input type="hidden" name="page_id" value="{{$page_id}}">
			<input type="hidden" name="element_id" value="{{$element_id}}">
			<div class="form-buttons">				
				<button type="button" class="btn btn-default button close-modal">{{t('form.button.cancel')}}</button>
				<button type="submit" class="btn btn-danger">{{t('form.button.ok')}}</button>
			</div>
		</form>

	</div>

	<div class="modal-box" id="clone-modal">
		<button type="button" class="close close-modal">&times;</button>
		<h3>{{t('modal.title.clone_element')}}</h3>
		<form action="{{route('api.element.settings.clone')}}" method="POST">
			<input type="hidden" name="page_id" value="{{$page_id}}">
			<input type="hidden" name="element_id" value="{{$element_id}}">
			<div class="form-group cloning">
				<label class="control-label">{{t('label.element.settings.page_target')}}:</label>
				<div class="cloning">
					<ol class="first">
						{{Load::pageForm(0, LANG, $page_id)}}
					</ol>
				</div>
			</div>
			<div class="form-buttons">				
				<button type="button" class="btn btn-default button close-modal">{{t('form.button.cancel')}}</button>
				<button type="submit" class="btn btn-danger">{{t('form.button.ok')}}</button>
			</div>
		</form>

	</div>

@stop