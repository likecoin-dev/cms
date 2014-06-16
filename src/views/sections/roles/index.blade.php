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

			<div class="col-xs-10 main list">
				
				<div class="breadcrumb-wrapper">

					{{ Load::breadCrumb(array('dashboard', 'roles')) }}

				</div>
				
 				<div class="tab-content">
					
					<div class="tab-pane active" id="roles">
						
						{{ Form::open(array('route' => 'api.role.valid')) }}

						<div class="dl nestable pongo-moving pongo-checking pongo-confirming">

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
										
										<label>
											<input type="checkbox" value="{{$role->id}}" class="pongo-checkbox"{{ checked($role->is_active, 1) }}><strong></strong>
										</label>
										
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
	@parent
	
	@include('cms::partials.modals.pongodelete', array('page_id' => null, 'route' => 'api.role.delete'))

@stop

@section('footer-js')
	@parent
	{{ Render::asset('js/sections/roles/index.js') }}
@stop
