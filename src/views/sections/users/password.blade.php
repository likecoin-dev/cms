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
	{{Render::asset('scripts/vm/user/password.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.user.'.$section.'_title')}}</h3>

	<form role="form" id="user-password-form">
		<input type="hidden" name="user_id" value="{{$user_id}}">
		<input type="hidden" name="name" id="name" value="{{$name}}" data-bind="value: itemName">
		<div class="form-group" rel="password">
			<label for="password" class="control-label">{{t('label.user.password.password')}} <span class="counter" data-bind="text: passwordLen, css: {red: passwordLen() <= 8}"></span></label>
			<input type="password" name="password" class="form-control" id="password" value="" data-bind="value: itemPassword, valueUpdate: 'afterkeydown'">
		</div>
		<div class="form-group" rel="password_confirmation">
			<label for="password_confirmation" class="control-label">{{t('label.user.password.password_confirmation')}} <span class="counter hide" data-bind="css: {show: passwordCheck()}">OK</span></label>
			<input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value=""data-bind="value: itemConfirmed, valueUpdate: 'afterkeydown'">
		</div>
		<div class="form-buttons">
			{{link_to_route('api.user.password.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
		</div>
	</form>

@stop