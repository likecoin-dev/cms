@extends('cms::layouts.base')

@section('content')
	
	<div class="section">

		<div class="row">

			<div class="col-xs-10 main">
				
				<div class="breadcrumb-wrapper">

					{{ Render::optionsToggle('fa-tasks') }}

					{{ Render::toolsToggle('fa-cog') }}

					{{ Load::breadCrumb(array('dashboard', 'page' => $page_id, 'zone' => $block->zone), $block->name) }}

				</div>
				
				<div class="tab-content">
					
					@include('cms::sections.blocks.partials.content', array('block' => $block))

					@include('cms::sections.blocks.partials.settings', array('block' => $block))					

				</div>

			</div>

			<div class="col-xs-2 side right">
				
				<h2>{{ t('sidebar.block.header') }}</h2>

				@include('cms::sections.blocks.partials.sidebar', array('block' => $block))

				<h2 class="after">{{ t('sidebar.block.page_layout') }}</h2>
				
				<div class="side-wrapper">

					{{ Load::layoutPreview($page_id, null, $block->zone, false, 'small') }}

				</div>

			</div>

		</div>

	</div>

@stop

@section('sidebar-right')

	@include('cms::sections.pages.partials.blocks', array('block_id' => $block->id, 'zone' => $block->zone))

@stop

@section('modal')
	@parent
	
	@include('cms::partials.modals.pongodelete', array('page_id' => $page_id, 'route' => 'api.block.delete'))
	@include('cms::partials.modals.blockcopy', array('page_id' => $page_id, 'route' => 'api.block.copy'))

@stop

@section('lib-js')

{{ Render::asset('js/lib/froala_editor.min.js') }}
{{ Render::assetLang('js/langs') }}

@stop

@section('footer-js')
	@parent

	{{ Render::asset('js/sections/blocks/edit.js') }}
@stop
