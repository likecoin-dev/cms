@extends('cms::layouts.base')

@section('content')
	
	<div class="section">

		<div class="row">
			
			<div class="col-xs-2 side">
				
				<h2>{{ t('sidebar.role.header') }}</h2>
				
				<div class="side-wrapper">
					@include('cms::sections.roles.partials.sidebar')	
				</div>

			</div>

			<div class="col-xs-10 main">
				
				<div class="breadcrumb-wrapper">
					
					{{ Render::breadCrumb(array('dashboard', 'roles')) }}

				</div>
				
 				<div class="tab-content">
					
					<div class="tab-pane active" id="roles">
						
						{{ Form::open(array('route' => 'api.role.valid')) }}
						<div class="dl tab-wrapper pongo-moving pongo-checking pongo-confirming">

							<ol class="dl-list ol-list pongo-active">

								@foreach ($roles as $role)
									
									@if(Access::isSystemRole($role->name))
									<li class="{{(Access::roleMaxLevel() == $role->level) ? 'dl-not' : 'dl-item move'}}" data-id="{{$role->id}}">
										<p class="dd-passive">{{ $role->name }}</p>
										@if(Access::allowedCms($role->level))
											<span class="label label-success">CMS</span>
										@else
											<span class="label label-default">SYS</span>
										@endif
										<label class="fake"></label>
									@else
									<li class="dl-item move" data-id="{{ $role->id }}">
										<p class="dd-handle">{{ $role->name }}</p>
										<label><input type="checkbox" value="{{$role->id}}" class="pongo-checkbox"{{ Tool::isChecked($role->is_active, 1) }}><span></span></label>
										<div class="btn-edit">
											<a href="{{ route('role.edit', array('role_id' => $role->id)) }}" class="btn btn-sm btn-primary">
												<i class="fa fa-pencil-square-o"></i></a>
											<a href="#" data-toggle="modal" data-target=".pongo-delete" data-id="{{ $role->id }}" class="btn btn-sm btn-danger pongo-confirm">
												<i class="fa fa-trash-o"></i></a>
										</div>
										@endif
									</li>
								@endforeach

							</ol>

						</div>
						{{ Form::close() }}

					</div>

				</div>

			</div>

		</div>

	</div>

@stop

@section('modal')
	<div class="modal fade pongo-delete" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-center modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">{{ t('modal.title.are_you_sure') }}</h4>
				</div>
				<div class="modal-body buttons">
					{{ Form::open(array('route' => 'api.role.delete')) }}
					{{ Form::hidden('item_id') }}
					<button class="btn btn-sm btn-danger pongo-ajax-submit pongo-loading">{{ t('form.button.delete') }}</button>
					<button class="btn btn-sm btn-primary" data-dismiss="modal">{{ t('form.button.cancel') }}</button>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer-js')
	@parent
	{{ Render::asset('js/sections/roles/index.js') }}
@stop
