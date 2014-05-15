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
					
					{{ Render::breadCrumb(array('dashboard', 'users')) }}
					
					{{ Render::searchForm('user', array('username', 'email', 'details:lastname', 'details:city', 'role:name', 'is_active')) }}

				</div>
				
 				<div class="tab-content">
					
					<div class="tab-pane active" id="users">

						{{ Form::open(array('route' => 'api.user.valid')) }}

						<div class="dl tab-wrapper pongo-checking pongo-confirming pongo-paginating">

							<ol class="dl-list ol-list pongo-active">
								
								@if($users->count())

									@foreach ($users as $user)
										
										<li class="dl-item" data-id="{{ $user->id }}">

											<p class="dd-handle">{{ $user->username }}</p>
											
											@if($user->role->level == Access::roleMaxLevel())
											
											<label class="fake"></label>
											
											@else
											
											<label>
												<input type="checkbox" value="{{$user->id}}" class="pongo-checkbox"{{ checked($user->is_active, 1) }}>
												<span></span>
											</label>
											
											@endif
											
											<div class="btn-edit">
												
												<a href="{{ route('user.edit', array('user_id' => $user->id)) }}" class="btn btn-sm btn-primary">
													<i class="fa fa-pencil-square-o"></i></a>
												
												@if($user->role->level != Access::roleMaxLevel())
												
												<a href="#" data-toggle="modal" data-target=".pongo-delete" data-id="{{ $user->id }}" class="btn btn-sm btn-danger pongo-confirm">
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
	@parent

	@include('cms::partials.modals.pongodelete', array('page_id' => null, 'route' => 'api.user.delete'))

@stop

@section('footer-js')
	@parent
	{{Render::asset('js/sections/users/index.js')}}
@stop
