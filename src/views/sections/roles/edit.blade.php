@extends('cms::layouts.base')

@section('content')
	
	<div class="section">

		<div class="row">
			
			<div class="col-xs-2 side">
				
				<h2>{{ t('sidebar.role.header') }}</h2>

				@include('cms::sections.roles.partials.sidebar', array('role' => $role))

			</div>

			<div class="col-xs-10 main">
				
				<div class="breadcrumb-wrapper">

					{{ Render::breadCrumb('dashboard', 'roles') }}

				</div>
				
				<div class="tab-content">
					
					@include('cms::sections.roles.partials.settings', array('role' => $role))

				</div>

			</div>

		</div>

	</div>

@stop

@section('footer-js')
	@parent
	{{ Render::asset('js/sections/roles/edit.js') }}
@stop
