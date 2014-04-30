@foreach($items as $user)
	
	@if($user->role->level <= LEVEL)

	<li class="dd-item" data-id="{{$user->id}}">
		
		<a href="{{route('user.settings', array('user_id' => $user->id))}}"{{active($user->id, $user_id)}}>
			<i class="fa fa-chevron-left"></i>
		</a>

		<div class="dd-handle">

			<span>{{$user->username}}</span>

			<label>
				<input type="checkbox" value="{{$user->id}}" {{Tool::isChecked($user->is_active, 1)}} class="is_active">
				<span></span>
			</label>

		</div>

	</li>

	@endif

@endforeach

{{$items->links()}}