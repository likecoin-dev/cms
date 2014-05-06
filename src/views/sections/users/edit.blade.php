@extends('cms::layouts.base')

@section('content')
	
	<div class="section">

		<div class="row">
			
			<div class="col-xs-2 side">
				
				<h2>{{ t('sidebar.user.header') }}</h2>

				@include('cms::sections.users.partials.sidebar', array('user' => $user))

			</div>

			<div class="col-xs-10 main">
				
				<div class="breadcrumb-wrapper">

					{{ Render::optionsToggle('fa-users') }}

					{{ Render::breadCrumb(array('dashboard', 'users'), $user->username) }}

				</div>
				
				<div class="tab-content">
					
					@include('cms::sections.users.partials.settings', array('user' => $user))

					@include('cms::sections.users.partials.password', array('user' => $user))

					@include('cms::sections.users.partials.details', array('user' => $user, 'input_form' => Pongo::forms('user_details')))

				</div>

			</div>

		</div>

	</div>

@stop

@section('sidebar-right')

	<div class="sidebar right" id="options">
		
		<div class="sidebar-wrapper">
			
			<header>
				
				<h2>{{ t('sidebar.user.user_role') }}</h2>

			</header>
			
			<div class="block-wrapper pongo-checking">
				
				{{ Form::open(array('route' => 'api.user.save.role', 'data-user' => $user->id)) }}
				<ol class="ol-nested right big pongo-select">
					
					{{ Load::roleList($user) }}

				</ol>
				{{ Form::close() }}

			</div>

		</div>

	</div>

@stop

@section('footer-js')
	@parent
	{{ Render::asset('js/sections/users/edit.js') }}
@stop
