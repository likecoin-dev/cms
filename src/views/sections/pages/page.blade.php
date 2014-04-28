@extends('cms::layouts.base')

@section('content')
	
	<div class="section" id="page" data-id="">

		<div class="row">
			
			<div class="col-xs-2 side">
				
				<h2>{{t('sidebar.page.header')}}</h2>

				@include('cms::sections.page.partials.sidebar')

			</div>

			<div class="col-xs-10 main">
				
				<div class="breadcrumb-wrapper">

					<button class="toggle options-toggle">
						<i class="fa fa-bars"></i>
					</button>

					<ol class="breadcrumb">
						<li>{{strtoupper(LANG)}}</li>
						<li><a href="dashboard.html">Page</a></li>
						<li><a href="page.html">Sub Page</a></li>
					</ol>

				</div>
				
				<div class="tab-content">
					
					@include('cms::sections.page.partials.settings')

					@include('cms::sections.page.partials.layout')

					@include('cms::sections.page.partials.seo')

				</div>

			</div>

		</div>

	</div>

@stop

@section('footer-js')
	@parent
	{{Render::asset('js/pages/page.js')}}
@stop
