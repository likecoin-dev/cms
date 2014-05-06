@extends('cms::layouts.base')

@section('content')
	
	<div class="section">

		<div class="row">
			
			<div class="col-xs-2 side">
				
				<h2>{{ t('sidebar.user.header') }}</h2>
				
				<div class="side-wrapper">
					@include('cms::sections.users.partials.sidebar')
				</div>

			</div>

			<div class="col-xs-10 main">
				
				<div class="breadcrumb-wrapper search">
					
					{{ Render::breadCrumb('dashboard', 'users') }}
					
					{{ Render::searchForm('user', array('username', 'email', 'details:lastname', 'details:city', 'role:name', 'is_active')) }}

				</div>
				
 				<div class="tab-content">
					
					<div class="tab-pane active" id="users">

						{{ Form::open(array('route' => 'api.user.valid')) }}
						<div class="dl tab-wrapper pongo-checking pongo-confirming pongo-paginating">

							<ol class="dl-list ol-list pongo-active">
								
								@if($users->count())

									@foreach ($users as $user)
										<li class="dl-item" data-id="{{$user->id}}">
											<p class="dd-handle">{{$user->username}}</p>
											@if($user->role->level == Access::roleMaxLevel())
											<label class="fake"></label>
											@else
											<label><input type="checkbox" value="{{$user->id}}" class="pongo-checkbox"{{Tool::isChecked($user->is_active, 1)}}><span></span></label>
											@endif
											<div class="btn-edit">
												<a href="{{route('user.edit', array('user_id' => $user->id))}}" class="btn btn-sm btn-primary">
													<i class="fa fa-pencil-square-o"></i></a>
												@if($user->role->level != Access::roleMaxLevel())
												<a href="#" data-toggle="modal" data-target=".pongo-delete" data-id="{{$user->id}}" class="btn btn-sm btn-danger pongo-confirm">
													<i class="fa fa-trash-o"></i></a>
												@endif
											</div>
										</li>
									@endforeach

								@else
									
									{{ Render::noResult('search') }}

								@endif

							</ol>
						
							{{ isset($params) ? $users->appends($params)->links() : $users->links() }}

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
					<h4 class="modal-title">Are you sure?</h4>
				</div>
				<div class="modal-body buttons">
					{{ Form::open(array('route' => 'api.user.delete')) }}
					{{ Form::hidden('item_id') }}
					<button class="btn btn-sm btn-danger pongo-ajax-submit pongo-loading">{{t('form.button.delete')}}</button>
					<button class="btn btn-sm btn-primary" data-dismiss="modal">{{t('form.button.cancel')}}</button>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer-js')
	@parent
	{{Render::asset('js/sections/users/index.js')}}
@stop
