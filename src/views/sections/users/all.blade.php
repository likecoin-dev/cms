@extends('cms::layouts.base')

@section('content')
	
	<h3>{{t('heading.user.'.$section.'_title')}}</h3>

	<ol class="all-paginate">
		
		<li class="head">
			<span>{{t('label.user.all.username')}}</span>
			<span>{{t('label.user.all.email')}}</span>
			<span>{{t('label.user.all.created_at')}}</span>
		</li>

		@foreach($users as $user)
		<li>
			<label>
				<input type="checkbox" value="{{$user->id}}"{{Tool::isChecked($user->is_active, 1)}} class="is_active">
				<span></span>
			</label>			
			<a href="{{route('user.settings', array('user_id' => $user->id))}}">
				<span>{{$user->username}}</span>
				<span>{{$user->email}}</span>
				<span>{{DT($user->created_at, '%d %B %Y')}}</span>				
			</a>
			<span class="dx-label">
				{{$user->role->name}}
			</span>
		</li>
		@endforeach

		{{$users->links()}}

	</ol>

@stop