<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

	<button type="button" class="toggle pages-toggle">

		<i class="fa fa-sitemap"></i>

	</button>	
	
	<div class="navbar-header">

		<a class="navbar-brand" href="{{route('dashboard')}}">
			Pongo<span>CMS</span> <small>v2</small>
		</a>

	</div>
	
	<ul class="nav navbar-nav">
	
		{{ Render::sectionMenu() }}
	
	</ul>
	
	<ul class="nav navbar-nav navbar-right">
		
		<li class="dropdown">
			
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">

				<i class="fa fa-user"></i>

				{{ USERNAME }} <b class="caret"></b>

			</a>
			
			<ul class="dropdown-menu">
				
				<li class="dropdown-header">{{ t('menu.user_role') }}:</li>
				
				<li class="role">{{ link_to_route('user.edit', ROLENAME, array('user_id' => USERID)) }}</li>
				
				<li class="dropdown-header">{{ t('menu.cmslang') }}:</li>
				
				@foreach(Pongo::settings('languages') as $lang => $language)
				
				<li{{ active($lang, CMSLANG) }}>

					{{ link_to_route('lang', $language['lang'], array('lang' => $lang)) }}

				</li>
				
				@endforeach
				
				<li class="divider"></li>
				
				<li>{{ link_to_route('logout', 'Logout') }}</li>

			</ul>

		</li>

	</ul>

	<ul class="nav navbar-nav navbar-right live-nav pongo-live">
		<li>
			<button class="btn btn-primary pongo-live-off">{{ t('form.button.close') }}</button>
			<button class="btn btn-success froala-live-submit pongo-loading">{{ t('form.button.save') }}</button>
		</li>
	</ul>

</nav>