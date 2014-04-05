@foreach($items as $role)
	<li class="{{system_role_class($role->level, 'dl-item', 'dl-not')}}" data-id="{{$role->id}}">

		<div class="dl-handle full">
			
			<span>{{$role->name}}</span>

			@if(Access::isSystemRole($role->name))
				@if(Access::allowedCms($role->level))
					<span class="label label-danger">CMS</span>
				@else
					<span class="label label-default">SYS</span>
				@endif
			@endif

		</div>

		<a href="{{route('role.settings', array('role_id' => $role->id))}}"{{active($role->id, $role_id)}}>
			<i class="fa fa-chevron-left"></i>
		</a>

	</li>
@endforeach