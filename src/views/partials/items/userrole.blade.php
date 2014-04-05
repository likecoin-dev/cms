@foreach($items as $key => $role)

	<li class="dd-item" data-id="{{$role->id}}">
		
		<div class="dd-handle">

			{{$role->name}}

			<label>
				<input type="checkbox" value="{{$role->id}}" class="user_role" data-level="{{$role->level}}"{{Tool::isChecked($role->id, $role_id)}}>
				<span></span>
			</label>

		</div>

	</li>

@endforeach