@foreach($items as $role)
	<li>
		<p>{{ $role->name }}</p>
		<label>
			<input type="checkbox" value="{{$role->id}}" class="pongo-checkbox"{{ checked($role->id, $user->role_id) }}><span></span>
		</label>
	</li>
@endforeach