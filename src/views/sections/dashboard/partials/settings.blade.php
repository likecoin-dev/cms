<div class="sidebar options right" id="options">
		
	<div class="sidebar-wrapper pongo-checking">
		
		<header>
			
			<h2>{{ t('sidebar.dashboard.settings') }}</h2>

		</header>
		
		<div class="blocks-wrapper pongo-setting pongo-enabling">			
				
			{{ Form::open(array('route' => 'api.settings.save')) }}
				
			<div class="form-group">

				<label for="site_live" class="flag loading">

					{{ Form::checkbox('site_live', 1, Pongo::settings('site_live'), array('class' => 'pongo-checkbox', 'id' => 'site_live')) }}
					
					<strong></strong>

					<span>{{ t('label.settings.site_live') }}</span>

				</label>

			</div>

			<div class="form-group">

				{{ Form::label('theme', t('label.settings.theme')) }}
			
				{{ Form::select('theme', Pongo::settings('themes'), Pongo::settings('theme'), array('class' => 'form-control', 'id' => 'theme')) }}

			</div>

			<div class="form-group">

				<label for="cache_enabled" class="flag loading">

					{{ Form::checkbox('cache_enabled', 1, Pongo::settings('cache_enabled'), array('class' => 'pongo-checkbox', 'id' => 'cache_enabled')) }}

					<strong></strong>

					<span>{{ t('label.settings.cache_enabled') }}<span>

				</label>

			</div>

			<div class="form-group">

				{{ Form::label('cache_time', t('label.settings.cache_time')) }}
			
				{{ Form::select('cache_time', Pongo::system('cache_time'), Pongo::settings('cache_time'), array('class' => 'form-control', 'id' => 'cache_time')) }}

			</div>

			<div class="form-group">

				{{ Form::label('per_page', t('label.settings.per_page')) }}
			
				{{ Form::select('per_page', Pongo::system('per_page'), Pongo::settings('per_page'), array('class' => 'form-control', 'id' => 'per_page')) }}

			</div>

			{{ Form::close() }}

		</div>

	</div>

</div>