@extends('cms::layouts.base')

@section('element-bar')
	@include('cms::partials.rightbars.rolebar')
@stop

@section('subbar')
	@include('cms::partials.subbars.role')
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/sections/role.js')}}
	{{Render::asset('scripts/sections/user.js')}}
	{{Render::asset('scripts/vm/role/settings.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.role.'.$section.'_title')}}</h3>

	<form role="form" id="role-settings-form">
		<input type="hidden" name="role_id" value="{{$role_id}}">
		<div class="form-group" rel="name">
			<label for="name" class="control-label">{{t('label.role.settings.name')}}</label>
			<input type="text" name="name" class="form-control" id="name" value="{{$name}}" data-bind="value: itemName, valueUpdate: 'afterkeydown'">
		</div>
		<div class="form-buttons">
			{{link_to_route('api.role.settings.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
			<a href="#delete-modal" class="btn btn-danger btn-block confirm">{{t('form.button.delete')}}</a>
		</div>
	</form>

@stop



@section('modal')

	<div class="modal-box" id="delete-modal">
		<button type="button" class="close close-modal">&times;</button>
		<h3>{{t('modal.title.delete_role')}}</h3>
		<form action="{{route('api.role.settings.delete')}}" method="POST">
			<input type="hidden" name="role_id" value="{{$role_id}}">
			<input type="hidden" name="name" value="{{$name}}" data-bind="value: itemName">
			<div class="form-group">
				<div class="checkbox">
					<label class="control-label">
						<input type="checkbox" name="force_delete" value="1">
						{{t('label.role.settings.force_delete')}}
					</label>
				</div>
			</div>
			<div class="form-buttons">				
				<button type="button" class="btn btn-default button close-modal">{{t('form.button.cancel')}}</button>
				<button type="submit" class="btn btn-danger">{{t('form.button.ok')}}</button>
			</div>
		</form>

	</div>

@stop