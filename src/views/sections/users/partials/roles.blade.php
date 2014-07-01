<div class="sidebar right" id="options">
		
	<div class="sidebar-wrapper">
		
		<header>
			
			<h2>{{ t('sidebar.user.user_role') }}</h2>

		</header>
		
		<div class="blocks-wrapper pongo-checking">
			
			{{ Form::open(array('route' => 'api.user.save.role', 'data-user' => $user['id'])) }}

			<ol class="ol-nested right big pongo-select">
				
				{{ Load::roleList($user) }}

			</ol>

			{{ Form::close() }}

		</div>

	</div>

</div>