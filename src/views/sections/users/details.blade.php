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
	{{Render::asset('scripts/vm/user/details.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.user.'.$section.'_title')}}</h3>

	{{Form::model($user_details, array('id' => 'user-details-form'))}}
		<input type="hidden" name="user_id" value="{{$user_id}}">
		
		{{Build::formFields($input_form, 'user.details')}}

		<div class="form-buttons">
			{{link_to_route('api.user.details.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
		</div>
	{{Form::close()}}

@stop