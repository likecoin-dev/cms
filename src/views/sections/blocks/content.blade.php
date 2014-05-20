@extends('cms::layouts.base')

@section('element-bar')
	@include('cms::partials.rightbars.contentbar')
@stop

@section('option-bar')
	@include('cms::partials.options.element')
@stop

@section('subbar')
	@include('cms::partials.subbars.file')
@stop

@section('header-js')
	@parent
	{{Render::asset('styles/magnific-popup.css')}}
@stop

@section('footer-js')
	@parent
	{{Render::asset('scripts/plugins/jquery.uploadfile.js')}}
	{{Render::asset('scripts/plugins/magnific-popup.js')}}
	{{Render::asset('scripts/tinymce/tinymce.min.js')}}
	{{Render::asset('scripts/sections/element.js')}}
	{{Render::asset('scripts/vm/element/content.js')}}
@stop

@section('content')
	
	<h3>{{t('heading.element.'.$section.'_title')}}</h3>

	<form role="form" id="element-content-form">
		<input type="hidden" name="page_id" value="{{$page_id}}">
		<input type="hidden" name="element_id" value="{{$element_id}}">
		<input type="hidden" id="name" value="{{$name}}">
		
		<div class="form-group">
			<textarea name="text" class="form-control" id="text">{{$text}}</textarea>
		</div>

		<div class="form-buttons">
			
			{{link_to_route('api.element.content.save', t('form.button.save'), null, array('class' => 'btn btn-success btn-block api'))}}

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
				<a href="" class="btn btn-danger api">{{t('form.button.ok')}}</a>
				<button type="button" class="btn btn-default button close-modal">{{t('form.button.cancel')}}</button>
			</div>
		</form>

	</div>

@stop