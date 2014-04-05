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
	{{Render::asset('scripts/vm/page/settings.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.page.'.$section.'_title')}}</h3>

	<form role="form" id="page-settings-form">
		<input type="hidden" name="page_id" value="{{$page_id}}">
		<div class="form-group" rel="name">
			<label for="name" class="control-label">{{t('label.page.settings.name')}}</label>
			<input type="text" name="name" class="form-control" id="name" value="{{$name}}" data-bind="value: itemName, valueUpdate: 'afterkeydown'">
		</div>
		<div class="form-group" rel="slug_last">
			<label for="slug_last" class="control-label">{{t('label.page.settings.slug')}}</label>
			<div class="input-group">
				<input type="text" name="slug_last" class="form-control" id="slug_last" value="{{$slug_last}}" data-bind="value: slugLast, valueUpdate: 'afterkeydown'">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default button" data-bind="click: createSlug">{{t('label.page.settings.create_slug')}}</button>
				</span>
			</div>
			<input type="hidden" name="slug_base" id="slug_base" value="{{$slug_base}}">
			<input type="hidden" name="slug_full" value="" data-bind="value: slugFull">
		</div>

		<div class="form-group" rel="slug_full">
			<label for="slug_full" class="control-label">{{t('label.page.settings.slug_preview')}}</label>
			<input type="text" name="slug_full" class="form-control" id="slug_full" data-bind="value: slugFull" disabled>
		</div>

		<div class="form-group">
			<label for="wrapper_id" class="control-label">{{t('label.page.settings.may_contain')}}</label>
			<select name="wrapper_id" class="form-control" id="wrapper_id">
				@foreach($wrappers as $id => $wrapper)
				<option value="{{$id}}"{{selected($id, $wrapper_id)}}>{{t('form.select.' . $wrapper)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="role_level" class="control-label">{{t('label.page.settings.edit_by')}}</label>
			<select name="role_level" class="form-control" id="role_level">
				@foreach($admin_roles as $role => $level)
				<option value="{{$level}}"{{selected($level, $role_level)}}>{{t('form.select.' . $role)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="access_level" class="control-label">{{t('label.page.settings.browse_by')}}</label>
			<select name="access_level" class="form-control" id="access_level">
				@foreach($roles as $role)
				<option value="{{$role->level}}"{{selected($role->level, $access_level)}}>{{t('form.select.' . $role->name)}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<div class="checkbox">
				<label class="control-label">
					<input type="checkbox" name="is_home" value="1"{{checked($is_home, 1)}} data-bind="checked: pageHomeState">
					<span class="label" data-bind="css: pageHomeStatus">
						{{t('label.page.settings.set_hp')}}
					</span>
				</label>
			</div>
		</div>
		<div class="form-group">
			<div class="checkbox">
				<label class="control-label">
					<input type="checkbox" name="is_valid" value="1"{{checked($is_valid, 1)}} data-bind="checked: pageState">
					<span class="label" data-bind="css: pageStatus">
						<span data-bind="text: pageStatusLabel"></span>
					</span>
				</label>
			</div>
		</div>
		<div class="form-buttons">
			{{link_to_route('api.page.settings.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}
			<a href="#clone-modal" class="btn btn-primary btn-block confirm">{{t('form.button.clone')}}</a>
			<a href="#delete-modal" class="btn btn-danger btn-block confirm">{{t('form.button.delete')}}</a>
		</div>
	</form>

@stop



@section('modal')
	
	<div class="modal-box" id="clone-modal">
		<button type="button" class="close  close-modal">&times;</button>
		<h3>{{t('modal.title.clone_page')}}</h3>
		<form action="{{route('api.page.settings.clone')}}" method="POST">
			<input type="hidden" name="page_id" value="{{$page_id}}">
			<div class="form-group">
				<label for="lang" class="control-label">{{t('label.page.settings.choose_lang')}}</label>
				<select name="lang" class="form-control" id="lang">
					@foreach($languages as $code => $name)
					<option value="{{$code}}">{{$name['lang']}}</option>
					@endforeach
				</select>
			</div>			
			<div class="form-group">
				<label class="checkbox-inline">
					<input type="checkbox" id="clone_all"> {{t('label.page.settings.check_all_ele')}}
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" name="media_all" value="1"> {{t('label.page.settings.media_all')}}
				</label>
			</div>
			<div class="form-group cloning">
				<div class="cloning page">
					<ol class="second">
						{{Load::elementForm($page_id)}}
					</ol>
				</div>
			</div>
			<div class="form-buttons">
				<button type="button" class="btn btn-default button close-modal">{{t('form.button.cancel')}}</button>
				<button type="submit" class="btn btn-danger">{{t('form.button.ok')}}</button>
			</div>
		</form>
	</div>

	<div class="modal-box" id="delete-modal">
		<button type="button" class="close close-modal">&times;</button>
		<h3>{{t('modal.title.delete_page')}}</h3>
		<form action="{{route('api.page.settings.delete')}}" method="POST">
			<input type="hidden" name="page_id" value="{{$page_id}}">
			<div class="form-group">
				<div class="checkbox">
					<label class="control-label">
						<input type="checkbox" name="force_delete" value="1">
						{{t('label.page.settings.force_delete')}}
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