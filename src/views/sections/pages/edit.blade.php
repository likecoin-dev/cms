@extends('cms::layouts.base')

@section('content')
	
	<div class="section">

		<div class="row">
			
			<div class="col-xs-2 side">
				
				<h2>{{ t('sidebar.page.header') }}</h2>

				@include('cms::sections.pages.partials.sidebar', array('page' => $page))

			</div>

			<div class="col-xs-10 main">
				
				<div class="breadcrumb-wrapper">

					{{ Render::breadCrumb(array('dashboard'), $page->name) }}

				</div>
				
				<div class="tab-content">
					
					@include('cms::sections.pages.partials.settings', array('page' => $page))
					
					@include('cms::sections.pages.partials.layout', array('page' => $page))
					
					@include('cms::sections.pages.partials.files', array('page' => $page))

					@include('cms::sections.pages.partials.seo', array('page' => $page))

				</div>

			</div>

		</div>

	</div>

@stop

@section('sidebar-right')

	@include('cms::sections.pages.partials.blocks', array('page' => $page))

@stop

@section('modal')
	@parent
	
	@include('cms::partials.modals.pongodelete', array('page_id' => $page->id, 'route' => 'api.block.delete'))
	@include('cms::partials.modals.pongodelete', array('page_id' => $page->id, 'target' => 'file', 'route' => 'api.file.delete'))

@stop

@section('footer-js')
	@parent
	{{ Render::asset('js/sections/pages/edit.js') }}
@stop
