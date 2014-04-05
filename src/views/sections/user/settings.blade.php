@extends('cms::layouts.base')

@section('element-bar')
	@include('cms::partials.rightbars.userbar')
@stop

@section('option-bar')
	@include('cms::partials.options.user')
@stop

@section('subbar')
	@include('cms::partials.subbars.user')
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/sections/user.js')}}
	{{Render::asset('scripts/sections/role.js')}}
	{{Render::asset('scripts/vm/user/settings.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.page.'.$section.'_title')}}</h3>

	<form role="form" id="user-settings-form">
		<input type="hidden" name="user_id" value="{{$user_id}}">
		<div class="form-group" rel="name">
			<label for="name" class="control-label">{{t('label.user.settings.name')}} <span class="counter" data-bind="text: nameLen"></span></label>
			<input type="text" name="name" class="form-control" id="name" value="{{$name}}" data-bind="value: itemName, valueUpdate: 'afterkeydown'">
		</div>
		<div class="form-group" rel="email">
			<label for="email" class="control-label">{{t('label.user.settings.email')}}</label>
			<input type="text" name="email" class="form-control" id="email" value="{{$email}}">
		</div>
		<div class="form-group">
			<label for="editor" class="control-label">{{t('label.user.settings.editor')}}</label>
			<select name="editor" class="form-control" id="editor">
				@foreach($editors as $editor_id => $editor)
				<option value="{{$editor_id}}"{{selected($editor_id, $editor_selected)}}>{{$editor}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="lang" class="control-label">{{t('label.user.settings.lang')}}</label>
			<select name="lang" class="form-control" id="lang">
				@foreach($langs as $code => $lang)
				<option value="{{$code}}"{{selected($code, $lang_selected)}}>{{$lang['lang']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-buttons">
			{{link_to_route('api.user.settings.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
			<a href="#delete-modal" class="btn btn-danger btn-block confirm">{{t('form.button.delete')}}</a>
		</div>
	</form>

@stop



@section('modal')

	<div class="modal-box" id="delete-modal">
		<button type="button" class="close close-modal">&times;</button>
		<h3>{{t('modal.title.delete_user')}}</h3>
		<form action="{{route('api.user.settings.delete')}}" method="POST">
			<input type="hidden" name="user_id" value="{{$user_id}}">
			<div class="form-buttons">
				<button type="button" class="btn btn-default button close-modal">{{t('form.button.cancel')}}</button>
				<button type="submit" class="btn btn-danger">{{t('form.button.ok')}}</button>
			</div>
		</form>

	</div>

@stop