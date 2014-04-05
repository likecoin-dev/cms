@extends('cms::layouts.base')

@section('element-bar')
	@include('cms::partials.rightbars.filebar')
@stop

@section('subbar')
	@include('cms::partials.subbars.upload')
@stop

@section('header-js')
	@parent
	{{Render::asset('styles/magnific-popup.css')}}
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/plugins/magnific-popup.js')}}
	{{Render::asset('scripts/plugins/jquery.uploadfile.js')}}
	{{Render::asset('scripts/sections/file.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.page.files_title')}}</h3>

	<ul class="info-list">
		<li>{{t('label.page.files.mimes')}}: {{Pongo::settings('mimes')}}</li>
		<li>{{t('label.page.files.max_item')}}: 20</li>
		<li>{{t('label.page.files.max_upload')}}: {{Pongo::settings('max_upload_size')}} Mb</li>
	</ul>
	
	<div id="fileuploader">{{t('form.button.choose')}}</div>

	<h3>{{t('heading.page.files_create_title')}}</h3>

	<ul class="info-list">
		<li>{{t('label.page.files.custom_upload')}}</li>
		<li>{{t('label.page.files.ftp_upload')}}</li>
	</ul>

	<form role="form" id="page-files-form">
		<input type="hidden" name="page_id" value="{{$page_id}}">
		<div class="form-group size" rel="file_size">
			<label for="file_size" class="control-label">{{t('label.page.files.file_size')}}</label>
			<input type="text" name="file_size" class="form-control" id="file_size">
			<select name="size_type" class="form-control" id="size_type">
				<option value="kb">Kb</option>
				<option value="mb">Mb</option>
			</select>
		</div>
		<div class="form-group" rel="file_name">
			<label for="file_name" class="control-label">{{t('label.page.files.file_name')}}</label>
			<input type="text" name="file_name" class="form-control" id="file_name">
		</div>
		<div class="form-buttons">
			{{link_to_route('api.page.files.create', t('form.button.create'), null, array('class' => 'btn btn-success btn-block api'))}}
		</div>
	</form>

@stop


@section('modal')

	<div class="modal-box" id="delete-modal">
		<button type="button" class="close close-modal">&times;</button>
		<h3>{{t('modal.title.detach_file')}}</h3>
		<form method="POST">
			<input type="hidden" name="page_id" value="{{$page_id}}">
			<div class="form-group">
				<div class="checkbox">
					<label class="control-label">
						<input type="checkbox" name="force_delete" value="1">
						{{t('label.page.files.force_delete')}}
					</label>
				</div>
			</div>
			<div class="form-buttons">				
				<button type="button" class="btn btn-default button close-modal">{{t('form.button.cancel')}}</button>
				<a href="" class="btn btn-danger api">{{t('form.button.ok')}}</a>
			</div>
		</form>

	</div>

@stop